{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f4f4f4; padding: 20px 0;">
        <tr>
            <td align="center">
                <table width="600px" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                    <tr>
                        <td align="center" style="background-color: #4CAF50; padding: 20px;">
                            <h1 style="color: #ffffff; font-size: 24px; margin: 0;">Réinitialisation de votre mot de passe</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 20px; text-align: left; color: #333333;">
                            <p style="font-size: 16px; margin: 0 0 10px;">Bonjour <strong>{{ $user->name }}</strong>,</p>
                            <p style="font-size: 16px; margin: 0 0 10px;">Votre mot de passe a été réinitialisé avec succès. Voici votre nouveau mot de passe :</p>
                            <p style="font-size: 18px; font-weight: bold; text-align: center; background-color: #f8f8f8; padding: 10px; border-radius: 5px; margin: 20px 0;">
                                {{ $password }}
                            </p>
                            <p style="font-size: 16px; margin: 0 0 10px;">Nous vous recommandons de le changer dès votre prochaine connexion pour garantir la sécurité de votre compte.</p>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px; background-color: #f8f8f8;">
                            <p style="font-size: 14px; color: #555555; margin: 0;">Merci,</p>
                            <p style="font-size: 14px; color: #555555; margin: 0;">L'équipe FC ELOHIM</p>
                            <p style="font-size: 14px; color: #555555; margin: 0;">[FinexMoon]</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html> --}}


{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f9f9f9; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9f9f9; padding: 30px 0;">
        <tr>
            <td align="center">
                <table width="600px" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);">
                    <!-- En-tête -->
                    <tr>
                        <td align="center" style="background-color: #007bff; padding: 20px;">
                            <h1 style="color: #ffffff; font-size: 24px; margin: 0;">Mot de Passe Réinitialisé</h1>
                        </td>
                    </tr>
                    
                    <!-- Contenu principal -->
                    <tr>
                        <td style="padding: 30px; text-align: left; color: #333333;">
                            <p style="font-size: 16px; margin: 0 0 15px;">
                                Bonjour <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="font-size: 16px; margin: 0 0 15px;">
                                Nous avons réinitialisé votre mot de passe. Voici vos nouvelles informations de connexion :
                            </p>
                            <table width="100%" style="margin: 20px 0;">
                                <tr>
                                    <td style="background-color: #f1f1f1; padding: 15px; text-align: center; border-radius: 5px; font-size: 18px; font-weight: bold; color: #333;">
                                        {{ $password }}
                                    </td>
                                </tr>
                            </table>
                            <p style="font-size: 16px; margin: 0 0 15px;">
                                Nous vous recommandons de changer ce mot de passe dès votre première connexion pour garantir la sécurité de votre compte.
                            </p>
                            <p style="font-size: 16px; margin: 0;">
                                Si vous n'avez pas demandé cette réinitialisation, veuillez nous contacter immédiatement.
                            </p>
                        </td>
                    </tr>

                    <!-- Bouton -->
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <a href="{{ url('/') }}" style="display: inline-block; padding: 12px 25px; background-color: #007bff; color: #ffffff; text-decoration: none; font-size: 16px; border-radius: 5px;">
                                Accéder à votre compte
                            </a>
                        </td>
                    </tr>
                    
                    <!-- Pied de page -->
                    <tr>
                        <td align="center" style="background-color: #f1f1f1; padding: 20px;">
                            <p style="font-size: 14px; color: #555555; margin: 0;">Merci,</p>
                            <p style="font-size: 14px; color: #555555; margin: 0;">L'équipe de [Nom de votre site]</p>
                            <p style="font-size: 12px; color: #999999; margin: 10px 0 0;">
                                Cet email est généré automatiquement. Veuillez ne pas répondre.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html> --}}

{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .body {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }
        .body h2 {
            font-size: 20px;
            color: #4CAF50;
            margin-bottom: 15px;
        }
        .password-box {
            background: #f9f9f9;
            border: 1px dashed #4CAF50;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #333333;
            border-radius: 5px;
            margin: 20px 0;
        }
        .button-container {
            text-align: center;
            margin: 20px 0;
        }
        .button-container a {
            display: inline-block;
            background: #4CAF50;
            color: #ffffff;
            padding: 12px 25px;
            text-decoration: none;
            font-size: 16px;
            border-radius: 5px;
        }
        .footer {
            background: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #555555;
        }
        .footer p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- En-tête -->
        <div class="header">
            <h1>Votre mot de passe a été réinitialisé</h1>
        </div>

        <!-- Contenu principal -->
        <div class="body">
            <h2>Bonjour {{ $user->name }},</h2>
            <p>Nous avons réinitialisé votre mot de passe avec succès. Voici vos nouvelles informations de connexion :</p>
            <div class="password-box">
                {{ $password }}
            </div>
            <p>Nous vous recommandons fortement de changer ce mot de passe après votre connexion pour garantir la sécurité de votre compte.</p>

            <div class="button-container">
                <a href="{{ url('/') }}">Accéder à votre compte</a>
            </div>

            <p>Si vous n'êtes pas à l'origine de cette demande, veuillez nous contacter immédiatement.</p>
        </div>

        <!-- Pied de page -->
        <div class="footer">
            <p>Merci,</p>
            <p>L'équipe de FC ELOHIM</p>
            <p>Cet email est généré automatiquement, veuillez ne pas répondre.</p>
        </div>
    </div>
</body>
</html> --}}


{{-- <!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation du mot de passe</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            background-color: #f5f7fa;
            color: #333;
            padding: 40px;
        }
        .container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 30px;
            max-width: 500px;
            margin: 0 auto;
        }
        .btn {
            background-color: #4F46E5;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 6px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn:hover {
            background-color: #3730A3;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Bonjour {{ $user->name }},</h2>
    <p>Vous avez demandé à réinitialiser votre mot de passe.</p>
    <p>Cliquez sur le bouton ci-dessous pour le réinitialiser :</p>

    <a href="{{ $url }}" class="btn">Réinitialiser le mot de passe</a>

    <p>Si vous n'êtes pas à l'origine de cette demande, ignorez simplement cet e-mail.</p>

    <div class="footer">
        &copy; {{ date('Y') }} Tous droits réservés.
    </div>
</div>
</body>
</html> --}}



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Réinitialisation de votre mot de passe</title>
    <style>
        /* ------- Styles de base ------- */
        body {
            font-family: "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* ------- Conteneur principal ------- */
        .email-wrapper {
            width: 100%;
            background-color: #f4f6f8;
            padding: 40px 0;
        }

        .email-content {
            max-width: 600px;
            background-color: #ffffff;
            margin: 0 auto;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.08);
        }

        /* ------- En-tête ------- */
        .email-header {
            background: linear-gradient(135deg, #4F46E5, #3B82F6);
            padding: 30px;
            text-align: center;
        }

        .email-header img {
            width: 80px;
            margin-bottom: 10px;
        }

        .email-header h1 {
            color: #ffffff;
            font-size: 20px;
            margin: 0;
            font-weight: 500;
        }

        /* ------- Contenu principal ------- */
        .email-body {
            padding: 30px;
            color: #444;
            line-height: 1.6;
        }

        .email-body h2 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #111827;
        }

        .email-body p {
            font-size: 15px;
            margin: 8px 0;
        }

        /* ------- Bouton ------- */
        .btn {
            display: inline-block;
            background: linear-gradient(135deg, #4F46E5, #3B82F6);
            color: #fff !important;
            text-decoration: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 500;
            margin-top: 25px;
            box-shadow: 0 4px 10px rgba(79,70,229,0.3);
        }

        .btn:hover {
            background: linear-gradient(135deg, #4338CA, #2563EB);
        }

        /* ------- Footer ------- */
        .email-footer {
            background-color: #f9fafb;
            text-align: center;
            padding: 20px;
            font-size: 13px;
            color: #6b7280;
        }

        .email-footer a {
            color: #4F46E5;
            text-decoration: none;
        }

        .divider {
            height: 1px;
            background-color: #e5e7eb;
            margin: 25px 0;
        }
    </style>
</head>

<body>
    <div class="email-wrapper">
        <div class="email-content">
            <!-- En-tête -->
            <div class="email-header">
                {{-- <img src="{{ asset('assets/images/fmoon-petit.png') }}" alt="Logo FinexMoon"> --}}
                <h1>Réinitialisation de votre mot de passe</h1>
            </div>

            <!-- Corps -->
            <div class="email-body">
                <h2>Bonjour {{ $user->nom . ' ' .$user->prenom}},</h2>
                <p>Nous avons reçu une demande de réinitialisation de votre mot de passe pour votre compte <strong>VODOOU HOOST</strong>.</p>
                <p>Pour choisir un nouveau mot de passe, cliquez sur le bouton ci-dessous :</p>

                <p style="text-align:center;">
                    <a href="{{ $url }}" class="btn">Réinitialiser mon mot de passe</a>
                </p>

                {{-- <p>Ce lien expirera dans <strong>60 minutes</strong> pour des raisons de sécurité.</p> --}}

                <div class="divider"></div>

                <p>Si vous n'êtes pas à l'origine de cette demande, vous pouvez ignorer cet e-mail — votre mot de passe restera inchangé.</p>
            </div>

            <!-- Pied de page -->
            <div class="email-footer">
                <p>&copy; {{ date('Y') }} <strong>FinexMoon</strong>. Tous droits réservés.</p>
                {{-- <p>
                    <a href="#">www.finexmoon.com</a> |
                    <a href="mailto:support@finexmoon.com">support@finexmoon.com</a>
                </p> --}}
            </div>
        </div>
    </div>
</body>
</html>