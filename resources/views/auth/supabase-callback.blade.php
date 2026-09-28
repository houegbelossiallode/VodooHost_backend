<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion en cours...</title>
    <!-- css   -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <style>
        body { min-height: 100vh; display: grid; place-items: center; margin: 0; padding: 24px; background: #f4f6f8; font-family: Arial, sans-serif; }
        .oauth-card { width: min(100%, 460px); padding: 32px; background: #fff; border: 1px solid #e2e6ea; border-radius: 12px; box-shadow: 0 12px 36px #17212b12; text-align: center; }
        .oauth-card h1 { margin: 0 0 10px; color: #202a34; font-size: 24px; }
        .oauth-card p { color: #596774; line-height: 1.5; }
    </style>
    <!--  favicons  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
</head>
<body>
    <main class="oauth-card">
        <h1 id="status-title">Connexion Google</h1>
        <p id="status-message" role="status">Vérification de votre compte...</p>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script>
        (async function() {
            if (typeof window.supabase === 'undefined') {
                showError('Erreur de chargement du SDK Supabase.');
                return;
            }

            const supabaseUrl = '{{ config('services.supabase.url') }}';
            const supabaseAnonKey = '{{ config('services.supabase.anon_key') }}';
            const supabaseClient = window.supabase.createClient(supabaseUrl, supabaseAnonKey);
            let accessToken = null;
            let refreshToken = null;

            function finishInOpener(message) {
                if (!window.opener || window.opener.closed) return false;
                window.opener.postMessage(message, window.location.origin);
                window.close();
                return true;
            }

            async function sendTokensToBackend(roleSlug = null) {
                const payload = {
                    access_token: accessToken,
                    refresh_token: refreshToken,
                };
                if (roleSlug) payload.role_slug = roleSlug;

                const response = await fetch("{{ route('hoost.supabase.handle') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });
                const data = await response.json();

                if (!response.ok || !data.success) {
                    showError(data.message || 'Erreur lors de la connexion.');
                    return;
                }

                if (data.needs_profile) {
                    if (finishInOpener({
                        type: 'google-profile-required',
                        access_token: accessToken,
                        refresh_token: refreshToken,
                    })) return;

                    sessionStorage.setItem('google_oauth_access_token', accessToken);
                    sessionStorage.setItem('google_oauth_refresh_token', refreshToken || '');
                    window.location.replace('/login?google_profile=complete');
                    return;
                }

                const redirect = data.redirect || '/hoost/home';
                if (finishInOpener({ type: 'google-auth-success', redirect })) return;

                sessionStorage.removeItem('social_slug');
                window.location.href = redirect;
            }

            function showError(message) {
                if (finishInOpener({ type: 'google-auth-error', message })) return;
                document.getElementById('status-title').textContent = 'Connexion impossible';
                document.getElementById('status-message').textContent = message;
            }

            try {
                const urlParams = new URLSearchParams(window.location.search);
                const oauthError = urlParams.get('error');
                if (oauthError) {
                    showError('Erreur OAuth : ' + oauthError);
                    return;
                }

                const { data: sessionData, error: sessionError } = await supabaseClient.auth.getSession();
                if (sessionError) throw sessionError;

                let session = sessionData.session;
                if (!session) {
                    const code = urlParams.get('code');
                    if (code) {
                        const { data: exchangedData, error: exchangeError } = await supabaseClient.auth.exchangeCodeForSession(code);
                        if (exchangeError) throw exchangeError;
                        session = exchangedData.session;
                    }
                }

                if (session) {
                    accessToken = session.access_token;
                    refreshToken = session.refresh_token;
                } else {
                    const hashParams = new URLSearchParams(window.location.hash.substring(1));
                    accessToken = hashParams.get('access_token');
                    refreshToken = hashParams.get('refresh_token');
                }

                if (!accessToken) {
                    showError('Impossible de récupérer le token Supabase.');
                    return;
                }

                await sendTokensToBackend();
            } catch (error) {
                console.error('Erreur OAuth:', error);
                showError("Erreur lors de l'authentification : " + error.message);
            }
        })();
    </script>
</body>
</html>
