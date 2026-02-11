{{-- 
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dashboard Menu
        </div>

        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Mes favoris</span>
                </div>
                @include('partials/hearder2')
            </div>
                    <h2>Liste de favoris : <span>{{ $favorite->libelle }}</span></h2>
                    <h4>
                        Une sélection de logements enregistrés
                        @if ($favorite->user)
                            par {{ $favorite->user->prenom ?? '' }} {{ $favorite->user->nom ?? '' }}
                        @endif
                    </h4>
                </div>

                @if ($favorite->items->count())
                    <div class="row">
                        @foreach ($favorite->items as $it)
                            @php
                                $logement = $it->logement;
                                if (!$logement) continue;
                                $photo = optional($logement->photos->first())->url ?? asset('images/default-house.jpg');
                            @endphp
                            <div class="col-md-4">
                                <div class="listing-item fl-wrap">
                                    <article class="geodir-category-listing fl-wrap">
                                        <div class="geodir-category-img">
                                            <a href="{{ route('hoost.logements.show', $logement) }}">
                                                <img src="{{ $photo }}"
                                                     alt="Photo de {{ $logement->titre }}">
                                            </a>
                                            <div class="overlay"></div>
                                            <div class="geodir-category-opt">
                                                <div class="listing-rating card-popup-rainingvis"
                                                     data-starrating2="5">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="geodir-category-content fl-wrap">
                                            <h3>
                                                <a href="{{ route('hoost.logements.show', $logement) }}">
                                                    {{ $logement->titre }}
                                                </a>
                                            </h3>
                                            <p>
                                                {{ \Illuminate\Support\Str::limit($logement->description, 80) }}
                                            </p>
                                            <div class="geodir-category-content-details">
                                                <ul>
                                                    <li>
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        {{ $logement->adresse }}
                                                    </li>
                                                    @isset($logement->prix_par_nuit)
                                                        <li>
                                                            <i class="fal fa-money-bill-wave"></i>
                                                            {{ number_format($logement->prix_par_nuit, 0, ',', ' ') }} FCFA / nuit
                                                        </li>
                                                    @endisset
                                                </ul>
                                            </div>
                                            <div class="geodir-category-footer fl-wrap">
                                                <a href="{{ route('hoost.logements.show', $logement) }}"
                                                   class="geodir-category-booking">
                                                    Voir le logement <i class="fal fa-long-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="alert alert-info">
                        Aucun logement dans cette liste pour le moment.
                    </div>
                @endif

                <div class="clearfix mt-3">
                    <a href="{{ route('hoost.logements.visiteurs.index') }}" class="btn color-bg">
                        <i class="fal fa-search"></i> Découvrir d’autres logements
                    </a>
                </div>
            </div>
        </section>
    </div>
 --}}


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste de favoris - Votre Plateforme</title>

    <!-- Font Awesome pour les icônes -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Google Fonts - Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Reset et styles de base */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            color: #484848;
            line-height: 1.6;
            background-color: #f7f7f7;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }

        /* En-tête avec image de fond */
        .favorites-hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('https://www.bradtguides.com/wp-content/uploads/wysiwyg/destinations/africa/Benin/Egungun__Benin_Laurent-Nilles.jpg');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 100px 0;
            text-align: center;
            margin-bottom: 40px;
        }

        .favorites-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }

        /* Navigation */
        .favorites-nav {
            margin-bottom: 30px;
            border-bottom: 1px solid #ebebeb;
            overflow-x: auto;
        }

        .favorites-nav ul {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            min-width: max-content;
        }

        .favorites-nav li {
            margin-right: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid transparent;
            white-space: nowrap;
        }

        .favorites-nav li.active {
            border-bottom-color: #FF5A5F;
        }

        .favorites-nav a {
            color: #484848;
            text-decoration: none;
            display: flex;
            align-items: center;
            font-weight: 500;
            font-size: 0.95rem;
        }

        .favorites-nav i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        /* Barre de filtres */
        .filters-bar {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 250px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 40px;
            border: 1px solid #ebebeb;
            border-radius: 8px;
            font-size: 0.9rem;
            font-family: inherit;
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #767676;
        }

        .filter-options {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .filter-options select {
            padding: 10px 15px;
            border: 1px solid #ebebeb;
            border-radius: 8px;
            background-color: white;
            cursor: pointer;
            font-family: inherit;
            min-width: 180px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border: 1px solid transparent;
            font-family: inherit;
        }

        .btn i {
            margin-right: 8px;
        }

        .btn-primary {
            background-color: #D1B11B;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background-color: #310a1fbe;
        }

        .btn-outline {
            background: white;
            border: 1px solid #ebebeb;
            color: #484848;
        }

        .btn-outline:hover {
            border-color: #484848;
        }

        /* Grille des favoris */
        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        @media (max-width: 768px) {
            .favorites-grid {
                grid-template-columns: 1fr;
            }
        }

        .favorite-card {
            border: 1px solid #ebebeb;
            border-radius: 12px;
            overflow: hidden;
            background: white;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .favorite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .favorite-image {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .favorite-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s;
        }

        .favorite-card:hover .favorite-image img {
            transform: scale(1.05);
        }

        .favorite-heart {
            position: absolute;
            top: 15px;
            right: 15px;
            background: white;
            border: none;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #ff385c;
            font-size: 1.2rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: all 0.3s;
        }

        .favorite-heart:hover {
            transform: scale(1.1);
        }

        .favorite-heart.active {
            color: white;
            background: #ff385c;
        }

        .favorite-details {
            padding: 20px;
        }

        .favorite-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .favorite-header h3 {
            margin: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: #484848;
            flex: 1;
        }

        .rating {
            background-color: #f5f5f5;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.85rem;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-left: 10px;
        }

        .rating i {
            color: #ffb400;
        }

        .location,
        .price {
            margin: 8px 0;
            font-size: 0.9rem;
            color: #D1B11B;
        }

        .location i {
            margin-right: 5px;
            color: #D1B11B;
        }

        .price {
            font-weight: 600;
            color: #484848;
            font-size: 1.1rem;
        }

        .price span {
            font-weight: normal;
            color: #767676;
            font-size: 0.9rem;
        }

        .favorite-actions {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        /* Pagination */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin: 40px 0;
            flex-wrap: wrap;
        }

        .pagination a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            text-decoration: none;
            color: #484848;
            border: 1px solid #ebebeb;
            transition: all 0.3s;
        }

        .pagination a:hover,
        .pagination a.active {
            background-color: #FF5A5F;
            color: white;
            border-color: #D1B11B;
        }

        /* Pied de page */
        footer {
            background-color: #f8f9fa;
            padding: 30px 0;
            margin-top: 50px;
            border-top: 1px solid #ebebeb;
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 30px;
        }

        .footer-section {
            flex: 1;
            min-width: 200px;
        }

        .footer-section h3 {
            margin-bottom: 15px;
            font-size: 1.1rem;
            color: #333;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-section a:hover {
            color: #FF5A5F;
        }

        .footer-bottom {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ebebeb;
            font-size: 0.9rem;
            color: #767676;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .filters-bar {
                flex-direction: column;
            }

            .search-box {
                width: 100%;
            }

            .favorite-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- En-tête avec image de fond -->
    <header class="favorites-hero">
        <div class="container">
            <h1>Mes logements préférés</h1>
            {{-- <p>Découvrez vos hébergements préférés</p> --}}
        </div>
    </header>

    <main class="container">
        <!-- Section de navigation -->
        <nav class="favorites-nav">
            <ul>
                <li class="active"><a href="#"><i class="fas fa-home"></i> Tous les logements</a></li>
                {{-- <li><a href="#"><i class="fas fa-heart"></i> Coups de cœur</a></li>
                <li><a href="#"><i class="fas fa-utensils"></i> Restaurants</a></li>
                <li><a href="#"><i class="fas fa-umbrella-beach"></i> Plages</a></li> --}}
            </ul>
        </nav>

        <!-- Section de recherche et filtres -->
        <div class="filters-bar">
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher dans vos favoris...">
            </div>
            <div class="filter-options">
                {{-- <select>
                    <option>Trier par :</option>
                    <option>Prix croissant</option>
                    <option>Prix décroissant</option>
                    <option>Meilleures notes</option>
                </select> --}}
                {{-- <button class="btn btn-outline"><i class="fas fa-sliders-h"></i> Filtres</button> --}}
            </div>
        </div>

        <!-- Liste des favoris -->
        <div class="favorites-grid">
            <!-- Carte de favori 1 -->
            @foreach ($favorite->items as $it)
                @php
                    $logement = $it->logement;
                    if (!$logement) {
                        continue;
                    }
                    $photo = optional($logement->photos->first())->url ?? asset('images/default-house.jpg');
                    $totalAvis = $logement->avis()->count();
                @endphp
                <div class="favorite-card">
                    <div class="favorite-image">
                        <a href="#"><img src="{{ $photo }}" alt="{{ $logement->titre }}"></a>
                        {{-- <button class="favorite-heart active"><i class="fas fa-heart"></i></button> --}}
                    </div>
                    <div class="favorite-details">
                        <div class="favorite-header">
                            <h3>{{ $logement->titre }}</h3>
                            <div class="rating">
                                <i class="fas fa-star"></i>{{$totalAvis}}
                            </div>
                        </div>
                        <p class="location"><i class="fas fa-map-marker-alt"></i>{{ $logement->adresse }}</p>
                        <p class="price">{{ $logement->prix_par_nuit }} FCFA <span>/nuit</span></p>
                        <div class="favorite-actions">
                        <a href="{{route('hoost.hebergements.show',$logement->id)}}" class="btn btn-primary">Voir l'annonce</a>
                        {{-- <button class="btn btn-outline">Supprimer</button> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        {{-- <div class="pagination">
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#"><i class="fas fa-chevron-right"></i></a>
        </div> --}}
    </main>

    <!-- Pied de page -->
    {{-- <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>À propos</h3>
                    <ul>
                        <li><a href="#">Notre entreprise</a></li>
                        <li><a href="#">Carrières</a></li>
                        <li><a href="#">Presse</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Communauté</h3>
                    <ul>
                        <li><a href="#">Diversité et intégration</a></li>
                        <li><a href="#">Accessibilité</a></li>
                        <li><a href="#">Associations</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Accueil de voyageurs</h3>
                    <ul>
                        <li><a href="#">Mettez votre logement sur notre plateforme</a></li>
                        <li><a href="#">Organisez une expérience</a></li>
                        <li><a href="#">Protection des hôtes</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h3>Assistance</h3>
                    <ul>
                        <li><a href="#">Centre d'aide</a></li>
                        <li><a href="#">Options d'annulation</a></li>
                        <li><a href="#">Service client</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2023 Votre Plateforme. Tous droits réservés.</p>
            </div>
        </div>
    </footer> --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Gestion des cœurs de favoris
            document.querySelectorAll('.favorite-heart').forEach(heart => {
                heart.addEventListener('click', function() {
                    this.classList.toggle('active');

                    // Ici, vous pourriez ajouter une requête AJAX pour mettre à jour les favoris côté serveur
                    const propertyId = this.closest('.favorite-card').dataset.id;
                    const isFavorite = this.classList.contains('active');

                    console.log(
                        `Property ${propertyId} ${isFavorite ? 'added to' : 'removed from'} favorites`
                        );
                });
            });

            // Gestion de la suppression d'un favori
            document.querySelectorAll('.btn-outline').forEach(btn => {
                btn.addEventListener('click', function() {
                    const card = this.closest('.favorite-card');
                    if (confirm('Êtes-vous sûr de vouloir supprimer ce favori ?')) {
                        // Ici, vous pourriez ajouter une requête AJAX pour supprimer le favori côté serveur
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.remove();
                        }, 300);
                    }
                });
            });

            // Simulation de recherche
            const searchInput = document.querySelector('.search-box input');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const searchTerm = this.value.toLowerCase();
                    const cards = document.querySelectorAll('.favorite-card');

                    cards.forEach(card => {
                        const title = card.querySelector('h3').textContent.toLowerCase();
                        const location = card.querySelector('.location').textContent.toLowerCase();

                        if (title.includes(searchTerm) || location.includes(searchTerm)) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }

            // Gestion du tri
            const sortSelect = document.querySelector('.filter-options select');
            if (sortSelect) {
                sortSelect.addEventListener('change', function() {
                    // Ici, vous pourriez ajouter la logique de tri
                    console.log('Tri sélectionné:', this.value);
                });
            }
        });
    </script>
</body>

</html>
