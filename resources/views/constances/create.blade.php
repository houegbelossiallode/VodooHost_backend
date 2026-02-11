@extends('layouts.app')
@section('section')

   <!-- content -->	
                <div class="dashboard-content">
                    <div class="dashboard-menu-btn color-bg"><span><i class="fas fa-bars"></i></span>Dasboard Menu</div>
                    <div class="container dasboard-container">
                        <!-- dashboard-title -->	
                        <div class="dashboard-title fl-wrap">
                            <div class="dashboard-title-item"><span>Liste des constantes</span></div>
                            <div class="dashbard-menu-header">
                                <div class="dashbard-menu-avatar fl-wrap">
                                    <img src="images/avatar/1.jpg" alt="">
                                    <h4>Welcome, <span>Alica Noory</span></h4>
                                </div>
                                <a href="index.html" class="log-out-btn   tolt" data-microtip-position="bottom"  data-tooltip="Log Out"><i class="far fa-power-off"></i></a>
                            </div>
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
                            <h5></i>Constantes</h5>
                        </div>
                           <form method="post" action="{{route('hoost.constances.store')}}">
                            @csrf
                            <div class="dasboard-widget-box fl-wrap">
                                    <div class="custom-form">
                                        <div class="row">
                                            <div class="col-sm-6">		 
                                                <label>Paramètre</label>
                                                <input type="text" name="param" placeholder="paramètre" value="{{old('param')}}" style="text-align: left; padding-left: 15px;" />
                                            </div>

                                            <div class="col-sm-6">		 
                                                <label>Valeur</label>
                                                <input type="text" name="val" placeholder="valeur" value="{{old('val')}}" style="text-align: left; padding-left: 15px;"  />
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
