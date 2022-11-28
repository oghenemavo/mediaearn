@extends('layouts.admin.app')

@section('content')

<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Referral info & report</h4>
                    <div class="nk-block-des">
                        <p>Referral, Bonus and Period reports.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table id="referral_table" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Referrer</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Referred</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Amount</span></th>
                            <!-- <th class="nk-tb-col tb-col-md"><span class="sub-text">Tax</span></th> -->
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Bonus</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Bonus in</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Bonus out</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Created at</span></th>
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
            NioApp.DataTable($('#referral_table'), {
                ajax: {
                    url: `{{ route('get.referrals') }}`,
                    dataSrc: 'referrals'
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
                    { data: 'referrer', className: 'nk-tb-col tb-col-md' },
                    { data : 'referred', className : 'nk-tb-col tb-col-md' },
                    { data : 'amount', className : 'nk-tb-col tb-col-md' },
                    // { data : 'tax', className : 'nk-tb-col tb-col-md', render: data => `${data}%` },
                    { data : 'bonus', className : 'nk-tb-col tb-col-md' },
                    { 
                        data : 'status', className : 'nk-tb-col tb-col-md',
                        render: function(data) {
                            var activity = '';
                            if (data == '0') {
                                activity += `<span class="badge badge-dim badge-pill badge-warning">
                                    <em class="icon ni ni-na text-danger"></em>&nbsp; Not Received
                                </span>`;
                            } else if (data == '1') {
                                activity += `<span class="badge badge-dim badge-pill badge-info">
                                    <em class="icon ni ni-na text-info"></em>&nbsp; Received
                                </span>`;
                            } else {
                                activity += `<span class="badge badge-dim badge-pill badge-success">
                                    <em class="icon ni ni-check-circle text-success"></em>&nbsp; Paid out
                                </span>`;
                            }
                            return activity;
                        } 
                    },
                    { 
                        data        : 'bonus_at', className   : 'nk-tb-col tb-col-lg',
                        render      : function (data) {
                            return `<span>${moment(data).format('DD-MM-YYYY')}</span>`;
                        } 
                    },
                    { 
                        data        : 'credited_at', className   : 'nk-tb-col tb-col-lg',
                        render      : function (data) {
                            return `<span>${moment(data).format('DD-MM-YYYY')}</span>`;
                        } 
                    },
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