@extends('layouts.app')
@section('section')

   <!-- content -->	
                <div class="dashboard-content">
                    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
                    <div class="container dasboard-container">
                        <!-- dashboard-title -->	
                        <div class="dashboard-title fl-wrap">
                            <div class="dashboard-title-item"><span>Formulaire de création de type de logement</span></div>
                            @include('partials/hearder2')						
                        </div>
                        <!-- dashboard-title end -->
                        <div class="dasboard-widget-title fl-wrap" id="sec1">
                            <h5>Création d'un type de logement</h5>
                        </div>
                        
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                           <form method="post" action="{{route('hoost.typelogements.store')}}">
                            @csrf
                            <div class="dasboard-widget-box fl-wrap">
                                    <div class="custom-form">
                                        <div class="row">
                                            <div class="col-sm-6">		 
                                                <label>Libelle</label>
                                                <input type="text" name="libelle" placeholder="libelle" value="{{old('libelle')}}" class="form-control {{ $errors->has('libelle') ? 'is-invalid' : '' }}" style="text-align: left; padding-left: 15px;" />
                                                @error('libelle')
                                                    <div class="invalid-feedback d-block">
                                                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                                    </div>
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
