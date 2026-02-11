<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation...</title>
</head>
<body>
    <p>Redirection en cours...</p>

    <script>
        (function () {
            // Récupérer le fragment sans le '#'
            const hash = window.location.hash.substring(1);
            if (!hash) return;

            const params = new URLSearchParams(hash);
            const accessToken = params.get('access_token');
            const type = params.get('type');

            if (!accessToken) {
                // Rien à faire, on laisse la page comme ça
                return;
            }

            // Reconstituer l'URL sans le fragment
            const baseUrl = window.location.origin + window.location.pathname;
            const url = new URL(baseUrl);

            url.searchParams.set('access_token', accessToken);
            if (type) {
                url.searchParams.set('type', type);
            }

            // Optionnel : tu peux aussi passer refresh_token, expires_at, etc.
            const refreshToken = params.get('refresh_token');
            if (refreshToken) {
                url.searchParams.set('refresh_token', refreshToken);
            }

            // Redirection vers la même route mais avec query string
            window.location.replace(url.toString());
        })();
    </script>
</body>
</html>