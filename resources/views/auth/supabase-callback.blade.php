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
            {{-- <img src="{{ asset('assets/images/zangbeto.jpg') }}" class="loader-logo" alt="Loading..."> --}}
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

    <script>
        (function() {
            // 1) Récupérer le fragment : "#access_token=...&refresh_token=..."
            const hash = window.location.hash.substring(1); // enlève le '#'
            const params = new URLSearchParams(hash);

            const accessToken = params.get('access_token');
            const refreshToken = params.get('refresh_token');

            if (!accessToken) {
                alert("Impossible de récupérer le token Supabase.");
                console.error("Hash reçu :", hash);
                return;
            }

            // 2) Envoyer au backend Laravel
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
                }),
            })
            .then(async (response) => {
                const data = await response.json();
                if (!response.ok || !data.success) {
                    console.error("Réponse Supabase/Laravel :", data);
                    alert(data.message || "Erreur lors de la connexion.");
                    return;
                }

                // 3) Redirection vers le dashboard (ou autre)
                window.location.href = data.redirect || "/dashboard";
            })
            .catch((error) => {
                console.error("Erreur réseau :", error);
                alert("Erreur réseau lors de l'authentification.");
            });
        })();
    </script>
</body>
</html>
