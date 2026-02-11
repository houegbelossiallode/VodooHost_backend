<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de réception</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f3f4f7;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            color: #333333;
        }
        .wrapper {
            width: 100%;
            background-color: #f3f4f7;
            padding: 30px 0;
        }
        .container {
            max-width: 620px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 14px;
            overflow: hidden;
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            padding: 35px 30px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }
        .content {
            padding: 30px;
            font-size: 15px;
            line-height: 1.7;
        }
        .content strong {
            color: #111827;
        }
        .message-box {
            background-color: #f8fafc;
            border-left: 4px solid #3b82f6;
            padding: 18px;
            margin: 18px 0;
            border-radius: 6px;
            font-size: 14px;
            color: #374151;
        }
        .footer {
            padding: 25px 25px 15px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
        @media (max-width: 640px) {
            .container { border-radius: 0; }
            .content { padding: 22px; }
            .header { padding: 28px 20px; }
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container">

            <!-- Header -->
            <div class="header">
                <h1>Votre message a bien été reçu</h1>
            </div>

            <!-- Content -->
            <div class="content">
                <p>Bonjour <strong>{{ $contact->prenom }}</strong>,</p>

                <p>
                    Nous vous remercions d’avoir contacté <strong>{{ config('app.name') }}</strong>.
                    Votre message a bien été enregistré et notre équipe prendra contact avec vous dans les plus brefs délais.
                </p>

                <div class="message-box">
                    <strong>Votre message :</strong><br>
                    {{ $contact->message }}
                </div>

                <p>
                    Si vous avez des informations supplémentaires à ajouter, vous pouvez répondre directement à cet email.
                </p>

                <p style="margin-top: 25px;">
                    Cordialement,<br>
                    <strong>L’équipe {{ config('app.name') }}</strong>
                </p>
            </div>

            <!-- Footer -->
            <div class="footer">
                &copy; {{ date('Y') }} {{ config('app.name') }} — Tous droits réservés.
            </div>

        </div>
    </div>
</body>
</html>
