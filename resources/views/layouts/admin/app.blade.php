<!DOCTYPE html>
<html lang="en" class="js">
    <head>
        <base href="../">
        <meta charset="utf-8">
        <meta name="author" content="Softnio">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="A powerful and conceptual apps base dashboard template that especially build for developers and programmers.">
        <!-- Fav Icon  -->
        <link rel="shortcut icon" href="{{ asset('dashboard/images/favicon.png') }}">
        <!-- Page Title  -->
        <title>{{ $page_title ?? 'Admin Dashboard' }}</title>
        <!-- StyleSheets  -->
        <link rel="stylesheet" href="{{ asset('dashboard/css/dashlite.css?ver=2.8.0') }}">
        <link id="skin-default" rel="stylesheet" href="{{ asset('dashboard/css/theme.css?ver=2.8.0') }}">
        @stack('styles')
    </head>

    <body class="nk-body bg-white has-sidebar ">
        <div class="nk-app-root">
            <!-- main @s -->
            <div class="nk-main ">

                <!-- sidebar @s -->
                <x-admin.sidebar/>
                <!-- sidebar @e -->
                
                <!-- wrap @s -->
                <div class="nk-wrap ">
                    
                    <!-- main header @s -->
                    <x-admin.header/>
                    <!-- main header @e -->

                    <!-- content @s -->
                    <div class="nk-content nk-content-fluid">
                        <div class="container-xl wide-lg">
                            <div class="nk-content-body">

                                <!-- notifications alert -->
                                @foreach(['primary', 'secondary', 'success', 'info', 'warning', 'danger', 'gray', 'light'] as $alert)
                                    @if(session()->has($alert))
                                        <x-alert type="{{ $alert }}" :message="session()->get($alert)"/>
                                    @endif
                                @endforeach
                                <!-- notifications alert -->

                                <!-- main content -->
                                @yield('content')
                                <!-- main content -->
                            </div>
                        </div>
                    </div>
                    <!-- content @e -->
                    <!-- footer @s -->
                    <div class="nk-footer">
                        <div class="container-fluid">
                            <div class="nk-footer-wrap">
                                <div class="nk-footer-copyright"> &copy; 2020 Earners View.
                                </div>
                                <div class="nk-footer-links">
                                    <ul class="nav nav-sm">
                                        <li class="nav-item"><a class="nav-link" href="#">Terms</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Privacy</a></li>
                                        <li class="nav-item"><a class="nav-link" href="#">Help</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
        <script src="{{ asset('dashboard/js/bundle.js?ver=2.8.0') }}"></script>
        <script src="{{ asset('dashboard/js/scripts.js?ver=2.8.0') }}"></script>
        <script src="{{ asset('dashboard/js/charts/gd-default.js?ver=2.8.0') }}"></script>

        @stack('scripts')
    </body>
</html>