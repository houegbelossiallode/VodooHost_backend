@extends('layouts.app')
@section('section')
    <!-- content -->
    <div class="dashboard-content">
        <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
        <div class="container dasboard-container">
            <!-- dashboard-title -->
            <div class="dashboard-title fl-wrap">
                <div class="dashboard-title-item"><span>Formulaire de modification d'utilisateur</span></div>
                @include('partials/hearder2')
            </div>
            <!-- dashboard-title end -->
            <div class="dasboard-widget-title fl-wrap" id="sec1">
                <h5><i class="fas fa-user-tag"></i>Modification d'un utilisateur</h5>
            </div>
            <form method="post" action="{{ route('hoost.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="dasboard-widget-box fl-wrap">
                    <div class="custom-form">
                        <div class="row">
                            <div class="col-sm-6">
                                <label>Nom</label>
                                <input type="text" name="nom" placeholder="Nom" value="{{ old('nom', $user->nom) }}"
                                    class="{{ $errors->has('nom') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('nom')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label>Prénom</label>
                                <input type="text" name="prenom" placeholder="Prénom"
                                    value="{{ old('prenom', $user->prenom) }}"
                                    class="{{ $errors->has('prenom') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('prenom')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label>Téléphone</label>
                                <input type="number" name="telephone" placeholder="Téléphone"
                                    value="{{ old('telephone', $user->telephone) }}"
                                    class="{{ $errors->has('telephone') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('telephone')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label>Profession</label>
                                <input type="text" name="profession" placeholder="Profession"
                                    value="{{ old('profession', $user->profession) }}"
                                    class="{{ $errors->has('profession') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('profession')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <label>Email</label>
                                <input type="email" name="email" placeholder="Email"
                                    value="{{ old('email', $user->email) }}"
                                    class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    style="text-align: left; padding-left: 15px;" />
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label>Roles</label>
                                <select name="role_id" data-placeholder="Sélectionnez un role" required
                                    class="chosen-select on-radius {{ $errors->has('role_id') ? 'is-invalid' : '' }}">
                                    <option value="">— Choisir —</option>
                                    @foreach ($roles as $m)
                                        <option value="{{ $m->id }}"
                                            {{ old('role_id', $user->role_id) == $m->id ? 'selected' : '' }}>
                                            {{ $m->libelle }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
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
    <!-- content end -->
    <div class="dashbard-bg gray-bg"></div>
    </div>
@endsection
