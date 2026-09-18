<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Email confirmé</title>
  <style>body{font-family:Arial,Helvetica,sans-serif;margin:40px;color:#222}a.button{display:inline-block;margin-top:16px;padding:10px 16px;background:#2b6cb0;color:#fff;border-radius:6px;text-decoration:none}</style>
</head>
<body>
  <h1>Email confirmé</h1>
  <p>Merci — votre adresse e‑mail a été confirmée avec succès.</p>
  <p>Vous pouvez fermer cette fenêtre et vous connecter dans l'application.</p>
  @php
    $redirect = env('FRONTEND_CONFIRM_SUCCESS', '/login');
  @endphp
  <p><a class="button" href="{{ $redirect }}">Aller à la connexion</a></p>

  <script>
    // Si Supabase a renvoyé le token dans le fragment (location.hash), on le forward vers l'URL front appropriée
    try {
      const hash = window.location.hash || '';
      if (hash.includes('access_token')) {
        const params = new URLSearchParams(hash.replace('#', ''));
        const token = params.get('access_token');
        if (token) {
          // FRONTEND_SUCCESS_WITH_TOKEN doit être configuré dans .env (ex: https://app.vodoohost.com/#access_token={access_token})
          const targetTemplate = '{{ env('FRONTEND_SUCCESS_WITH_TOKEN', '') }}';
          if (targetTemplate && targetTemplate.includes('{access_token}')) {
            const target = targetTemplate.replace('{access_token}', token);
            window.location.replace(target);
          } else {
            // si pas de template, on redirige vers la page front en conservant le fragment
            const defaultTarget = '{{ env('FRONTEND_CONFIRM_SUCCESS', '/') }}';
            window.location.replace(defaultTarget + hash);
          }
        }
      }
    } catch (e) {
      // ignore
    }
  </script>
</body>
</html>
