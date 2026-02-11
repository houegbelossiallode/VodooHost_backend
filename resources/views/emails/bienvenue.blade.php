<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Bienvenue chez Voodoo Hoost</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        /* Reset simple */
        body, table, td, p, a {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

      /**  body {
            background-color: #050814;
            color: #1f2430;
        }
      **/

      /*  .wrapper {
            width: 100%;
            background-color: #050814;
            padding: 24px 8px;
        }

      **/

        .main-table {
            max-width: 640px;
            margin: 0 auto;
            background: #0c1223;
            border-radius: 16px;
            border: 1px solid rgba(209, 177, 27, 0.35);
            overflow: hidden;
        }

        .header {
            padding: 24px 24px 18px;
            background: linear-gradient(135deg, #151a33 0%, #0c1022 60%, #20151c 100%);
            border-bottom: 1px solid rgba(209, 177, 27, 0.35);
        }

        .logo-wrap {
            text-align: left;
        }

        .logo-img {
            border-radius: 14px;
            border: 1px solid rgba(209, 177, 27, 0.5);
            width: 60px;
            height: 60px;
            object-fit: cover;
            display: block;
        }

        .title-text {
            color: #f6f3e7;
            font-size: 22px;
            font-weight: 700;
            margin: 10px 0 2px;
        }

        .subtitle-text {
            color: #d9d3c0;
            font-size: 13px;
        }

        .tagline {
            color: #f6f3e7;
            font-size: 12px;
            font-style: italic;
            margin-top: 10px;
            opacity: 0.9;
        }

        .hero {
            padding: 0 24px 4px;
        }

        .hero-img {
            width: 100%;
            border-radius: 14px;
            margin-top: 12px;
            display: block;
            border: 1px solid rgba(209, 177, 27, 0.35);
        }

        .content {
            padding: 18px 24px 8px;
            background: #0c1223;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 999px;
            border: 1px solid rgba(209, 177, 27, 0.6);
            font-size: 11px;
            color: #f6f3e7;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .badge-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
            background: radial-gradient(circle at 30% 30%, #f5d259, #d1b11b);
        }

        .hello {
            color: #f6f3e7;
            font-size: 15px;
            line-height: 1.6;
            margin: 18px 0 8px;
        }

        .hello span {
            font-weight: 600;
            color: #fddf7a;
        }

        .role-note {
            color: #d9d3c0;
            font-size: 13px;
            line-height: 1.5;
            margin: 8px 0 16px;
        }

        .creds-box {
            margin: 16px 0 18px;
            border-radius: 14px;
            border: 1px solid rgba(209, 177, 27, 0.35);
            background: radial-gradient(circle at 0 0, rgba(209, 177, 27, 0.18), transparent 50%),
                        radial-gradient(circle at 100% 100%, rgba(88, 61, 34, 0.22), transparent 55%),
                        #10152a;
            padding: 16px 16px 10px;
        }

        .creds-title {
            color: #f6f3e7;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .creds-row {
            border-radius: 10px;
            background: rgba(12, 18, 35, 0.92);
            border: 1px solid rgba(209, 177, 27, 0.28);
            padding: 10px 11px;
            margin-bottom: 10px;
        }

        .label {
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #c4bdab;
            margin-bottom: 3px;
        }

        .mono {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 13px;
            color: #f8f5ea;
            word-break: break-all;
        }

        .tip {
            font-size: 11px;
            color: #c4bdab;
            margin-top: 6px;
        }

        .cta-wrap {
            text-align: center;
            margin: 16px 0 6px;
        }

        .cta-btn {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 999px;
            background: linear-gradient(135deg, #d1b11b, #f5d259);
            color: #161515 !important;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            letter-spacing: 0.03em;
            text-transform: uppercase;
        }

        .cta-btn:hover {
            filter: brightness(1.05);
        }

        .divider {
            margin: 18px 0 12px;
            text-align: center;
        }

        .divider span {
            display: inline-block;
            font-size: 11px;
            color: #b6b0a0;
            padding: 0 10px;
            position: relative;
        }

        .divider span:before,
        .divider span:after {
            content: "";
            position: absolute;
            top: 50%;
            width: 30px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(182,176,160,0.6));
        }

        .divider span:before { left: -32px; }
        .divider span:after { right: -32px; }

        .cultural-block {
            font-size: 13px;
            color: #d9d3c0;
            line-height: 1.6;
            margin-bottom: 14px;
        }

        .cultural-tag {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(209, 177, 27, 0.4);
            font-size: 11px;
            color: #f6f3e7;
            margin-bottom: 6px;
        }

        .footer {
            padding: 14px 18px 20px;
            border-top: 1px solid rgba(209, 177, 27, 0.25);
            background: #090d1a;
            text-align: center;
        }

        .footer-text {
            font-size: 11px;
            color: #8f8a7a;
        }

        .footer-links {
            margin-top: 6px;
            font-size: 11px;
            color: #b6b0a0;
        }

        .footer-links a {
            color: #f5d259;
            text-decoration: none;
        }

        @media (max-width: 480px) {
            .header, .content {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
            .hero {
                padding-left: 16px !important;
                padding-right: 16px !important;
            }
        }
    </style>
</head>
<body>
<div class="wrapper">
    <table class="main-table" width="100%" border="0" cellspacing="0" cellpadding="0" role="presentation">
        <!-- HEADER -->
        <tr>
            <td class="header">
                <table width="100%" role="presentation">
                    <tr>
                        <td width="72" valign="top" class="logo-wrap">
                            <img src="{{ asset('assets/images/voodoo/logo.png') }}"
                                 alt="Voodoo Hoost"
                                 class="logo-img">
                        </td>
                        <td valign="top" style="padding-left: 12px;">
                            <div class="title-text">Bienvenue chez Voodoo Hoost</div>
                            <div class="subtitle-text">Votre portail des séjours & expériences culturelles en terre Vodoun.</div>
                            <div class="tagline">
                                Entre mer, forêts sacrées et couvents, nous ouvrons les portes d’un Bénin authentique.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        {{-- VISUEL CULTUREL (IMAGE ZANGBETO / RITUEL) --}}
        <tr>
            <td class="hero">
                <img src="{{ asset('assets/images/zangbeto.jpg') }}"
                     alt="Esprit de la nuit - Zangbeto"
                     class="hero-img">
            </td>
        </tr>

        <!-- CONTENT -->
        <tr>
            <td class="content">
                <span class="badge">
                    <span class="badge-dot"></span>
                    Compte créé avec succès
                </span>

                <p class="hello">
                    Bonjour <span>{{ $user->nom . ' ' . $user->prenom }}</span>,
                </p>
                <p class="hello">
                    Nous sommes heureux de vous compter parmi la communauté <strong>Voodoo Hoost</strong>.
                    Votre compte est désormais actif.
                </p>

                {{-- Message adapté au rôle (optionnel si tu as $user->role / libelle) --}}
                @if(optional($user->role)->libelle === 'Hote')
                    <p class="role-note">
                        En tant qu’<strong>hôte</strong>, vous pouvez dès maintenant publier vos logements,
                        accueillir des voyageurs et partager avec eux vos rituels, vos histoires et votre
                        culture. Chaque séjour est une rencontre, chaque rencontre est une transmission.
                    </p>
                @else
                    <p class="role-note">
                        En tant que <strong>visiteur</strong>, vous êtes au bon endroit pour découvrir des
                        hébergements chaleureux, des rituels vivants et des expériences culturelles uniques,
                        au cœur des traditions Vodoun et des savoirs locaux.
                    </p>
                @endif

                <div class="creds-box">
                    <div class="creds-title">Vos identifiants de connexion</div>

                    <div class="creds-row">
                        <div class="label">Adresse e-mail</div>
                        <div class="mono">{{ $user->email }}</div>
                    </div>

                    <div class="creds-row">
                        <div class="label">Mot de passe provisoire</div>
                        <div class="mono">{{ $password }}</div>
                    </div>

                    <p class="tip">
                        Pour votre sécurité, nous vous recommandons de modifier ce mot de passe dès votre première connexion.
                    </p>
                </div>

                <div class="cta-wrap">
                    <a href="{{ url('/login') }}" class="cta-btn">
                        Accéder à mon compte
                    </a>
                </div>

                <div class="divider">
                    <span>Un séjour, une histoire</span>
                </div>

                <div class="cultural-block">
                    <div class="cultural-tag">Esprits, ancêtres & hospitalité</div>
                    <p>
                        Voodoo Hoost n’est pas qu’une plateforme de réservation : c’est un pont entre
                        les voyageurs et les gardiens de traditions. En réservant ou en accueillant via
                        notre plateforme, vous soutenez des projets communautaires locaux autour de
                        l’éducation, de l’art, et de la préservation du patrimoine.
                    </p>
                </div>

            </td>
        </tr>

        <!-- FOOTER -->
        <tr>
            <td class="footer">
                <div class="footer-text">
                    © {{ date('Y') }} FC ELOHIM & Voodoo Host — Tous droits réservés.
                </div>
                <div class="footer-links">
                    
                    <a href="https://ton-site.com">Voodoo host</a> · 
                    <a href="mailto:voodoohost@gmail.com">Support</a>
                   
                </div>
            </td>
        </tr>
    </table>
</div>
</body>
</html>
