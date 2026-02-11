@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Modifier votre avis</span>
                </div>
                 @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->

            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5>
                    <i class="fas fa-user-tag"></i>
                    Votre avis sur {{ $reviewedUser->nom }} {{ $reviewedUser->prenom }}
                </h5>
            </div>

            {{--Ici on utilise la route UPDATE avec méthode PUT --}}
            <form method="POST" action="{{ route('hoost.reviews.update', $review->id) }}">
                @csrf
                @method('put')
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <div class="row">
                            {{-- CRITÈRE --}}
                            <div class="col-sm-6">
                                <label>Critère</label>
                                <select name="critere" data-placeholder="Sélectionnez un critère"
                                        class="chosen-select on-radius" required>
                                    <option value="">— Choisir —</option>
                                    <option value="proprete" 
                                        {{ old('critere', $review->critere) == 'proprete' ? 'selected' : '' }}>
                                        Propreté
                                    </option>
                                    <option value="accueil" 
                                        {{ old('critere', $review->critere) == 'accueil' ? 'selected' : '' }}>
                                        Accueil
                                    </option>
                                    <option value="communication" 
                                        {{ old('critere', $review->critere) == 'communication' ? 'selected' : '' }}>
                                        Communication
                                    </option>
                                </select>
                                @error('critere')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- NOTE / RATING --}}
                            <div class="col-sm-6">
                                <div class="form-group">
                                    @php
                                        $currentRating = old('rating', $review->rating ?? 0);
                                    @endphp
                                    <label class="d-block mb-2" style="margin-left:35px;">
                                        Note globale 
                                        <span class="text-muted" id="rating-value">({{number_format($currentRating, 0, ',', ' ')}}/10)</span>
                                    </label>

                                    <div class="rating-container">
                                        <div class="rating-stars">
                                            @for ($i = 10; $i >= 1; $i--)
                                                <input type="radio"
                                                       id="star{{ $i }}"
                                                       name="rating"
                                                       value="{{ $i }}"
                                                       @checked($currentRating == $i)>
                                                <label for="star{{ $i }}" title="{{ $i }}/10">
                                                    <i class="fas fa-star"></i>
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- COMMENTAIRE --}}
                        <div class="col-12 mt-3">
                            <p>Commentaire</p>
                            <textarea name="comment" class="form-control" rows="4"
                                placeholder="Votre commentaire" required>{{ old('comment', $review->comment) }}</textarea>
                            @error('comment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn color-bg float-btn">Mettre à jour</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>


    <style>
        .rating-container {
            margin-bottom: 1rem;
        }

        .rating-stars {
            direction: rtl;
            display: inline-flex;
            gap: 6px;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars label {
            font-size: 24px;
            cursor: pointer;
            color: #ddd;
            transition: all 0.2s ease;
            padding: 0 2px;
            line-height: 1;
        }

        .rating-stars label:hover,
        .rating-stars label:hover ~ label,
        .rating-stars input[type="radio"]:checked ~ label {
            color: #D1B11B;
            transform: scale(1.1);
        }

        .rating-stars input[type="radio"]:checked ~ label {
            text-shadow: 0 0 5px #D1B11B;
        }

        #rating-value {
            font-weight: 500;
            margin-left: 5px;
        }

        .form-control {
            width: 100%;
            border-radius: 10px;
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
            background: #fafafa;
        }

        .form-control:focus {
            outline: none;
            border-color: #D1B11B;
            background: #fff;
        }

        .btn-secondary {
            background: #ddd;
            color: #333;
            border-radius: 10px;
            padding: 10px 18px;
        }
    </style>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const stars = document.querySelectorAll('.rating-stars input[type="radio"]');
        const ratingValue = document.getElementById('rating-value');

        stars.forEach(star => {
            star.addEventListener('change', function() {
                ratingValue.textContent = `(${this.value}/10)`;
            });
        });
    });
    </script>
@endsection
