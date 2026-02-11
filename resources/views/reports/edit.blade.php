@extends('layouts.app')
@section('section')
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dashboard Menu
        </div>

        <div class="container dasboard-container">
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Modifier le problème</span>
                </div>
                @include('partials/hearder2')
            </div>

            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec1">
                    <h5>
                        <i class="fas fa-edit"></i>
                        Éditer le problème
                    </h5>
                </div>

                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form add_room-item-wrap">
                        <form action="{{ route('hoost.reports.update', $report->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="add_room-container fl-wrap">
                                <div class="add_room-item fl-wrap">
                                    <div class="row">

                                        {{-- Lien de l'annonce --}}
                                        <div class="col-md-12">
                                            <label>
                                                Lien de l'annonce (facultatif)
                                                <span class="dec-icon"><i class="fas fa-link"></i></span>
                                            </label>

                                            <input type="text" name="annonce_url"
                                                value="{{ old('annonce_url', $report->annonce_url) }}"
                                                placeholder="Collez ici le lien de l'annonce concernée">

                                            @error('annonce_url')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Type de problème --}}
                                        <div class="col-md-12">
                                            <label>Type de problème (facultatif)</label>
                                            <div class="listsearch-input-item">
                                                <select name="type" class="chosen-select no-search-select">
                                                    <option value="">Sélectionnez un type</option>

                                                    @php
                                                        $typeVal = old('type', $report->type);
                                                    @endphp

                                                    <option value="annonce" {{ $typeVal == 'annonce' ? 'selected' : '' }}>
                                                        Annonce inappropriée / mensongère</option>
                                                    <option value="paiement" {{ $typeVal == 'paiement' ? 'selected' : '' }}>
                                                        Problème de paiement</option>
                                                    <option value="reservation"
                                                        {{ $typeVal == 'reservation' ? 'selected' : '' }}>Problème de
                                                        réservation</option>
                                                    <option value="bug" {{ $typeVal == 'bug' ? 'selected' : '' }}>Bug
                                                        technique</option>
                                                    <option value="autre" {{ $typeVal == 'autre' ? 'selected' : '' }}>Autre
                                                    </option>
                                                </select>
                                            </div>

                                            @error('type')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Message --}}
                                        <div class="col-md-12">
                                            <p>Votre message</p>

                                            <textarea name="message" cols="40" rows="6" placeholder="Expliquez clairement le problème rencontré...">{{ old('message', $report->message) }}</textarea>

                                            @error('message')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                                <button type="submit" class="btn color-bg float-btn">
                                    Mettre à jour <i class="fas fa-save"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
