@extends('layouts.sections')

@section('main')

    <!-- header -->
    <header class="header">
        <div class="header__wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header__content">
                            <!-- header logo -->
                            <a href="index.html" class="header__logo">
                                <img src="{{ asset('img/logo.svg') }}" alt="">
                            </a>
                            <!-- end header logo -->

                            <!-- header nav -->
                            <ul class="header__nav">
                                <!-- dropdown -->
                                <li class="header__nav-item">
                                    <a class="dropdown-toggle header__nav-link" href="#" role="button" id="dropdownMenuHome" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Home</a>

                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuHome">
                                        <li><a href="index.html">Home slideshow bg</a></li>
                                        <li><a href="index2.html">Home static bg</a></li>
                                    </ul>
                                </li>
                                <!-- end dropdown -->

                                <!-- dropdown -->
                                <li class="header__nav-item">
                                    <a class="dropdown-toggle header__nav-link" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Catalog</a>

                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        <li><a href="catalog1.html">Catalog Grid</a></li>
                                        <li><a href="catalog2.html">Catalog List</a></li>
                                        <li><a href="details1.html">Details Movie</a></li>
                                        <li><a href="details2.html">Details TV Series</a></li>
                                    </ul>
                                </li>
                                <!-- end dropdown -->

                                <li class="header__nav-item">
                                    <a href="pricing.html" class="header__nav-link">Pricing Plan</a>
                                </li>

                                <li class="header__nav-item">
                                    <a href="faq.html" class="header__nav-link">Help</a>
                                </li>

                                <!-- dropdown -->
                                @auth
                                <li class="dropdown header__nav-item">
                                    <a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>

                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="about.html">About</a></li>
                                        <li><a href="signin.html">Sign In</a></li>
                                        <li><a href="signup.html">Sign Up</a></li>
                                        <li><a href="404.html">404 Page</a></li>
                                    </ul>
                                </li>
                                @endauth
                                <!-- end dropdown -->
                            </ul>
                            <!-- end header nav -->

                            @if (Route::has('login'))
                                @auth
                                    <!-- header menu btn -->
                                    <button class="header__btn" type="button">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </button>
                                    <!-- end header menu btn -->
                                @else
                                    <!-- header auth -->
                                    <div class="header__auth">

                                        <a href="{{ route('login.page') }}" class="header__sign-in">
                                            <i class="icon ion-ios-log-in"></i>
                                            <span>sign in</span>
                                        </a>
                                    </div>
                                    <!-- end header auth -->
                                @endauth
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </header>
    <!-- end header -->

    <!-- content starts -->
    @yield('content')
    <!-- content ends -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <!-- footer list -->
                <div class="col-12 col-md-3">
                    <h6 class="footer__title">Download Our App</h6>
                    <ul class="footer__app">
                        <li><a href="#"><img src="img/Download_on_the_App_Store_Badge.svg" alt=""></a></li>
                        <li><a href="#"><img src="img/google-play-badge.png" alt=""></a></li>
                    </ul>
                </div>
                <!-- end footer list -->

                <!-- footer list -->
                <div class="col-6 col-sm-4 col-md-3">
                    <h6 class="footer__title">Resources</h6>
                    <ul class="footer__list">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Pricing Plan</a></li>
                        <li><a href="#">Help</a></li>
                    </ul>
                </div>
                <!-- end footer list -->

                <!-- footer list -->
                <div class="col-6 col-sm-4 col-md-3">
                    <h6 class="footer__title">Legal</h6>
                    <ul class="footer__list">
                        <li><a href="#">Terms of Use</a></li>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Security</a></li>
                    </ul>
                </div>
                <!-- end footer list -->

                <!-- footer list -->
                <div class="col-12 col-sm-4 col-md-3">
                    <h6 class="footer__title">Contact</h6>
                    <ul class="footer__list">
                        <li><a href="tel:+18002345678">+1 (800) 234-5678</a></li>
                        <li><a href="mailto:support@moviego.com">support@flixgo.com</a></li>
                    </ul>
                    <ul class="footer__social">
                        <li class="facebook"><a href="#"><i class="icon ion-logo-facebook"></i></a></li>
                        <li class="instagram"><a href="#"><i class="icon ion-logo-instagram"></i></a></li>
                        <li class="twitter"><a href="#"><i class="icon ion-logo-twitter"></i></a></li>
                        <li class="vk"><a href="#"><i class="icon ion-logo-vk"></i></a></li>
                    </ul>
                </div>
                <!-- end footer list -->

                <!-- footer copyright -->
                <div class="col-12">
                    <div class="footer__copyright">
                        <small><a target="_blank" href="https://www.templateshub.net">Templates Hub</a></small>

                        <ul>
                            <li><a href="#">Terms of Use</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <!-- end footer copyright -->
            </div>
        </div>
    </footer>
    <!-- end footer -->

@endsection