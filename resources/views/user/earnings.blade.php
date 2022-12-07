@extends('layouts.app')

@section('content')
    <!-- content -->
	<section class="content" style="margin-top: 80px;">
		<div class="content__head">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- content title -->
                        <div class="d-flex justify-content-between">
                            <h2 class="content__title">Earnings</h2>
                            <button data-min="{{ $min }}" data-balance="{{ $balance }}" id="payout" class="form__btn">Payout</button>

                        </div>
						<!-- end content title -->

					</div>
				</div>
			</div>
		</div>

		<div class="container">
			<div class="row">
				<div class="col-12 col-lg-8 col-xl-8">
                    <div class="row">
                        <!-- comments -->
                        <div class="col-12">
                            <table id="earnings_table" class="table table-striped table-bordered" style="width:100%; color: #fff;">
                                <thead>
                                    <tr>
                                        <th>Video</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Watched at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                        <!-- end comments -->
                    </div>
                    
				</div>

				<!-- sidebar -->
				<div class="col-12 col-lg-4 col-xl-4">
					<div class="row">
						<!-- section title -->
						<div class="col-12">
							<h2 class="section__title section__title--sidebar">You may also like...</h2>
						</div>
						<!-- end section title -->

						<!-- card -->
						<div class="col-6 col-sm-4 col-lg-6">
							<div class="card">
								<div class="card__cover">
									<img src="img/covers/cover.jpg" alt="">
									<a href="#" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="#">I Dream in Another Language</a></h3>
									<span class="card__category">
										<a href="#">Action</a>
										<a href="#">Triler</a>
									</span>
									<span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span>
								</div>
							</div>
						</div>
						<!-- end card -->

						<!-- card -->
						<div class="col-6 col-sm-4 col-lg-6">
							<div class="card">
								<div class="card__cover">
									<img src="img/covers/cover2.jpg" alt="">
									<a href="#" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="#">Benched</a></h3>
									<span class="card__category">
										<a href="#">Comedy</a>
									</span>
									<span class="card__rate"><i class="icon ion-ios-star"></i>7.1</span>
								</div>
							</div>
						</div>
						<!-- end card -->

						<!-- card -->
						<div class="col-6 col-sm-4 col-lg-6">
							<div class="card">
								<div class="card__cover">
									<img src="img/covers/cover3.jpg" alt="">
									<a href="#" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="#">Whitney</a></h3>
									<span class="card__category">
										<a href="#">Romance</a>
										<a href="#">Drama</a>
										<a href="#">Music</a>
									</span>
									<span class="card__rate"><i class="icon ion-ios-star"></i>6.3</span>
								</div>
							</div>
						</div>
						<!-- end card -->

						<!-- card -->
						<div class="col-6 col-sm-4 col-lg-6">
							<div class="card">
								<div class="card__cover">
									<img src="img/covers/cover4.jpg" alt="">
									<a href="#" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="#">Blindspotting</a></h3>
									<span class="card__category">
										<a href="#">Comedy</a>
										<a href="#">Drama</a>
									</span>
									<span class="card__rate"><i class="icon ion-ios-star"></i>7.9</span>
								</div>
							</div>
						</div>
						<!-- end card -->

						<!-- card -->
						<div class="col-6 col-sm-4 col-lg-6">
							<div class="card">
								<div class="card__cover">
									<img src="img/covers/cover5.jpg" alt="">
									<a href="#" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="#">I Dream in Another Language</a></h3>
									<span class="card__category">
										<a href="#">Action</a>
										<a href="#">Triler</a>
									</span>
									<span class="card__rate"><i class="icon ion-ios-star"></i>8.4</span>
								</div>
							</div>
						</div>
						<!-- end card -->

						<!-- card -->
						<div class="col-6 col-sm-4 col-lg-6">
							<div class="card">
								<div class="card__cover">
									<img src="img/covers/cover6.jpg" alt="">
									<a href="#" class="card__play">
										<i class="icon ion-ios-play"></i>
									</a>
								</div>
								<div class="card__content">
									<h3 class="card__title"><a href="#">Benched</a></h3>
									<span class="card__category">
										<a href="#">Comedy</a>
									</span>
									<span class="card__rate"><i class="icon ion-ios-star"></i>7.1</span>
								</div>
							</div>
						</div>
						<!-- end card -->
					</div>
				</div>
				<!-- end sidebar -->
			</div>
		</div>
	</section>
	<!-- end content -->
@endsection

@push('scripts')
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#payout').click(function () { 
                let balance = parseFloat(`{{ $balance }}`);
                let min = parseFloat(`{{ $min }}`);
                if (balance >= min) {
                    $.post("{{ route('request.payout') }}",
                        {
                            "_token": `{{ csrf_token() }}`,
                            balance: `{{ $balance }}`,
                        },
                        function (data, textStatus, jqXHR) {
                            if (data.success) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: `&#8358;{{ $balance }} has been approved for payout`,
                                    showConfirmButton: false,
                                    timer: 3500,
                                })
                            }
                            if (data.error) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'danger',
                                    title: `Unable to process payout`,
                                    showConfirmButton: false,
                                    timer: 3500,
                                })
                            }
                        },
                        "json"
                    );
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: `Insufficient Balance, Min Payout is &#8358;{{ $min }} `,
                        showConfirmButton: false,
                        timer: 3500,
                    })
                }
            });

            $('#earnings_table').DataTable({
                searching: false,
                lengthChange: false,
                ajax: {
                    url: `{{ route('get.user.earnings', auth()->guard('web')->user()->id) }}`,
                    dataSrc: 'video_logs'
                },
                buttons: [
                    {
                        text: 'Reload',
                        className: 'btn reload px-2 btn-primary btn-sm',
                        action: function(e, dt, node, config) {
                            dt.ajax.reload();
                        },
                    },
                ],
                columns: [
                    {
                        data: 'video',
                        className: 'nk-tb-col tb-col-md'
                    },
                    {
                        data: 'amount',
                        className: 'nk-tb-col tb-col-md',
                        render: data => `&#8358;${data}`
                    },
                    {
                        data: 'status',
                        className: 'nk-tb-col tb-col-md',
                        render: (data) => {
                            var stat = "";
                            if (data == '1') {
                                stat += `<span class="badge badge-success">Paid</span>`;
                            } else {
                                stat += `<span class="badge badge-primary">Pending</span>`;
                            }
                            return stat;
                        }
                    },
                    {
                        data: 'created_at',
                        className: 'nk-tb-col tb-col-lg',
                        render: function(data) {
                            return `<span>${moment(data).format('DD-MM-YYYY')}</span>`;
                        }
                    },
                ]
            });
        });
    </script>
@endpush