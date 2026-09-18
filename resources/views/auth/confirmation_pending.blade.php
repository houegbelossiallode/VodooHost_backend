<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Confirmation en attente</title>
  <style>body{font-family:Arial,Helvetica,sans-serif;margin:40px;color:#222}a.button{display:inline-block;margin-top:16px;padding:10px 16px;background:#e53e3e;color:#fff;border-radius:6px;text-decoration:none}</style>
</head>
<body>
  <h1>Confirmation en attente</h1>
  <p>Nous n'avons pas trouvé la confirmation pour cette adresse. Si vous venez de cliquer sur le lien, patientez quelques instants puis réessayez.</p>
  @php
    $redirect = env('FRONTEND_CONFIRM_SUCCESS', '/login');
  @endphp
  <p><a class="button" href="{{ $redirect }}">Aller à la connexion</a></p>
</body>
</html>
