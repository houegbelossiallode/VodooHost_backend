@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Formulaire de création de menu</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fas fa-user-tag"></i> Création d'un menu</h5>
            </div>

            <form method="post" action="{{ route('hoost.menus.store') }}">
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
                                <label>Module</label>
                                <select name="module_id" data-placeholder="Sélectionnez un module"
                                    class="chosen-select on-radius {{ $errors->has('module_id') ? 'is-invalid' : '' }}">
                                    <option value="">— Choisir —</option>
                                    @foreach ($modules as $m)
                                        <option value="{{ $m->id }}"
                                            {{ old('module_id') == $m->id ? 'selected' : '' }}>
                                            {{ $m->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('module_id')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-12">
                                <label>Icone</label>
                                <input type="text" name="icon" placeholder="libelle" value="{{ old('icon') }}"
                                    class="{{ $errors->has('icon') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('icon')
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
