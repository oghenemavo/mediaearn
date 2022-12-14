<!DOCTYPE html>
<html lang="en" class="js">
    <head>
        <base href="{{ url('') }}">
        <meta charset="utf-8">
        <meta name="author" content="Earnersview">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="Manage Site Activities.">
        <!-- Fav Icon  -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">
        <!-- Page Title  -->
        <title>{{ $page_title ?? 'Protected Area' }}</title>
        <!-- StyleSheets  -->
        <link rel="stylesheet" href="{{ asset('assets/css/dashlite.css?ver=2.8.0') }}">
        <link id="skin-default" rel="stylesheet" href="{{ asset('assets/css/theme.css?ver=2.8.0') }}">
        @stack('styles')
    </head>
    
    <body class="nk-body bg-white npc-general pg-auth">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">
                <!-- wrap @s -->
                <div class="nk-wrap nk-wrap-nosidebar">
                    
                    <!-- notifications alert -->
                    @foreach(['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'gray', 'light'] as $alert)
                        @if(session()->has($alert))
                            <x-alert type="{{ $alert }}" :message="session()->get($alert)"/>
                        @endif
                    @endforeach
                    <!-- notifications alert -->

                    <!-- content @s -->
                    <div class="nk-content ">
                        <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
                            <div class="brand-logo pb-4 text-center">
                                <a href="{{ route('admin.login') }}" class="logo-link">
                                    <img class="logo-light logo-img logo-img-lg" src="{{ asset('assets/images/earners-logo.png') }}" srcset="{{ asset('assets/images/earners-logo.png 2x') }}" alt="logo">
                                    <img class="logo-dark logo-img logo-img-lg" src="{{ asset('assets/images/earners-logo.png') }}" srcset="{{ asset('assets/images/earners-logo.png 2x') }}" alt="logo-dark">
                                </a>
                            </div>
                            <div class="card card-bordered">
                                <!-- Protected Area -->
                                @yield('content')
                                <!-- Protected Area -->
                            </div>
                        </div>
                        <div class="nk-footer nk-auth-footer-full">
                            <div class="container wide-lg">
                                <div class="row g-3">
                                    <div class="col-lg-6 order-lg-last">
                                        <ul class="nav nav-sm justify-content-center justify-content-lg-end">
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Terms & Condition</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Privacy Policy</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="#">Help</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="nk-block-content text-center text-lg-left">
                                            <p class="text-soft">&copy; 2019 Earner's View. All Rights Reserved.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- wrap @e -->
                </div>
                <!-- content @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
        <script src="{{ asset('assets/js/bundle.js?ver=2.8.0') }}"></script>
        <script src="{{ asset('assets/js/scripts.js?ver=2.8.0') }}"></script>
        @stack('scripts')
    </body>
</html>