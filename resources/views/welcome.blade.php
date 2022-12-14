@extends('layouts.app')

@section('content')

    <!-- home -->
    <section class="home">
        <!-- home bg -->
        <div class="owl-carousel home__bg">
            <div class="item home__cover" data-bg="{{ asset('img/home/home__bg.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('img/home/home__bg2.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('img/home/home__bg3.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('img/home/home__bg4.jpg') }}"></div>
        </div>
        <!-- end home bg -->

        @php $j = 0; @endphp

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="home__title">Watch Videos, Earn Money</h1>

                    <button class="home__nav home__nav--prev" type="button">
                        <i class="icon ion-ios-arrow-round-back"></i>
                    </button>
                    <button class="home__nav home__nav--next" type="button">
                        <i class="icon ion-ios-arrow-round-forward"></i>
                    </button>
                </div>

                <div class="col-12">
                    <div class="owl-carousel home__carousel">
                        @for($i=0; $i < count($carousel); $i++)
                            <div class="item">
                                <!-- card -->
                                <div class="card card--big">
                                    <div class="card__cover">
                                        <img class="image-feature-cover" src="{{ $carousel[$i]->cover }}" alt="{{ $carousel[$i]->slug }}">
                                        <a href="{{ route('get.video', $carousel[$i]->slug) }}" class="card__play">
                                            <i class="icon ion-ios-play"></i>
                                        </a>
                                    </div>
                                    <div class="card__content">
                                        <h3 class="card__title"><a href="{{ route('get.video', $carousel[$i]->slug) }}">{{ $carousel[$i]->title }}</a></h3>
                                        <span class="card__category">
                                            <a href="{{ route('category', $carousel[$i]->category->slug) }}">{{ $carousel[$i]->category->category }}</a>
                                            <!-- <a href="#">Triler</a> -->
                                        </span>
                                        <span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span>
                                    </div>
                                </div>
                                <!-- end card -->
                            </div>
                            
                            @if($i > 3 && $i % 3 == 0)
                                @if(isset($promotions[$j]) && $promotions[$j]->ads_type == 'image')
                                    <div class="item">
                                        <!-- card -->
                                        <div class="card card--big">
                                            <div class="card__cover">
                                                <span class="ads-label">ADS</span>
                                                <img class="image-feature-cover" src="{{ $promotions[$j]->material }}" alt="{{ $promotions[$j]->title }}">
                                            </div>
                                            <div class="card__content">
                                            </div>
                                        </div>
                                        <!-- end card -->
                                    </div>
                                @endif
                            @endif
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end home -->

    <!-- expected premiere -->
    <section class="section section--bg" data-bg="img/section/section.jpg">
        <div class="container">
            <div class="row">
                <!-- section title -->
                <div class="col-12">
                    <h2 class="section__title">Latest Videos</h2>
                </div>
                <!-- end section title -->

                

                <!-- card -->
                @for($i=0; $i < count($posts); $i++)
                    <div class="col-lg-3 col-md-3 col-sm-2">
                        <div class="card">
                            <div class="card__cover">
                                <img class="image-post-cover" src="{{ $posts[$i]->cover }}" alt="{{ $posts[$i]->slug }}">
                                <a href="{{ route('get.video', $posts[$i]->slug) }}" class="card__play">
                                    <i class="icon ion-ios-play"></i>
                                </a>
                            </div>
                            <div class="card__content">
                                <h3 class="card__title"><a href="{{ route('get.video', $posts[$i]->slug) }}">{{ $posts[$i]->title }}</a></h3>
                                <span class="card__category">
                                    <a href="{{ route('category', $posts[$i]->category->slug) }}">{{ $posts[$i]->category->category }}</a>
                                    <a href="#">Triler</a>
                                </span>
                                <span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span>
                            </div>
                        </div>
                    </div>

                    @if($i % 2 == 0)
                        @if(isset($promotions[$j]))
                            <div class="col-lg-3 col-md-3 col-sm-2">
                                <div class="card">
                                    <div class="card__cover">
                                        <span class="ads-label">ADS</span>
                                        @if($promotions[$j]->ads_type == 'video')
                                            <video src="{{ $promotions[$j]->material }}" id="player" autoplay></video>
                                        @else
                                            <img class="image-post-cover" src="{{ $promotions[$j]->material }}" alt="{{ $promotions[$j]->title }}">
                                        @endif

                                    </div>
                                </div>
                            </div>
                        @endif
                        @php $j++; @endphp
                    @endif
                @endfor
                <!-- end card -->

                <!-- section btn -->
                <div class="col-12">
                    <a href="#" class="section__btn">Show more</a>
                </div>
                <!-- end section btn -->
            </div>
        </div>
    </section>
    <!-- end expected premiere -->

@endsection


@push('scripts')
    <script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>
@endpush