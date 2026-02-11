resources/views/reviews/create.blade.php
@extends('layouts.app')

@section('section')
<div class="dashboard-content">
    <div class="container dasboard-container">
        <div class="dashboard-title fl-wrap">
            <div class="dashboard-title-item">
                <span>Laisser un avis</span>
            </div>
            @include('partials/hearder2')
        </div>

        <div class="dasboard-wrapper fl-wrap">
            <div class="dasboard-widget-box fl-wrap">
                <div class="dasboard-widget-title dwb-mar fl-wrap">
                    <h5>
                        Votre avis sur
                        {{ $reviewedUser->nom }} {{ $reviewedUser->prenom }}
                    </h5>
                </div>

                <div class="dasboard-widget-content">

                    <p>
                        <strong>Séjour :</strong> {{ $reservation->logement?->titre ?? 'Séjour' }}<br>
                        <strong>Période :</strong>
                        {{\Carbon\Carbon::parse($reservation->date_debut)->format('d/m/Y') }} –
                        {{\Carbon\Carbon::parse($reservation->date_fin)->format('d/m/Y') }}
                    </p>

                    <form method="POST"
                          action="{{ route('hoost.reviews.store', [$reservation->id, $reviewedUser->id]) }}">
                        @csrf

                        <input type="hidden" name="reviewed" value="host">

                        {{-- Note globale (étoiles) --}}
                        <div class="mb-3">
                            <label>Note globale</label>
                            <div class="rating-stars">
                                @for ($i = 25; $i >= 1; $i--)
                                    <input type="radio"
                                           id="star{{ $i }}"
                                           name="rating_overall"
                                           value="{{ $i }}"
                                           @checked(old('rating_overall', $existingReview->rating_overall ?? null) == $i)>
                                    <label for="star{{ $i }}">&#9733;</label>
                                @endfor
                            </div>
                            @error('rating_overall')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Critères --}}
                        <div class="row">
                            <div class="col-md-3">
                                <label>Propreté</label>
                                <select name="rating_cleanliness" class="chosen-select no-search-select">
                                    <option value="">Non renseigné</option>
                                    @for ($i = 1; $i <= 25; $i++)
                                        <option value="{{ $i }}"
                                            @selected(old('rating_cleanliness', $existingReview->rating_cleanliness ?? null) == $i)>
                                            {{ $i }} / 5
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Accueil</label>
                                <select name="rating_welcome" class="chosen-select no-search-select">
                                    <option value="">Non renseigné</option>
                                    @for ($i = 1; $i <= 25; $i++)
                                        <option value="{{ $i }}"
                                            @selected(old('rating_welcome', $existingReview->rating_welcome ?? null) == $i)>
                                            {{ $i }} / 5
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Communication</label>
                                <select name="rating_communication" class="chosen-select no-search-select">
                                    <option value="">Non renseigné</option>
                                    @for ($i = 1; $i <= 25; $i++)
                                        <option value="{{ $i }}"
                                            @selected(old('rating_communication', $existingReview->rating_communication ?? null) == $i)>
                                            {{ $i }} / 5
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label>Professionnalisme</label>
                                <select name="rating_professionalism" class="chosen-select no-search-select">
                                    <option value="">Non renseigné</option>
                                    @for ($i = 1; $i <= 25; $i++)
                                        <option value="{{ $i }}"
                                            @selected(old('rating_professionalism', $existingReview->rating_professionalism ?? null) == $i)>
                                            {{ $i }} / 5
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        {{-- Commentaire --}}
                        <div class="mt-3">
                            <label>Commentaire</label>
                            <textarea name="comment"
                                      rows="4"
                                      class="form-control"
                                      placeholder="Partagez votre expérience...">{{ old('comment', $existingReview->comment ?? '') }}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn color-bg">
                                <i class="fal fa-paper-plane"></i> Envoyer
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </div>
</div>

<style>
.rating-stars {
    direction: rtl;
    display: inline-flex;
    gap: 4px;
}
.rating-stars input[type="radio"] { display:none; }
.rating-stars label {
    font-size:24px;
    cursor:pointer;
    color:#ccc;
}
.rating-stars input[type="radio"]:checked ~ label,
.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color:#FFD700;
}
</style>
@endsection
