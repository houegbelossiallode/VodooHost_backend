@extends('layouts.app')

@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg">
            <span><i class="fas fa-bars"></i></span>Dashboard Menu
        </div>

        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item">
                    <span>Aide / Signaler un problème</span>
                </div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->

            <!-- dashboard-content-wrap -->
            <div class="dasboard-wrapper fl-wrap">
                <div class="dasboard-widget-title dwb-mar fl-wrap" id="sec1">
                    <h5>
                        <i class="fas fa-exclamation-triangle"></i>
                        Signaler un problème
                    </h5>
                    
                </div>

                <div class="dasboard-widget-box fl-wrap">
                   
                    <div class="custom-form add_room-item-wrap">
                        <form action="{{ route('hoost.problem_reports.store') }}" method="POST">
                            @csrf

                            <div class="add_room-container fl-wrap">
                                <div class="add_room-item fl-wrap">
                                    <div class="row">

                                        {{-- Lien de l'annonce --}}
                                        <div class="col-md-12">
                                            <label>
                                                Lien de l'annonce (facultatif)<span class="dec-icon"><i class="fas fa-comment-alt"></i></span>
                                            </label>
                                            <input type="text"
                                                   name="annonce_url"
                                                   value="{{ old('annonce_url', $annonceUrl) }}" {{ $annonceUrl ? 'readonly' : '' }}
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
                                                    <option value="annonce" {{ old('type')=='annonce' ? 'selected' : '' }}>
                                                        Annonce inappropriée / mensongère
                                                    </option>
                                                    <option value="paiement" {{ old('type')=='paiement' ? 'selected' : '' }}>
                                                        Problème de paiement
                                                    </option>
                                                    <option value="reservation" {{ old('type')=='reservation' ? 'selected' : '' }}>
                                                        Problème de réservation
                                                    </option>
                                                    <option value="bug" {{ old('type')=='bug' ? 'selected' : '' }}>
                                                        Bug technique
                                                    </option>
                                                    <option value="autre" {{ old('type')=='autre' ? 'selected' : '' }}>
                                                        Autre
                                                    </option>
                                                </select>
                                            </div>
                                            @error('type')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- Message --}}
                                        <div class="col-md-12">
                                            <p>
                                                Votre message 
                                            </p>
                                            <textarea name="message"
                                                      cols="40"
                                                      rows="5"
                                                      placeholder="Expliquez clairement le problème rencontré...">{{ old('message') }}</textarea>
                                            @error('message')
                                                <div class="alert alert-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn color-bg float-btn">
                                Envoyer
                                <i class="fas fa-paper-plane"></i>
                            </button>
                            <div class="clearfix"></div>
                        </form>
                    </div>

                </div>
            </div>
            <!-- dashboard-content-wrap end -->
        </div>
    </div>
@endsection
