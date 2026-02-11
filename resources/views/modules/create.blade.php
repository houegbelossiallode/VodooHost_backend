@extends('layouts.app')
@section('section')

   <!-- content -->	
                <div class="dashboard-content">
                    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
                    <div class="container dasboard-container">
                        <!-- dashboard-title -->	
                        <div class="dashboard-title fl-wrap">
                            <div class="dashboard-title-item"><span>Formulaire de création de module</span></div>
                            @include('partials/hearder2')						
                        </div>
                        <!-- dashboard-title end -->
                        <div class="dasboard-widget-title fl-wrap" id="sec1">
                            <h5><i class="fas fa-user-tag"></i> Création d'un module</h5>
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
                           <form method="post" action="{{route('hoost.modules.store')}}">
                            @csrf
                            <div class="dasboard-widget-box fl-wrap">
                                    <div class="custom-form">
                                        <div class="row">
                                            <div class="col-sm-6">		 
                                                <label>Libelle</label>
                                                <input type="text" name="name" placeholder="libelle" value="{{old('name')}}" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" style="text-align: left; padding-left: 15px;" />
                                                @error('name')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3">
                                    <button type="submit" class="btn color-bg float-btn">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>			
                </div>
                <!-- content end -->	
                <div class="dashbard-bg gray-bg"></div>
            </div>


@endsection
