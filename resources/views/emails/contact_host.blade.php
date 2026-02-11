<!DOCTYPE html>
<html lang="fr" style="margin:0;padding:0;">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Nouveau message d’un visiteur</title>
<style>
    body {
        font-family: Arial, sans-serif;
        background:#f5f6f8;
        margin:0;
        padding:0;
        color:#333;
    }
    .container {
        width:100%;
        max-width:600px;
        margin:0 auto;
        background:#fff;
        border-radius:8px;
        overflow:hidden;
        box-shadow:0 2px 10px rgba(0,0,0,.08);
    }
    .header {
        background:#D1B11B; /* Gold Voodoo Hoost */
        color:#fff;
        text-align:center;
        padding:25px 15px;
        font-size:22px;
        font-weight:bold;
    }
    .content {
        padding:30px 25px;
        line-height:1.6;
        font-size:16px;
    }
    .box {
        background:#fafafa;
        border-left:4px solid #D1B11B;
        padding:15px 18px;
        margin:20px 0;
        border-radius:4px;
    }
    .label {
        font-weight:bold;
        color:#555;
    }
    .button {
        display:inline-block;
        background:#D1B11B;
        padding:14px 28px;
        color:#fff !important;
        font-size:16px;
        text-decoration:none;
        border-radius:6px;
        font-weight:bold;
        margin:25px 0;
    }
    .button:hover { opacity:.92; }
    .footer {
        text-align:center;
        padding:18px;
        font-size:14px;
        color:#777;
        background:#fafafa;
    }
    @media (max-width:600px) {
        .content{padding:22px 15px;}
        .button{width:100%;text-align:center;}
    }
</style>
</head>
<body>

<div class="container">
    <div class="header">
        Nouveau message d’un visiteur
    </div>

    <div class="content">
        <p>Bonjour <strong>{{ $host->prenom ?? 'Cher hôte' }}</strong>,</p>

        <p>Un visiteur souhaite entrer en contact avec vous via <strong>Voodoo Hoost</strong> 🏡.</p>

        <div class="box">
            <p><span class="label">Nom :</span> {{ $data['prenom'] }} {{ $data['nom'] }}</p>
            <p><span class="label">Email :</span> {{ $data['email'] }}</p>

            @if($logement)
                <p><span class="label">Logement concerné :</span> {{ $logement->titre }}</p>
            @else
                <p><em>Le visiteur vous a contacté depuis la page d’accueil (sans logement spécifique).</em></p>
            @endif
        </div>

        <div class="box">
            <p class="label">Message du visiteur :</p>
            <p>{{ $data['message'] }}</p>
        </div>

        <p style="text-align:center;">
            <strong>Vous pouvez répondre directement à cet email.</strong><br>
            Votre réponse sera envoyée automatiquement au visiteur.
        </p>

        <p style="text-align:center;">
            <a href="{{ config('app.url') }}" class="button">
                Accéder à Voodoo Hoost
            </a>
        </p>

        <p>Merci de faire vivre l’expérience culturelle et humaine de <strong>Voodoo Hoost</strong> ✨</p>
    </div>

    <div class="footer">
        © 2025 Voodoo Hoost<br>
        <small>Connectez voyageurs & hôtes. Découvrez culture, rituels & hospitalité.</small>
    </div>
</div>

</body>
</html>
