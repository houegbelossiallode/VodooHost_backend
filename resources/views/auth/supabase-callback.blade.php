<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion en cours...</title>
    <!-- css   -->
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ asset('assets/css/color.css') }}">
    <!--  favicons  -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
</head>
<body>

    <div class="loader-wrap">
        <div class="loader-inner">
            <svg>
                <defs>
                    <filter id="goo">
                        <fegaussianblur in="SourceGraphic" stdDeviation="2" result="blur" />
                        <fecolormatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 5 -2"
                            result="gooey" />
                        <fecomposite in="SourceGraphic" in2="gooey" operator="atop" />
                    </filter>
                </defs>
            </svg>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
    <script>
        (async function() {
            const supabaseUrl = '{{ config('services.supabase.url') }}';
            const supabaseAnonKey = '{{ config('services.supabase.anon_key') }}';
            const supabase = supabase.createClient(supabaseUrl, supabaseAnonKey);

            try {
                // Récupérer la session Supabase après la redirection OAuth
                const { data: { session }, error } = await supabase.auth.getSession();

                if (error) {
                    console.error("Erreur session Supabase:", error);
                    alert("Impossible de récupérer la session Supabase.");
                    return;
                }

                if (!session) {
                    // Si pas de session, essayer de récupérer depuis l'URL hash
                    const hash = window.location.hash.substring(1);
                    const params = new URLSearchParams(hash);
                    const accessToken = params.get('access_token');

                    if (!accessToken) {
                        alert("Impossible de récupérer le token Supabase.");
                        console.error("Hash reçu :", hash);
                        return;
                    }

                    // Envoyer directement les tokens du hash
                    const refreshToken = params.get('refresh_token');
                    sendTokensToBackend(accessToken, refreshToken);
                } else {
                    // Envoyer les tokens de la session
                    sendTokensToBackend(session.access_token, session.refresh_token);
                }
            } catch (err) {
                console.error("Erreur:", err);
                alert("Erreur lors de l'authentification.");
            }

            function sendTokensToBackend(accessToken, refreshToken) {
                // Récupérer le rôle depuis sessionStorage
                const roleSlug = sessionStorage.getItem('social_slug') || 'visitor';

                fetch("{{ route('hoost.supabase.handle') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        "Accept": "application/json",
                    },
                    body: JSON.stringify({
                        access_token: accessToken,
                        refresh_token: refreshToken,
                        role_slug: roleSlug,
                    }),
                })
                .then(async (response) => {
                    const data = await response.json();
                    if (!response.ok || !data.success) {
                        console.error("Réponse Supabase/Laravel :", data);
                        alert(data.message || "Erreur lors de la connexion.");
                        return;
                    }

                    // Nettoyer sessionStorage
                    sessionStorage.removeItem('social_slug');

                    // Redirection vers le dashboard
                    window.location.href = data.redirect || "/dashboard";
                })
                .catch((error) => {
                    console.error("Erreur réseau :", error);
                    alert("Erreur réseau lors de l'authentification.");
                });
            }
        })();
    </script>
</body>
</html>
