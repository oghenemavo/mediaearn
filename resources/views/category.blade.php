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
    
	<!-- catalog -->
	<div class="catalog" style="margin-top: 24px;">
		<div class="container">
			<div class="row">
                <!-- card -->
                @foreach($posts as $item)
					@if(strtolower($item['type']) == 'ads' && $item['ads_type'] == 'video')
						@continue
					@endif

					<div class="col-lg-3 col-md-3 col-sm-2">
                    <!-- <div class="col-6 col-sm-4 col-lg-3 col-xl-2"> -->
                        <div class="card">
                            <div class="card__cover">
								@if(strtolower($item['type']) == 'ads' && $item['ads_type'] == 'image')
									<span class="ads-label">ADS</span>
									<img class="image-post-cover" src="{{ $item['cover'] }}" alt="{{ $item['title'] }}">
								@else
									<img class="image-post-cover" src="{{ $item['cover'] }}" alt="{{ $item['slug'] }}">
									<a href="{{ route('get.video', $item['id']) }}" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								@endif
                            </div>
                            <div class="card__content">
								@if(strtolower($item['type']) == 'post')
									<h3 class="card__title"><a href="{{ route('get.video', $item['slug']) }}">{{ $item['title'] }}</a></h3>
									<!-- <span class="card__category">
										<a href="#">Action</a>
										<a href="#">Triler</a>
									</span> -->
									<span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span>
								@endif
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- end card -->

				<!-- paginator -->
				<div class="col-12">
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
				</div>
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

				@foreach($sponsored as $post)
					@if($post['ads_type'] == 'video')
						@continue
					@endif

					<!-- card -->
					<div class="col-6 col-sm-4 col-lg-3 col-xl-2">
						<div class="card">
							<div class="card__cover">
								<img src="{{ $post['cover'] }}" width="160" height="237" style="object-fit: cover;" alt="">
								<!-- <a href="#" class="card__play">
									<i class="icon ion-ios-play"></i>
								</a> -->
							</div>
							<div class="card__content">
								<h3 class="card__title">{{ $post['title'] }}</h3>
							</div>
						</div>
					</div>
					<!-- end card -->
				@endforeach

			</div>
		</div>
	</section>
	<!-- end expected premiere -->

@endsection