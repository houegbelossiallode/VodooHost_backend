<!DOCTYPE HTML>
<html lang="en">
<head>
    <!-- Head content -->
    <meta charset="UTF-8">
    <title>Voodoo Hoost</title>
    <meta name="robots" content="index, follow"/>
    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/plugins.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/dashboard-style.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/color.css')}}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/table.css')}}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/affecte.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
      <!-- Leaflet CSS -->
      <link rel="stylesheet"
      href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
      crossorigin=""/>
      <link rel="stylesheet" href="https://unpkg.com/leaflet-geosearch@3.1.0/dist/geosearch.css" />

    {{-- CSS / JS Flatpickr --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body>
    <!--loader-->
    <div class="loader-wrap">
        <div class="loader-inner">
            <svg>
                <defs>
                    <filter id="goo">
                        <fegaussianblur in="SourceGraphic" stdDeviation="2" result="blur" />
                        <fecolormatrix in="blur" values="1 0 0 0 0 0 1 0 0 0 0 0 1 0 0 0 0 0 5 -2" result="gooey" />
                        <fecomposite in="SourceGraphic" in2="gooey" operator="atop"/>
                    </filter>
                </defs>
            </svg>
        </div>
    </div>
    <!--loader end-->

    <!-- main -->
    <div id="main">
        @include('layouts.header')

        <div class="wrapper">
            @include('layouts.sidebar')

            <!-- Content -->
            @yield('section')
            <!-- Content end -->
        </div>
        <!-- wrapper end -->
    </div>
    <!-- Main end -->

    <!-- Scripts -->

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets/js/plugins.js')}}"></script>
    <!-- sendbai Chat Widget -->
<script>
  window.SendbaiConfig = {
    companyId: "7b19527c-e6e5-4b61-82bf-86224b12f193",
    companyName: "Voodoo Hoost",
    color: "#D1B11B",
    position: "bottom-right"
  };
</script>
<script src="https://chat.sendbai.com/widget.js" async></script>
    <style>
        /* Styles personnalisés pour les toasts */
        .swal2-toast {
            border-radius: 8px !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15) !important;
            font-family: inherit !important;
            padding: 1rem 1.5rem !important;
            font-size: 1rem !important;
        }

        .swal2-toast.swal2-icon-success {
            background: #19A64A !important;
            color: white !important;
        }

        .swal2-toast.swal2-icon-error {
            background: #E04F10 !important;
            color: white !important;
        }

        .swal2-toast.swal2-icon-warning {
            background: #F1A33B !important;
            color: #212529 !important;
        }

        .swal2-toast.swal2-icon-info {
            background: #2F17D4 !important;
            color: white !important;
        }

        .swal2-toast .swal2-title {
            color: inherit !important;
            font-weight: 500 !important;
            margin: 0 !important;
            font-size: 1rem !important;
        }

        .swal2-toast .swal2-html-container {
            color: inherit !important;
            margin: 5px 0 0 0 !important;
        }

        .swal2-toast .swal2-timer-progress-bar {
            height: 3px !important;
        }

        .dropdown-menu {
            min-width: 10rem;
            padding: 0.5rem 0;
            margin: 0.125rem 0 0;
            font-size: 0.9rem;
            color: #212529;
            text-align: left;
            list-style: none;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid rgba(0, 0, 0, 0.15);
            border-radius: 0.25rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
        }
        .dropdown-item {
            display: block;
            width: 100%;
            padding: 0.25rem 1rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: inherit;
            text-decoration: none;
            white-space: nowrap;
            background-color: transparent;
            border: 0;
        }
        .dropdown-item:hover {
            color: #16181b;
            background-color: #f8f9fa;
        }
        .dropdown-divider {
            height: 0;
            margin: 0.5rem 0;
            overflow: hidden;
            border-top: 1px solid #e9ecef;
        }
    </style>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Script pour afficher les notifications -->
    <!-- Gtranslate.io Widget -->
    <script>
        // Fonction pour afficher une notification toast
        function showToast(icon, title, text = '') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: icon,
                title: title,
                text: text
            });
        }

        // Afficher les messages de session s'ils existent
        @if(session('success'))
            showToast('success', '{{ session('success') }}');
        @endif

        @if(session('error'))
            showToast('error', '{{ session('error') }}');
        @endif

        @if(session('warning'))
            showToast('warning', '{{ session('warning') }}');
        @endif

        @if(session('info'))
            showToast('info', '{{ session('info') }}');
        @endif
    </script>
    


    <script src="{{asset('assets/js/scripts.js')}}"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOU_API_KEY_HERE&libraries=places"></script>
    <script src="{{asset('assets/js/map-add.js')}}"></script>
    <script src="{{asset('assets/js/dashboard.js')}}"></script>
    <script src="{{asset('assets/js/dropdown.js')}}"></script>
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
        crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-geosearch@3.1.0/dist/bundle.min.js"></script>

</body>
</html>
