@extends('layouts.app')
@section('section')

   <!-- content -->	
                <div class="dashboard-content">
                    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
                    <div class="container dasboard-container">
                        <!-- dashboard-title -->	
                        <div class="dashboard-title fl-wrap">
                            <div class="dashboard-title-item"><span>Liste des roles</span></div>
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
                            <h5><i class="fas fa-user-tag"></i> Formulaire d'édition</h5>
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
                           <form method="post" action="{{route('hoost.roles.update',$role->id)}}">
                            @csrf
                            @method('PUT')
                            <div class="dasboard-widget-box fl-wrap">
                                    <div class="custom-form">
                                        <div class="row">
                                            <div class="col-sm-4">		 
                                                <label style="margin-left:10px">Libelle</label>
                                                <input type="text" name="libelle" placeholder="libelle" value="{{old('libelle',$role->libelle)}}" class="{{ $errors->has('libelle') ? 'is-invalid' : '' }}" style="text-align: left; padding-left: 15px;" />
                                                @error('libelle')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>


                                <div class="mt-3">
                                    <button type="submit" class="btn color-bg float-btn">Save Changes</button>
                                </div>
                            </form>
                        </div>

                        
                    </div>
                    				
                </div>
                <!-- content end -->	
                <div class="dashbard-bg gray-bg"></div>
            </div>

  

   

@endsection
