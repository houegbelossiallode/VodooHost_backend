@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Laissez un avis</span></div>
                 @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fas fa-user-tag"></i>Votre avis sur {{ $reviewedUser->nom }} {{ $reviewedUser->prenom }}</h5>
            </div>
            <form method="post" action="{{ route('hoost.reviews.store', [$reservation->id, $reviewedUser->id]) }}">
                @csrf
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Critère</label>
                                <select name="critere" data-placeholder="Sélectionnez un critère"
                                    class="chosen-select on-radius">
                                    <option value="">— Choisir —</option>
                                    <option value="proprete">Propreté</option>
                                    <option value="accueil">Accueil</option>
                                    <option value="communication">Communication</option>
                                    
                                </select>
                                @error('categorie_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="d-block mb-2" style="margin-left:35px;">Note globale <span class="text-muted" id="rating-value">({{ old('rating', $existingReview->rating ?? 0) }}/10)</span></label>
                                    <div class="rating-container">
                                        <div class="rating-stars">
                                            @for ($i = 10; $i >= 1; $i--)
                                                <input type="radio"
                                                       id="star{{ $i }}"
                                                       name="rating"
                                                       value="{{ $i }}"
                                                       @checked(old('rating', $existingReview->rating ?? null) == $i)>
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


                        <div class="col-12 mt-3">
                            <p>Commentaire</p>
                            <textarea name="comment" class="form-control" rows="4"
                                placeholder="comment">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-3">
                    <button type="submit" class="btn color-bg float-btn">Enregistrer</button>
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
    color: #FFD700;
    transform: scale(1.1);
}

.rating-stars input[type="radio"]:checked ~ label {
    text-shadow: 0 0 5px rgba(255, 215, 0, 0.5);
}

#rating-value {
    font-weight: 500;
    margin-left: 5px;
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
