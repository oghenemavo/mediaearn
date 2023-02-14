@extends('layouts.app')

@section('content')
    <!-- faq -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    @foreach($faq1 as $faq)
                    <div class="faq primary-text">
                        <h3 class="faq__title">{{ $faq->title }}</h3>
                        <p class="faq__text primary-text">{!! html_entity_decode($faq->description) !!}</p>
                        <!-- <p class="faq__text">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p> -->
                    </div>
                    @endforeach
                </div>

                <div class="col-12 col-md-6">
                    @foreach($faq2 as $faq)
                    <div class="faq primary-text">
                        <h3 class="faq__title">{{ $faq->title }}</h3>
                        <p class="faq__text primary-text">{!! html_entity_decode($faq->description) !!}</p>
                        <!-- <p class="faq__text">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p> -->
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
    <!-- end faq -->

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




