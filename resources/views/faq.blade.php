@extends('layouts.app')

@section('content')
    <!-- faq -->
    <section class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    @foreach($faq1 as $faq)
                    <div class="faq">
                        <h3 class="faq__title">{{ $faq->title }}</h3>
                        <p class="faq__text">{{ $faq->description }}</p>
                        <p class="faq__text">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                    </div>
                    @endforeach
                </div>

                <div class="col-12 col-md-6">
                    @foreach($faq2 as $faq)
                    <div class="faq">
                        <h3 class="faq__title">{{ $faq->title }}</h3>
                        <p class="faq__text">{!! $faq->description !!}</p>
                        <p class="faq__text">Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                    </div>
                    @endforeach
                </div>

            </div>
        </div>
    </section>
    <!-- end faq -->
@endsection




