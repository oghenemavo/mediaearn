@extends('layouts.app')

@section('content')
    <!-- content -->
	<section class="content" style="margin-top: 80px;">
		<div class="content__head">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<!-- content title -->
						<h2 class="content__title">Rewards</h2>
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
                            <table id="referrals_table" class="table table-striped table-bordered " style="width:100%; color: #fff;">
                                <thead>
                                    <tr>
                                        <th>Rewarder</th>
                                        <th>Amount</th>
                                        <th>Reward at</th>
                                        <th>Status</th>
                                        <th>Reward at</th>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            let url = `{{ route('get.user.referrals', [auth('web')->user()->id, 'video']) }}`;

            $('#referrals_table').DataTable({
                'order': [],
                rowReorder: {
                    selector: 'td:nth-child(2)'
                },
                responsive: true,
                searching: false,
                lengthChange: false,
                ajax: {
                    url,
                    dataSrc: 'referrals'
                },
                buttons: [{
                    text: 'Reload',
                    className: 'btn reload px-2 btn-primary btn-sm',
                    action: function(e, dt, node, config) {
                        dt.ajax.reload();
                    },
                }, ],
                columns: [{
                        data: 'referred',
                        className: 'nk-tb-col tb-col-md'
                    },
                    {
                        data: 'bonus',
                        className: 'nk-tb-col tb-col-md',
                        render: data => `&#8358;${data}`
                    },
                    {
                        data: 'bonus_at',
                        className: 'nk-tb-col tb-col-lg',
                        render: function(data) {
                            return data ? `<span>${moment(data).format('DD-MM-YYYY')}</span>` : 'N/A';
                        }
                    },
                    {
                        data: 'status',
                        className: 'nk-tb-col tb-col-md',
                        render: (data) => {
                            var stat = "";
                            if (data == '2') {
                                stat += `<span class="badge badge-success">Bonus Received</span>`;
                            } else if (data == '1') {
                                stat += `<span class="badge badge-info">Bonus in</span>`;
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