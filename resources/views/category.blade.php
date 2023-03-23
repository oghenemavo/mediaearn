@extends('layouts.app')

@section('content')
    <!-- page title -->
	<section class="section section--first section--bg" data-bg="img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">{{ $category->category }}</h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="#">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">{{ $category->category }}</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<div class="container" style="margin-top: 16px;">
		<div class="row">
			<!-- section title -->
			<div class="col-12">
				<h2 class="section__title">Sponsored</h2>
			</div>
			<!-- end section title -->

			<div class="owl-carousel owl-theme">
				<x-part-ads limit="10"></x-part-ads>
			</div>
			
		</div>
	</div>

	@php $j = 0; @endphp
    
	<!-- catalog -->
	<div class="catalog" style="margin-top: 24px;">
		<div class="container">
			<div class="row">

			<!-- section title -->
			<div class="col-12">
				<h2 class="section__title">Posts</h2>
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
                                    <!-- <a href="#">Triller</a> -->
                                </span>
                                <!-- <span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span> -->
                            </div>
                        </div>
                    </div>

                @endfor
                <!-- end card -->


				<!-- paginator -->
				<!-- <div class="col-12">
					<ul class="paginator">
						<li class="paginator__item paginator__item--prev">
							<a href="#"><i class="icon ion-ios-arrow-back"></i></a>
						</li>
						<li class="paginator__item"><a href="#">1</a></li>
						<li class="paginator__item paginator__item--active"><a href="#">2</a></li>
						<li class="paginator__item"><a href="#">3</a></li>
						<li class="paginator__item"><a href="#">4</a></li>
						<li class="paginator__item paginator__item--next">
							<a href="#"><i class="icon ion-ios-arrow-forward"></i></a>
						</li>
					</ul>
				</div> -->
				<!-- end paginator -->

			</div>
		</div>
	</div>
	<!-- end catalog -->

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