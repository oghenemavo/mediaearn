@extends('layouts.app')

@section('content')
    <!-- content -->
	<section class="content" style="margin-top: 80px;">
		<div class="content__head">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- content title -->
						<h2 class="content__title">Profile</h2>
						<!-- end content title -->

						<!-- content tabs nav -->
						<ul class="nav nav-tabs content__tabs" id="content__tabs" role="tablist">
							<li class="nav-item">
								<a class="nav-link active" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Overview</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Edit Account</a>
							</li>

						</ul>
						<!-- end content tabs nav -->

						<!-- content mobile tabs nav -->
						<div class="content__mobile-tabs" id="content__mobile-tabs">
							<div class="content__mobile-tabs-btn dropdown-toggle" role="navigation" id="mobile-tabs" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<input type="button" value="Comments">
								<span></span>
							</div>

							<div class="content__mobile-tabs-menu dropdown-menu" aria-labelledby="mobile-tabs">
								<ul class="nav nav-tabs" role="tablist">
									<li class="nav-item"><a class="nav-link active" id="1-tab" data-toggle="tab" href="#tab-1" role="tab" aria-controls="tab-1" aria-selected="true">Overview</a></li>

									<li class="nav-item"><a class="nav-link" id="2-tab" data-toggle="tab" href="#tab-2" role="tab" aria-controls="tab-2" aria-selected="false">Edit Account</a></li>

								</ul>
							</div>
						</div>
						<!-- end content mobile tabs nav -->
					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8 col-xl-8">
					<!-- content tabs -->
					<div class="tab-content" id="myTabContent">

                        <!-- notifications alert -->
                        @foreach(['primary', 'secondary', 'success', 'info', 'warning', 'danger'] as $alert)
                            @if(session()->has($alert))
                                <x-app-alert type="{{ $alert }}" :message="session()->get($alert)"/>
                            @endif
                        @endforeach
                        <!-- notifications alert -->

						<div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="1-tab">
							<div class="row">
								<!-- comments -->
								<div class="col-12">
									<div class="comments">
										<ul class="comments__list">
											<li class="comments__item">
												<div class="comments__autor">
													<img class="comments__avatar" src="img/user.png" alt="">
													<span class="comments__name">{{ $user->last_name . ' ' . $user->first_name }}</span>
													<span class="comments__time">Referral link: {{ route('signup.page', $user->referral_code) }}</span>
												</div>

											</li>
										</ul>

										<form action="#" class="form">
											<input type="text" class="form__input" value="{{ $user->email }}" readonly>
											<input type="text" class="form__input" value="{{ $bank }}" readonly>
											<input type="text" class="form__input" value="{{ $user->account_number ?? 'Account Number' }}" readonly>
										</form>
									</div>
								</div>
								<!-- end comments -->
							</div>
						</div>

						<div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="2-tab">
							<div class="row">
								<!-- email -->
								<div class="col-12">
									<div class="reviews">
										<form id="" action="{{ route('change.email') }}" method="post" class="form">
                                            @csrf
											<input type="email" class="form__input" name="email" placeholder="New Email">

											<button type="submit" class="form__btn">Change Email</button>
										</form>
									</div>
								</div>
								<!-- end email -->

								<!-- password -->
								<div class="col-12">
									<div class="reviews">
										<form id="" action="{{ route('change.password') }}" method="post" class="form">
                                            @csrf
											<input type="password" class="form__input" name="current_password" placeholder="Current Password">
											<input type="password" class="form__input" name="password" placeholder="New Password">
											<input type="password" class="form__input" name="password_confirmation" placeholder="Confirm Password">

											<button type="submit" class="form__btn">Change Password</button>
										</form>
									</div>
								</div>
								<!-- end password -->

                                <div class="col-12">
                                    <div class="reviews">
                                        <form id="bank-form" class="form" action="{{ route('change.account.info') }}" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <label for="bank" style="color: #fff;">Financial Institution</label>
                                                <select name="bank" class="form__input" id="bank" required>
                                                  <option value="">Select a Bank</option>
                                                  @isset($banks)
                                                    @foreach($banks['data'] as $bank)
                                                    <option value="{{ $bank['code'] }}" @if($bank["code"] == $user->bank_code) selected="true" @endif>{{ $bank['name'] }}</option>
                                                    @endforeach
                                                  @endisset
                                                </select>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="account_number" style="color: #fff;">Account Number</label>
                                                <input type="text" id="account_number" name="account_number" minlength="10" maxlength="10" class="form__input" value="{{ $user->account_number }}" placeholder="Account Number">
                                            </div>
        
                                            <div class="form-text"></div>
        
                                            <button type="submit" id="submit-btn" class="form__btn">Setup</button>
                                        </form>
                                    </div>
                                </div>
							</div>
						</div>

					</div>
					<!-- end content tabs -->
				</div>

				<!-- sidebar -->
				<x-ads></x-ads>
				<!-- end sidebar -->
				
			</div>
		</div>
	</section>
	<!-- end content -->

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
<script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>

<script>
    $(function() {
        var bankForm = $("#bank-form");
        var submitButton = $("#submit-btn");

        // var response;
        // $.validator.addMethod(
        //     "validateAccountNumber", 
        //     function(value, element, params) {
        //         $('.form-text').val('');
        //         $.ajax({
        //             type: "POST",
        //             url: `{{ route('validate.account.number') }}`,
        //             data: {
        //                 bank_code: $('#' + params).val(),
        //                 account_number: value,
        //             },
        //             dataType: "json",
        //             success: function(data)
        //             {
        //                 let resp = JSON.parse(data);
        //                 if (resp.status == "success") {
        //                     console.log(resp.data.account_name)
        //                     // write user name
        //                     $('.form-text').val(resp.data.account_name);
        //                 } else {
        //                     // write no name found
        //                     $('.form-text').val('No Account Found');
        //                 }
        //                 //If username exists, set response to true
        //                 return response = ( resp.status == "success" ) ? true : false;
        //             }
        //         });
        //         // return response;
        //     },
        //     "Account doesnt exist"
        // );

        bankForm.on('blur keyup change', 'input', 'change', () => {
            $('.form-text').text('');
            if (bankForm.valid()) {
                fetch(`{{ route('validate.account.number') }}`, {
                    method: 'POST', // or 'PUT'
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        bank_code: $('#bank').val(),
                        account_number: $('#account_number').val(),
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status == 'success') {
                        console.log(data.data.account_name);
                        $('.form-text').text(data.data.account_name).css('color', 'white');
                        submitButton.removeAttr("disabled");
                    } else {
                        console.log('dd')
                        $('.form-text').text('No Account Found').css('color', 'red');
                        submitButton.attr("disabled", "disabled");
                    }
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            } else {
                submitButton.attr("disabled", "disabled");
            }
        });

        $('#bank').on('change', () => {
            $('#account_number').val('');
        });

        bankForm.validate({
            rules: {
                bank: {
                    required: true,
                },
                account_number: {
                    required: true,
                    number: true,
                    minlength: 10,
                    maxlength: 10,
                }
            },
        });


    });
</script>

@endpush