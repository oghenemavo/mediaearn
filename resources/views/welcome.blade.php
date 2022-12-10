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

                        @foreach($carousel as $item)
                        <div class="item">
                            <!-- card -->
                            <div class="card card--big">
                                <div class="card__cover">
                                    <span class="ads-label">ADS</span>
                                    <img class="image-feature-cover" src="{{ $item->cover }}" alt="">
                                    <a href="{{ route('get.video', $item->slug) }}" class="card__play">
                                        <i class="icon ion-ios-play"></i>
                                    </a>
                                </div>
                                <div class="card__content">
                                    <h3 class="card__title"><a href="{{ route('get.video', $item->slug) }}">{{ $item->title }}</a></h3>
                                    <span class="card__category">
                                        <a href="{{ route('category', $item->category->slug) }}">{{ $item->category->category }}</a>
                                        <!-- <a href="#">Triler</a> -->
                                    </span>
                                    <span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span>
                                </div>
                            </div>
                            <!-- end card -->
                        </div>
                        @endforeach

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
                @foreach($videos as $video)
                    <div class="col-lg-3 col-md-3 col-sm-2">
                    <!-- <div class="col-6 col-sm-4 col-lg-3 col-xl-2"> -->
                        <div class="card">
                            <div class="card__cover">
                                <span class="ads-label">ADS</span>
                                <img class="image-post-cover" src="{{ $video->cover }}" alt="{{ $video->slug }}">
                                <a href="{{ route('get.video', $video->slug) }}" class="card__play">
                                    <i class="icon ion-ios-play"></i>
                                </a>
                            </div>
                            <div class="card__content">
                                <h3 class="card__title"><a href="{{ route('get.video', $video->slug) }}">{{ $video->title }}</a></h3>
                                <span class="card__category">
                                    <a href="{{ route('category', $video->category->slug) }}">{{ $video->category->category }}</a>
                                    <a href="#">Triler</a>
                                </span>
                                <span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span>
                            </div>
                        </div>
                    </div>
                @endforeach
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