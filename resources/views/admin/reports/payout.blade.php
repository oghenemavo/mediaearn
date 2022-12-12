@extends('layouts.admin.app')

@section('content')

<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Payout info & report</h4>
                    <div class="nk-block-des">
                        <p>Payout, status and reports.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table id="payout_table" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col tb-col-mb">User</th>
                            <th class="nk-tb-col tb-col-mb">Transaction Id</th>
                            <th class="nk-tb-col tb-col-mb">Receipt No.</th>
                            <th class="nk-tb-col tb-col-mb">Amount</th>
                            <th class="nk-tb-col tb-col-mb">Status</th>
                            <th class="nk-tb-col tb-col-mb">Message</th>
                            <th class="nk-tb-col tb-col-mb">Created at</th>
                        </tr>
                    </thead>
                    <tbody>                        
                    </tbody>
                </table>
            </div>
        </div><!-- .card-preview -->
    </div> <!-- nk-block -->
</div>

@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <script>
        $(function() {
            NioApp.DataTable($('#payout_table'), {
                ajax: {
                    url: `{{ route('get.payouts') }}`,
                    dataSrc: 'payouts'
                },
                createdRow: function( row, data, dataIndex ) {
                    $(row).addClass( 'nk-tb-item' );
                },
                buttons: [
                    {
                        text: 'Reload',
                        className: 'btn reload px-2 btn-primary btn-sm',
                        action: function ( e, dt, node, config ) {
                            dt.ajax.reload();
                        },
                    },
                ],
                columns: [
                    { data: 'name', className: 'nk-tb-col tb-col-md' },
                    { data : 'reference', className : 'nk-tb-col tb-col-md' },
                    { data : 'receipt', className : 'nk-tb-col tb-col-md' },
                    { data : 'amount', className : 'nk-tb-col tb-col-md' },
                    { 
                        data : 'status', className : 'nk-tb-col tb-col-md',
                        render: function(data) {
                            var activity = '';
                            if (data == 'successful') {
                                activity += `<span class="badge badge-dim badge-pill badge-warning">
                                    <em class="icon ni ni-check-circle text-success"></em>&nbsp; Success
                                </span>`;
                            } else if (data == 'failed') {
                                activity += `<span class="badge badge-dim badge-pill badge-danger">
                                    <em class="icon ni ni-na text-danger"></em>&nbsp; Failed
                                </span>`;
                            } else if (data == 'new') {
                                activity += `<span class="badge badge-dim badge-pill badge-info">
                                <em class="icon ni ni-layers text-info"></em>&nbsp; Queued
                                </span>`;
                            } else {
                                activity += `<span class="badge badge-dim badge-pill badge-primary">
                                <em class="icon ni ni-loader text-primary"></em>&nbsp; Pending
                                </span>`;
                            }
                            return activity;
                        } 
                    },
                    { data : 'message', className : 'nk-tb-col tb-col-md' },
                    { 
                        data        : 'created_at', className   : 'nk-tb-col tb-col-lg',
                        render      : function (data) {
                            return `<span>${moment(data).format('DD-MM-YYYY')}</span>`;
                        } 
                    },
                ],
            });

        });
    </script>
@endpush