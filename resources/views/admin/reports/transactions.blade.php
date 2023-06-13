@extends('layouts.admin.app')

@section('content')

<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Transaction info & report</h4>
                    <div class="nk-block-des">
                        <p>Payment, Transaction reports.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table id="transaction_table" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Name</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Email</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Type</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Amount</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Reference</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Created at</span></th>
                            <th class="nk-tb-col nk-tb-col-tools text-right"></th>
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
            NioApp.DataTable($('#transaction_table'), {
                'order': [],
                ajax: {
                    url: `{{ route('get.transactions') }}`,
                    dataSrc: 'transactions'
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
                    { data : 'email', className : 'nk-tb-col tb-col-md' },
                    { data : 'type', className : 'nk-tb-col tb-col-md' },
                    { data : 'amount', className : 'nk-tb-col tb-col-md' },
                    { data : 'reference', className : 'nk-tb-col tb-col-md' },
                    {
                        data : 'status', className : 'nk-tb-col tb-col-md',
                        render: function(data) {
                            var activity = '';
                            if (data == '0') {
                                activity += `<span class="badge badge-dim badge-pill badge-warning">
                                    <em class="icon ni ni-na text-danger"></em>&nbsp; Not verified
                                </span>`;
                            } else {
                                activity += `<span class="badge badge-dim badge-pill badge-success">
                                    <em class="icon ni ni-check-circle text-success"></em>&nbsp; Verified
                                </span>`;
                            }
                            return activity;
                        }
                    },
                    {
                        data        : 'created_at', className   : 'nk-tb-col tb-col-lg',
                        render      : function (data) {
                            return `<span>${moment(data).format('DD-MM-YYYY')}</span>`;
                        }
                    },
                ],
                columnDefs: [
                    {
                        targets   : 6,
                        className : 'nk-tb-col nk-tb-col-tools',
                        data      : null,
                        render    : function (data, type, full, meta) {
                            let transaction_status = '';
                            if (data.status == '0') {
                                transaction_status = `
                                    <ul class="nk-tb-actions gx--1">
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#" class="requery-transaction">
                                                            <span class="text-success">Requery Transaction</span>
                                                        </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                `;
                            }
                            return transaction_status;
                        }
                    }
                ],
            });

            $('#transaction_table tbody').on('click', 'a.requery-transaction', function (e) { // activate user
                e.preventDefault();

                const dt = $.fn.DataTable.Api( $('#transaction_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action would validate user transaction!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, requery tranaction!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'PUT',
                            url: "{{-- route('admin.media.unblock.video') --}}",
                            data: {
                                "_token": `{{ csrf_token() }}`,
                                transaction_id: data.id,
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('success')) {
                                    dt.ajax.reload();
                                    Swal.fire('Activated!', 'Transaction has been requeried.', 'success');
                                }
                            },
                            error: function(XMLHttpRequest, textStatus, errorThrown) {
                                console.log( XMLHttpRequest.responseJSON.errors);
                                console.log(XMLHttpRequest.status)
                                console.log(XMLHttpRequest.statusText)
                                console.log(errorThrown)

                                // display toast alert
                                toastr.clear();
                                toastr.options = {
                                    "timeOut": "7000",
                                }
                                NioApp.Toast('Unable to process request now.', 'error', {position: 'top-right'});
                            }
                        });

                    }
                });
            });

        });
    </script>
@endpush
