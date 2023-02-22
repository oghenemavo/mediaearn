@extends('layouts.app')

@section('content')
    <!-- page title -->
	<section class="section section--first section--bg" data-bg="img/section/section.jpg">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="section__wrap">
						<!-- section title -->
						<h2 class="section__title">Pricing</h2>
						<!-- end section title -->

						<!-- breadcrumb -->
						<ul class="breadcrumb">
							<li class="breadcrumb__item"><a href="{{ route('home') }}">Home</a></li>
							<li class="breadcrumb__item breadcrumb__item--active">Pricing</li>
						</ul>
						<!-- end breadcrumb -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- end page title -->

	<!-- pricing -->
	<div class="section">
		<div class="container">
            
            <!-- notifications alert -->
            @foreach(['primary', 'secondary', 'success', 'info', 'warning', 'danger'] as $alert)
                @if(session()->has($alert))
                    <x-app-alert type="{{ $alert }}" :message="session()->get($alert)"/>
                @endif
            @endforeach
            <!-- notifications alert -->

			<div id="pricing_list" class="row">
				<!-- plan features -->
				<div class="col-12">
					<ul class="row plan-features">
						<li class="col-12 col-md-6 col-lg-4">1 month unlimited access!</li>
						<li class="col-12 col-md-6 col-lg-4">Stream on your phone, laptop, tablet or TV.</li>
						<li class="col-12 col-md-6 col-lg-4">1 month unlimited access!</li>
						<li class="col-12 col-md-6 col-lg-4">Thousands of TV shows, movies & more.</li>
						<li class="col-12 col-md-6 col-lg-4">You can even Download & watch offline.</li>
						<li class="col-12 col-md-6 col-lg-4">Thousands of TV shows, movies & more.</li>
					</ul>
				</div>
				<!-- end plan features -->

                @if(!$subscription)
                    <!-- price -->
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="price">
                            <div class="price__item price__item--first"><span>Basic</span> <span>Free</span></div>
                            <div class="price__item"><span>2 Views per days</span></div>
                            <div class="price__item"><span>720p Resolution</span></div>
                            <div class="price__item"><span>Low Earning Rewards</span></div>
                            <div class="price__item"><span>Limited Availability</span></div>
                            <!-- <div class="price__item"><span>Desktop Only</span></div> -->
                            <div class="price__item"><span>Limited Support</span></div>
                            <button class="price__btn" disabled>Selected</button>
                        </div>
                    </div>
                    <!-- end price -->
                @endif

                <!-- price -->
                @foreach($pricing as $item)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="price {{ $item->meta->get('label') ? 'price--premium' : '' }}">
                            <div class="price__item price__item--first">
                                <span>{{ $item->title }}</span> 

                                
                                @if($item->meta->get('set_discount'))
                                    <!-- <span><strike>&#8358;{{-- $item->price --}}</strike></span> -->

                                    <span>&#8358;{{ number_format($item->meta->get('discount'), 2) }}</span>
                                @else
                                    <span>&#8358;{{ number_format($item->price, 2) }}</span>
                                @endif
                            </div>
                            @foreach($item->decoded_description as $description)
                                @if(!empty($description))
                                    <div class="price__item">
                                        <span>{!! html_entity_decode($description) !!}</span>
                                    </div>
                                @endif
                            @endforeach
                            
                            @if($subscription && $membership->plan_id == $item->id)
                                <button class="price__btn make-payment" disabled style="background-color: green; background-image: none; box-shadow: none;">Selected</button>
                            @else
                                @if($balance >= $item->price)
                                    <button class="price__btn wallet-payment" type="button" data-id="{{ $item->id }}" style="background-color: black !important; background-image: none; box-shadow: none;">
                                        Pay with Wallet
                                    </button>
                                @endif

                                <button class="price__btn make-payment" type="button" data-id="{{ $item->id }}">
                                    Choose Plan
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
                <!-- end price -->

			</div>
		</div>
	</div>
	<!-- end pricing -->

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
    <script src="{{ asset('assets/js/jquery-3.6.0.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            $('#pricing_list').on('click', 'button.wallet-payment', function (e) { // activate user
                e.preventDefault();

                Swal.fire({
                    title: 'Pay with Wallet?',
                    text: "Are you sure you want to pay with wallet!",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, use wallet!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const btn = $(e.target);
                        const id = btn.attr('data-id');
                            
                        let paymentUrl = `{{ route('wallet.plans.payment', [':id', ':uid']) }}`;
                        paymentUrl = paymentUrl.replace(':id', id);
                        paymentUrl = paymentUrl.replace(':uid', `{{ auth('web')->user()->id }}`);

                        $.ajax({
                            type: 'POST',
                            url: paymentUrl,
                            data: {
                                "_token": `{{ csrf_token() }}`,
                                'preferences': `{{ $preferences }}`
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('status') && response.status == 'success') {
                                    Swal.fire(
                                    'Successful!',
                                    'Your payment has been made.',
                                    'success'
                                    )
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 3500);
                                } else {
                                    Swal.fire(
                                    'Failed!',
                                    'Unable to make payment.',
                                    'error'
                                    )

                                }
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log( XMLHttpRequest.responseJSON.errors);
                                console.log(XMLHttpRequest.status)
                                console.log(XMLHttpRequest.statusText)
                                console.log(errorThrown)
                            }
                        });
                    }
                })
    
    
                console.log();
            });

            $('#pricing_list').on('click', 'button.make-payment', function (e) { // activate user
                e.preventDefault();
    
                const btn = $(e.target);
                const id = btn.attr('data-id');
                    
                let paymentUrl = `{{ route('plans.payment', ':id') }}`;
                paymentUrl = paymentUrl.replace(':id', id);
    
                $.ajax({
                    type: 'POST',
                    url: paymentUrl,
                    data: {
                        "_token": `{{ csrf_token() }}`,
                        'preferences': `{{ $preferences }}`
                    },
                    success: function(response) {
                        if (response.hasOwnProperty('status') && response.status == 'success') {
                            window.location.replace(response.data.link);
                            // Swal.fire('Activated!', 'Video has been activated.', 'success');
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Unable to Setup Payment gateway, try later!',
                            });
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log( XMLHttpRequest.responseJSON.errors);
                        console.log(XMLHttpRequest.status)
                        console.log(XMLHttpRequest.statusText)
                        console.log(errorThrown)
                
                        // display toast alert
                        // toastr.clear();
                        // toastr.options = {
                        //     "timeOut": "7000",
                        // }
                        // NioApp.Toast('Unable to process request now.', 'error', {position: 'top-right'});
                    }
                });
                
            });
        });
    </script>
@endpush


{{-- session()->get('payment_status') --}}
