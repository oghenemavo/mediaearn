@extends('layouts.app')

@push('headers')
    @php
        //set headers to NOT cache a page
        header("Cache-Control: no-cache, must-revalidate"); //HTTP 1.1
        header("Pragma: no-cache"); //HTTP 1.0
        header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
    @endphp
@endpush

@section('content')

    <!-- home -->
    <section class="home">
        <!-- home bg -->
        <div class="owl-carousel home__bg">
            <div class="item home__cover" data-bg="{{ asset('app/img/home/home__bg.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('app/img/home/home__bg2.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('app/img/home/home__bg3.jpg') }}"></div>
            <div class="item home__cover" data-bg="{{ asset('app/img/home/home__bg4.jpg') }}"></div>
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
                                        <!-- <span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span> -->
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
    <section class="section section--bg" data-bg="/app/img/section/section.jpg">
        <div class="container">
            <div class="row">

                <div class="col-12">
                    <div class="card" style="border: 1px solid #fff; padding: 10px;max-width: 28rem;border-radius: 6px;">
                        <div class="card-body" style="color: #fff;">
                            <h3>Invite & earn even more!</h3>
                            <p class="card-text">
                                Referral Program: Refer your friend and get
                                @if(strtolower($referral_bonus_type) == 'fixed')
                                    &#8358;{{ $referral_bonus }} instantly
                                @else
                                    {{ $referral_bonus }}% of their deposit
                                @endif
                                 and get {{ $downline_bonus }}% of their earnings
                            </p>
                            @auth('web')
                                <p>Referral link: {{ route('signup.page', auth('web')->user()->referral_code) }}</p>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- section title -->
                <div class="col-12">
                    <h2 class="section__title">Latest Videos</h2>
                </div>
                <!-- end section title -->



                <!-- card -->
                @foreach($posts as $post)
                    <div class="col-lg-3 col-md-3 col-sm-2">
                        <div class="card">
                            <div class="card__cover">
                                <img class="image-post-cover" src="{{ $post->cover }}" alt="{{ $post->slug }}">
                                <a href="{{ route('get.video', $post->slug) }}" class="card__play">
                                    <i class="icon ion-ios-play"></i>
                                </a>
                            </div>
                            <div class="card__content">
                                <h3 class="card__title"><a href="{{ route('get.video', $post->slug) }}">{{ $post->title }}</a></h3>
                                <span class="card__category">
                                    <a href="{{ route('category', $post->category->slug) }}">{{ $post->category->category }}</a>
                                    <!-- <a href="#">Triller</a> -->
                                </span>
                                <!-- <span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span> -->
                            </div>
                        </div>
                    </div>

                @endforeach
                <!-- end card -->


                {{ $posts->links() }}

                <!-- section btn -->
                <!-- <div class="col-12">
                    <a href="#" class="section__btn">Show more</a>
                </div> -->
                <!-- end section btn -->
            </div>
        </div>
    </section>
    <!-- end expected premiere -->

    <!-- expected premiere -->
	<section class="section section--bg" data-bg="{{ asset('app/img/section/section.jpg') }}">
		<div class="container">
			<div class="row">
				<!-- section title -->
				<div class="col-12">
					<h2 class="section__title">Sponsored Content</h2>
				</div>
				<!-- end section title -->


                <div class="owl-carousel owl-theme">
                    <x-part-ads limit="10"></x-part-ads>
                </div>

			</div>
		</div>
	</section>
	<!-- end expected premiere -->

@endsection


@push('scripts')
    <script src="https://cdn.plyr.io/3.7.3/plyr.js"></script>
@endpush
