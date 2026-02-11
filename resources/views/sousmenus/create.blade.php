@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Formulaire de création de sousmenu</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fas fa-user-tag"></i> Création d'un sousmenu</h5>
            </div>


            <form method="post" action="{{ route('hoost.sousmenus.store') }}">
                @csrf
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Libelle</label>
                                <input type="text" name="name" placeholder="libelle" value="{{ old('name') }}"
                                    class="{{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('name')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label>Menu</label>
                                <select name="menu_id" data-placeholder="Sélectionnez un menu"
                                    class="chosen-select on-radius {{ $errors->has('menu_id') ? 'is-invalid' : '' }}">
                                    <option value="">— Choisir —</option>
                                    @foreach ($menus as $m)
                                        <option value="{{ $m->id }}"
                                            {{ old('menu_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('menu_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-12">
                                <label>Route</label>
                                <input type="text" name="url" placeholder="libelle" value="{{ old('url') }}"
                                    class="{{ $errors->has('url') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('url')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
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
    
@endsection
