{{-- <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail des festivals</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .portal-header {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            color: white;
            padding: 4rem 0;
            margin-bottom: 3rem;
        }
        .app-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 2rem;
            height: 100%;
        }
        .app-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }
        .app-icon {
            font-size: 4rem;
            margin: 1.5rem 0;
            color: #6e8efb;
        }
        .btn-portal {
            background: linear-gradient(135deg, #6e8efb, #a777e3);
            border: none;
            padding: 0.5rem 1.5rem;
            border-radius: 25px;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .btn-portal:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(110, 142, 251, 0.4);
            color: white;
        }
    </style>
</head>
<body>
    <!-- En-tête du portail -->
    <header class="portal-header text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Portail des festivals</h1>
            <p class="lead">Sélectionnez un festival pour continuer</p>
        </div>
    </header>

    <!-- Applications -->
    <div class="container">
        <div class="row justify-content-center">
            <!-- Carte Voodoo Hoost -->
            <div class="col-md-4 mb-4">
                <div class="card app-card text-center h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="my-auto">
                            <i class="fas fa-home app-icon"></i>
                            <h3 class="card-title"><img src="{{asset('assets/images/voodoo/yes.jpg')}}" /></h3>
                            <p class="card-text">Plateforme de réservation d'hébergements</p>
                            <a href="{{ route('hoost.accueil') }}" class="btn btn-portal" style="background: #bd3838ff">
                                Accéder <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Carte Application 2 (Exemple) -->
            <div class="col-md-4 mb-4">
                <div class="card app-card text-center h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="my-auto">
                            <i class="fas fa-mask app-icon"></i>
                            <h3 class="card-title"><img src="{{asset('assets/images/voodoo/masque.webp')}}" style="width:250px;height:220px;" /></h3>
                            <p class="card-text">Bientôt disponible</p>
                            <button class="btn btn-portal" style="background: #c4570e93; color:white;" disabled>
                                À venir
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-4">
                <div class="card app-card text-center h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="my-auto">
                            <i class="fas fas fa-people-carry app-icon"></i>
                            <h3 class="card-title"><img src="{{asset('assets/images/voodoo/evala.png')}}" style="width:250px;height:220px;"/></h3>
                            <p class="card-text">Bientôt disponible</p>
                            <button class="btn btn-portal" style="background: #a76003b6; color:white;" disabled>
                                À venir
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Pied de page -->
    <footer class="bg-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Voodoo. Tous droits réservés.</p>
        </div>
    </footer>
    <!-- Bootstrap JS et dépendances -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> --}}



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail des festivals</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <style>
        :root{
            --bg: #0b0f1a;
            --card: rgba(255,255,255,.08);
            --cardBorder: rgba(255,255,255,.14);
            --textMuted: rgba(255,255,255,.75);
            --shadow: 0 18px 50px rgba(0,0,0,.35);
            --shadowHover: 0 24px 70px rgba(0,0,0,.45);
            --radius: 18px;
        }

        body{
            background:
                radial-gradient(1200px 500px at 20% 10%, rgba(167,119,227,.35), transparent 55%),
                radial-gradient(900px 450px at 85% 20%, rgba(110,142,251,.35), transparent 55%),
                radial-gradient(900px 450px at 40% 90%, rgba(255,180,90,.20), transparent 55%),
                var(--bg);
            color: #fff;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif;
        }

        /* HERO */
        .portal-hero{
            position: relative;
            padding: 5rem 0 3.5rem;
            overflow: hidden;
        }
        .portal-hero::before{
            content:"";
            position:absolute; inset:0;
            background:
                linear-gradient(135deg, rgba(110,142,251,.20), rgba(167,119,227,.18)),
                radial-gradient(800px 400px at 15% 15%, rgba(255,255,255,.10), transparent 60%),
                radial-gradient(700px 350px at 80% 25%, rgba(255,255,255,.08), transparent 60%);
            pointer-events:none;
        }
        .hero-glass{
            position: relative;
            border: 1px solid rgba(255,255,255,.12);
            background: rgba(255,255,255,.06);
            backdrop-filter: blur(10px);
            border-radius: 24px;
            box-shadow: var(--shadow);
            padding: 2.2rem 1.8rem;
        }
        .hero-title{
            letter-spacing: -.02em;
        }
        .hero-sub{
            color: var(--textMuted);
        }

        /* CARDS */
        .festival-card{
            border: 1px solid var(--cardBorder);
            background: var(--card);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
            transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
            height: 100%;
        }
        .festival-card:hover{
            transform: translateY(-6px);
            box-shadow: var(--shadowHover);
            border-color: rgba(255,255,255,.22);
        }

        .card-cover{
            position: relative;
            height: 210px;
            background: #111827;
            overflow: hidden;
        }
        .card-cover img{
            width: 100%;
            height: 100%;
            object-fit: cover;
            transform: scale(1.02);
            transition: transform .35s ease;
            filter: saturate(1.05) contrast(1.05);
        }
        .festival-card:hover .card-cover img{
            transform: scale(1.07);
        }
        .cover-overlay{
            position:absolute; inset:0;
            background: linear-gradient(to top, rgba(0,0,0,.55), rgba(0,0,0,.05));
        }

        .status-badge{
            position: absolute;
            top: 14px;
            left: 14px;
            padding: .35rem .6rem;
            border-radius: 999px;
            font-size: .78rem;
            border: 1px solid rgba(255,255,255,.20);
            background: rgba(0,0,0,.25);
            backdrop-filter: blur(8px);
        }
        .status-live{
            color: #d1fae5;
        }
        .status-soon{
            color: #fde68a;
        }
        .status-dot{
            display:inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            margin-right: 6px;
            box-shadow: 0 0 0 3px rgba(255,255,255,.06);
            vertical-align: middle;
        }
        .dot-live{ background: #22c55e; }
        .dot-soon{ background: #f59e0b; }

        .festival-body{
            padding: 1.25rem 1.25rem 1.35rem;
        }
        .festival-title{
            font-weight: 700;
            letter-spacing: -.01em;
            margin-bottom: .35rem;
        }
        .festival-desc{
            color: var(--textMuted);
            margin-bottom: 1rem;
        }

        /* BUTTONS */
        .btn-premium{
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            padding: .7rem 1.05rem;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,.18);
            background: rgba(255,255,255,.08);
            color: #fff;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
            width: 100%;
        }
        .btn-premium:hover{
            transform: translateY(-1px);
            background: rgba(255,255,255,.12);
            box-shadow: 0 10px 24px rgba(0,0,0,.25);
            color: #fff;
        }
        .btn-brand{
            border: none;
            background: linear-gradient(135deg, #CF213C, #CF213C);
            box-shadow: 0 10px 24px rgba(189,56,56,.25);
        }
        .btn-brand:hover{
            box-shadow: 0 14px 30px rgba(189,56,56,.35);
        }

        .btn-disabled{
            opacity: .65;
            cursor: not-allowed;
        }

        /* FOOTER */
        footer{
            color: rgba(255,255,255,.70);
            border-top: 1px solid rgba(255,255,255,.10);
            background: rgba(255,255,255,.04);
            backdrop-filter: blur(10px);
        }

        /* Responsive tweaks */
        @media (max-width: 576px){
            .portal-hero{ padding: 3.5rem 0 2.5rem; }
            .card-cover{ height: 190px; }
        }
    </style>
</head>

<body>

    <!-- HERO -->
    <header class="portal-hero">
        <div class="container">
            <div class="hero-glass text-center">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 mb-3"
                     style="border-radius:999px;border:1px solid rgba(255,255,255,.12);background:rgba(255,255,255,.06);">
                    <i class="fa-solid fa-sparkles"></i>
                    <span style="color: rgba(255,255,255,.85); font-size:.9rem;">Portail officiel</span>
                </div>

                <h1 class="display-5 fw-bold hero-title mb-2">Portail des festivals</h1>
                <p class="lead hero-sub mb-0">Choisissez un festival pour continuer</p>
            </div>
        </div>
    </header>

    <!-- CARDS -->
    <main class="container pb-5">
        <div class="row g-4 justify-content-center">

            <!-- VOODOO HOOST -->
            <div class="col-md-4">
                <div class="festival-card">
                    <div class="card-cover">
                        <img src="{{ asset('assets/images/voodoo/yes.jpg') }}" alt="Voodoo Hoost">
                        <div class="cover-overlay"></div>

                        <span class="status-badge status-live">
                            <span class="status-dot dot-live"></span>
                            Disponible
                        </span>
                    </div>

                    <div class="festival-body">
                        <div class="festival-title">Voodoo Hoost</div>
                        <div class="festival-desc">Plateforme de réservation d'hébergements</div>

                        <a href="{{ route('hoost.accueil') }}" class="btn-premium btn-brand">
                            Accéder <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- FESTIVAL 2 -->
            <div class="col-md-4">
                <div class="festival-card">
                    <div class="card-cover">
                        <img src="{{ asset('assets/images/voodoo/masque.webp') }}" alt="Festival à venir">
                        <div class="cover-overlay"></div>

                        <span class="status-badge status-soon">
                            <span class="status-dot dot-soon"></span>
                            Bientôt
                        </span>
                    </div>

                    <div class="festival-body">
                        <div class="festival-title">Festival Masque</div>
                        <div class="festival-desc">Bientôt disponible</div>

                        <a class="btn-premium btn-disabled" aria-disabled="true" tabindex="-1">
                            À venir <i class="fa-solid fa-hourglass-half"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- FESTIVAL 3 -->
            <div class="col-md-4">
                <div class="festival-card">
                    <div class="card-cover">
                        <img src="{{ asset('assets/images/voodoo/evala.png') }}" alt="Evala à venir">
                        <div class="cover-overlay"></div>

                        <span class="status-badge status-soon">
                            <span class="status-dot dot-soon"></span>
                            Bientôt
                        </span>
                    </div>

                    <div class="festival-body">
                        <div class="festival-title">Evala</div>
                        <div class="festival-desc">Bientôt disponible</div>

                        <a class="btn-premium btn-disabled" aria-disabled="true" tabindex="-1">
                            À venir <i class="fa-solid fa-hourglass-half"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- FOOTER -->
    <footer class="py-4">
        <div class="container text-center">
            <div class="small">&copy; {{ date('Y') }} Voodoo. Tous droits réservés.</div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

