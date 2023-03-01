<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <!-- Font -->
        <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600%7CUbuntu:300,400,500,700" rel="stylesheet">  -->

        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('app/css/bootstrap-reboot.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/bootstrap-grid.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/jquery.mCustomScrollbar.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/nouislider.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/plyr.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/photoswipe.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/default-skin.css') }}">
        <link rel="stylesheet" href="{{ asset('app/css/main.css') }}">

        <!-- Favicons -->
        <link rel="icon" type="image/png" href="{{ asset('assets/images/earners-logo.png') }}" sizes="32x32">
        <link rel="apple-touch-icon" href="{{ asset('assets/images/earners-logo.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/images/earners-logo.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/images/earners-logo.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/images/earners-logo.png') }}">

        <meta name="description" content="">
        <meta name="keywords" content="">
        <meta name="author" content="Earnerview">
        <title>{{ $page_title ?? 'Earnerview | Earn Money Watch Videos' }}</title>

    </head>
    <body class="body">

        <!-- content starts -->
        @yield('main')
        <!-- content ends -->
        
        <!-- JS -->
        <script src="{{ asset('app/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('app/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('app/js/owl.carousel.min.js') }}"></script>
        <script src="{{ asset('app/js/jquery.mousewheel.min.js') }}"></script>
        <script src="{{ asset('app/js/jquery.mCustomScrollbar.min.js') }}"></script>
        <script src="{{ asset('app/js/wNumb.js') }}"></script>
        <script src="{{ asset('app/js/nouislider.min.js') }}"></script>
        <!-- <script src="{{ asset('app/js/plyr.min.js') }}"></script> -->
        <script src="{{ asset('app/js/jquery.morelines.min.js') }}"></script>
        <script src="{{ asset('app/js/photoswipe.min.js') }}"></script>
        <script src="{{ asset('app/js/photoswipe-ui-default.min.js') }}"></script>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="{{ asset('app/js/main.js') }}"></script>
        <script>
            $('.owl-carousel').owlCarousel({
                autoplay: true,
                autoplayHoverPause: true,
                loop:true,
                margin:10,
                responsive:{
                    0:{
                        items:1
                    },
                    600:{
                        items:3
                    },
                    1000:{
                        items:5
                    }
                }
            })
    </script>

        @stack('scripts')
    </body>
</html>