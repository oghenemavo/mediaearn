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
                            <input type="hidden" id="bank" value="{{ $bank }}">
                            <input type="hidden" id="account_number" value="{{ $account_number }}">
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

						<p style="padding: 10px; background: #fff;">Balance: &#8358;{{$balance}}</p>



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
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

    <script>
        $(document).ready(function() {
            let bank = $('#bank').val();
            let accountNumber = $('#account_number').val();
            
            $('#payout').click(function (e) {
                e.preventDefault();

                // console.log('clicked');

                $(this).prop("disabled", true);
                $(this).html('processing...');
                $(this).css({ 'background': '#f58634'});
                $(this).hide();

                let balance = parseFloat(`{{ $balance }}`);
                let min = parseFloat(`{{ $min }}`);

                if (bank == '' || accountNumber == '') {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'warning',
                        title: `Set your Account Number and Bank to enable withdrawal`,
                        showConfirmButton: false,
                        timer: 4500,
                    })

                    $(this).css({ 'background': '#ff55a5'});
                    $(this).prop('disabled', false);
                    $(this).show();
                } else {
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
                                    setTimeout(function() {
                                        window.location.reload();
                                    }, 4000);
                                } else {
                                    if (data.hasOwnProperty('message')) {
                                        Swal.fire({
                                            position: 'top-end',
                                            icon: 'info',
                                            title: data.message,
                                            showConfirmButton: false,
                                            timer: 3500,
                                        })
                                    }

                                    $(this).css({ 'background': '#ff55a5'});
                                    $(this).prop('disabled', false);
                                    $(this).show();
                                }
                                if (data.error) {
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'danger',
                                        title: `Unable to process payout`,
                                        showConfirmButton: false,
                                        timer: 3500,
                                    })

                                    $(this).css({ 'background': '#ff55a5'});
                                    $(this).prop('disabled', false);
                                    $(this).show();
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
                    
                }

                $(this).html('Payout');
            });

            $('#earnings_table').DataTable({
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
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