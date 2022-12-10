@extends('layouts.sections')

@section('main')

    @inject('category', 'App\Models\Category')

    <!-- header -->
    <header class="header">
        <div class="header__wrap">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="header__content">
                            <!-- header logo -->
                            <a href="{{ route('home') }}" class="header__logo">
                                <img src="{{ asset('assets/images/earners-logo.png') }}" width="80" height="80" alt="earners logo">
                            </a>
                            <!-- end header logo -->

                            <!-- header nav -->
                            <ul class="header__nav">

                                <li class="header__nav-item">
                                    <a href="{{ route('home') }}" class="header__nav-link {{ request()->routeIs('home') ? 'header__nav-link--active' : '' }}">Home</a>
                                </li>

                                <!--  -->

                                <!-- dropdown -->
                                <li class="header__nav-item">
                                    <a class="dropdown-toggle header__nav-link  {{ request()->routeIs('category*') ? 'header__nav-link--active' : '' }}" href="#" role="button" id="dropdownMenuCatalog" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Categories</a>

                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuCatalog">
                                        @foreach($category->get() as $data)
                                            <li><a href="{{ route('category', $data->slug) }}">{{ $data->category }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <!-- end dropdown -->

                                @auth('web')
                                    <li class="header__nav-item">
                                        <a href="{{ route('pricing') }}" class="header__nav-link">Pricing Plan</a>
                                    </li>
                                @endauth

                                <li class="header__nav-item">
                                    <a href="{{ route('faq') }}" class="header__nav-link">FAQ</a>
                                </li>

                                <!-- dropdown -->
                                @auth('web')
                                <li class="dropdown header__nav-item">
                                    <a class="dropdown-toggle header__nav-link header__nav-link--more" href="#" role="button" id="dropdownMenuMore" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="icon ion-ios-more"></i></a>

                                    <ul class="dropdown-menu header__dropdown-menu" aria-labelledby="dropdownMenuMore">
                                        <li><a href="{{ route('profile') }}">Profile</a></li>
                                        <li><a href="{{ route('user.referrals') }}">Referrals</a></li>
                                        <li><a href="{{ route('user.transactions') }}">Transactions</a></li>
                                        <li><a href="{{ route('user.rewards') }}">Rewards</a></li>
                                        <li><a href="{{ route('user.earnings') }}">Earnings</a></li>
                                        <li><a href="{{ route('user.logout') }}">logout</a></li>
                                    </ul>
                                </li>
                                @endauth
                                <!-- end dropdown -->
                            </ul>
                            <!-- end header nav -->

                            @if (Route::has('login'))
                                @auth('web')
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
                    <h6 class="footer__title">Watch Videos, Earn Money!</h6>
                    <ul class="footer__app">
                        <li><a href="{{ route('home') }}"><img src="{{ asset('assets/images/earners-logo.png') }}" alt=""></a></li>
                        <!-- <li><a href="#"><img src="img/google-play-badge.png" alt=""></a></li> -->
                    </ul>
                </div>
                <!-- end footer list -->

                <!-- footer list -->
                <div class="col-6 col-sm-4 col-md-3">
                    <h6 class="footer__title">Resources</h6>
                    <ul class="footer__list">
                        <li><a href="#">About Us</a></li>
                        @auth('web')
                            <li><a href="{{ route('pricing') }}">Pricing Plan</a></li>
                        @endauth
                        <li><a href="{{ route('faq') }}">FAQ</a></li>
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
                        <li><a href="mailto:support@earnersview.com">support@earnersview.com</a></li>
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
                        <small><a target="_blank" href="{{ route('home') }}">Earners view</a></small>

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