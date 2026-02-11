@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Formulaire de création de rôle</span></div>
                @include('partials/hearder2')
                <!--Tariff Plan menu-->
                {{-- <div class="tfp-det-container">
                                <div   class="tfp-btn"><span>Your Tariff Plan : </span> <strong>Extended</strong></div>
                                <div class="tfp-det">
                                    <p>You Are on <a href="#">Extended</a> . Use link bellow to view details or upgrade. </p>
                                    <a href="#" class="tfp-det-btn color-bg">Details</a>
                                </div>
                            </div> --}}
                <!--Tariff Plan menu end-->
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fas fa-user-tag"></i> Création d'un rôle</h5>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <i class="fas fa-exclamation-triangle mr-2"></i> {{ session('error') }}
                </div>
            @endif
            <form method="post" action="{{ route('hoost.roles.store') }}">
                @csrf
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="libelle" class="font-weight-bold">Libellé <span
                                        class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input type="text" id="libelle" name="libelle"
                                        placeholder="Entrez le libellé du rôle" value="{{ old('libelle') }}"
                                        class="form-control {{ $errors->has('libelle') ? 'is-invalid' : '' }}"
                                        style="text-align: left; padding-left: 15px;" autofocus />
                                    @error('libelle')
                                        <div class="invalid-feedback d-block">
                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="mt-3">
                    <button type="submit" class="btn color-bg float-btn">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
