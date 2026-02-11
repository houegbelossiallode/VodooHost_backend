@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>commentaires</span></div>
                @include('partials/hearder2')
                <!--Tariff Plan menu-->

            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-widget-title fl-wrap">
                    <h5>
                        <i class="fal fa-comments-alt"></i>
                        Derniers avis
                        @if ($newReviewsCount > 0)
                            <span> ( +{{ $newReviewsCount }} New ) </span>
                        @endif
                    </h5>
                    <a href="#" class="mark-btn  tolt" data-microtip-position="bottom" data-tooltip="Mark all as read">
                        <i class="far fa-comment-alt-check"></i>
                    </a>
                </div>

                <div class="dasboard-widget-box fl-wrap">
                    <div class="dasboard-opt fl-wrap">
                        <!-- price-opt-->
                        <div class="price-opt">
                            <span class="price-opt-title">Trier par :</span>
                            <div class="listsearch-input-item">
                                <form method="GET" action="{{ route('hoost.commentaires.index') }}">
                                    <select name="sort" class="chosen-select no-search-select"
                                        onchange="this.form.submit()">
                                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Plus récents</option>
                                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                                        <option value="rating" {{ $sort === 'rating' ? 'selected' : '' }}>Meilleure note
                                        </option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <!-- price-opt end-->
                    </div>
                    @forelse($reviews as $review)
                        @php
                            $user = auth()->user();
                            $photo = $user->photo;
                            // Initiales à partir du nom + prénom
                            $initials = strtoupper(substr($user->nom, 0, 1) . substr($user->prenom ?? '', 0, 1));
                            // Avatar généré si pas de photo
                            $avatar = "https://ui-avatars.com/api/?name={$initials}&background=D1B11B&color=fff&size=128&rounded=true";
                        @endphp
                        <div class="reviews-comments-item">
                            <div class="review-comments-avatar">
                                <img src="{{ $review->user->photo ?? $avatar }}" alt="">
                            </div>
                            <div class="reviews-comments-item-text smpar">
                                <div class="box-widget-menu-btn smact"><i class="far fa-ellipsis-h"></i></div>
                                {{-- <div class="show-more-snopt-tooltip bxwt">
                                    <a href="#"> <i class="fas fa-reply"></i> Reply</a>
                                    <a href="#"> <i class="fas fa-exclamation-triangle"></i> Report </a>
                                </div> --}}

                                {{-- Nom de l'utilisateur + titre du logement --}}
                                <h4>
                                    <a href="#">
                                        {{ $review->user->nom }}
                                        @if ($review->logement)
                                            <span>Pour {{ $review->logement->titre }}</span>
                                        @endif
                                    </a>
                                </h4>

                                {{-- Note / étoiles --}}
                                <div class="listing-rating card-popup-rainingvis" data-starrating2="{{ $review->notes }}">
                                    <span class="re_stars-title">
                                        @if ($review->notes >= 4)
                                            Excellent
                                        @elseif($review->notes == 3)
                                            Average
                                        @else
                                            Poor
                                        @endif
                                    </span>
                                </div>

                                <div class="clearfix"></div>

                                <p>" {{ $review->commentaire }} "</p>

                                <div class="reviews-comments-item-date">
                                    <span class="reviews-comments-item-date-item">
                                        <i class="far fa-calendar-check"></i>
                                        {{ $review->created_at?->format('d F Y') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>Aucun commentaire pour le moment.</p>
                    @endforelse
                </div>
                <!-- pagination-->
                @if ($reviews->hasPages())
                    <div class="pagination">
                        {{-- Précédent --}}
                        @if ($reviews->onFirstPage())
                            <a href="javascript:void(0)" class="prevposts-link disabled">
                                <i class="fa fa-caret-left"></i>
                            </a>
                        @else
                            <a href="{{ $reviews->previousPageUrl() }}" class="prevposts-link">
                                <i class="fa fa-caret-left"></i>
                            </a>
                        @endif

                        {{-- Pages --}}
                        @for ($page = 1; $page <= $reviews->lastPage(); $page++)
                            @if ($page == $reviews->currentPage())
                                {{-- Page active : même structure que le template --}}
                                <a href="{{ $reviews->url($page) }}" class="current-page">
                                    {{ $page }}
                                </a>
                            @else
                                <a href="{{ $reviews->url($page) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endfor

                        {{-- Suivant --}}
                        @if ($reviews->hasMorePages())
                            <a href="{{ $reviews->nextPageUrl() }}" class="nextposts-link">
                                <i class="fa fa-caret-right"></i>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="nextposts-link disabled">
                                <i class="fa fa-caret-right"></i>
                            </a>
                        @endif
                    </div>
                @endif
                <!-- pagination end-->
            </div>
        </div>

    </div>
    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>
    </div>
@endsection
