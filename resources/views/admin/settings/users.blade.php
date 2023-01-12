@extends('layouts.admin.app')

@section('content')
<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Manage Admin</h4>
                    <div class="nk-block-des">
                        <p>Add and manage administration.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools gx-3">
                        <li><a href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#create_admin_modal"><em class="icon ni ni-plus"></em></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table id="users_table" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col"><span class="sub-text">User</span></th>
                            <th class="nk-tb-col tb-col-mb"><span class="sub-text">Role</span></th>
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

<!-- @Admin Create Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="create_admin_modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Add an Admin</h5>
                
                <form id="create_admin" action="{{ route('admin.create.admin') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="name">Full Name</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg  @error('name') is-invalid @enderror"
                            id="name" name="name" value="{{ old('name') }}" autofocus>
                            
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="email">Email</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="email" class="form-control form-control-lg  @error('email') is-invalid @enderror"
                            id="email" name="email" value="{{ old('email') }}" autofocus>
                            
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Role</label>
                        <div class="form-control-wrap">
                            <select data-ui="lg" name="role" class="form-select @error('role') is-invalid @enderror">
                                <option>Choose a Role</option>    
                                @foreach($roles as $data)
                                    <option value="{{ $data->id }}">{{ ucfirst($data->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div data-error="role" class="error"></div>
                    </div>

                    <div class="row gy-4">
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button type="submit" class="btn btn-lg btn-primary">Create Admin</button>
                                </li>
                                <li>
                                    <a href="#" data-dismiss="modal" class="link link-light">Cancel</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!--Video Create .modal -->
@endsection


@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
    <script>

        $(function() {
            NioApp.DataTable($('#users_table'), {
                ajax: {
                    url: `{{ route('get.admins') }}`,
                    dataSrc: 'admins'
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
                    { 
                        data        : '', className: 'nk-tb-col',
                        render      : function(data, type, full) {
                            return `
                                <div class="user-card">
                                    <div class="user-avatar bg-dim-primary d-none d-sm-flex">
                                        <span>${full.initials}</span>
                                    </div>
                                    <div class="user-info">
                                        <span class="tb-lead">
                                            ${full.name} 
                                            <span class="dot dot-success d-md-none ml-1"></span>
                                        </span>
                                        <span>${full.email}</span>
                                    </div>
                                </div>
                            `;
                        }
                        
                    },
                    { 
                        data        : 'role', className: 'nk-tb-col tb-col-mb',
                        render      : function(data) {
                            return `<span>${data}</span>`;
                        }
                    },
                    {
                        data: 'status', className: 'nk-tb-col tb-col-md',
                        render : function(data) {
                            let activity = '';
                            if (data == '0' ) {
                                activity += '<span class="tb-status text-danger">inactive</span>';
                            } else {
                                activity += '<span class="tb-status text-success">active</span>';
                            }
                            return activity;
                        }
                    },
                    { 
                        data        : 'created_at', className   : 'nk-tb-col tb-col-lg',
                        render: function (data) {
                            return `<span>${moment(data).format('DD-MM-YYYY')}</span>`;
                        } 
                    },
                ],
                columnDefs: [
                    {
                        targets   : 4,
                        className : 'nk-tb-col nk-tb-col-tools',
                        data      : null,
                        render    : function (data, type, full, meta) {
                            let user_position = '';
                            if (data.status == '1' && data.role != 'Super Admin') {
                                user_position += '<li><a href="#" class="suspend-user"><em class="icon ni ni-na text-danger"></em><span>Deactivate User</span></a></li>';
                            } else if (data.status == '0' && data.role != 'Super Admin') {
                                user_position += '<li><a href="#" class="activate-user"><em class="icon ni ni-check-circle text-success"></em><span>Activate User</span></a></li>';
                            }
                            return `
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#" data-toggle="modal" data-target="#view_user_${data.id}"><em class="icon ni ni-eye"></em><span>View User</span></a></li>
                                                    <li><a href="{{ route('admin.show.admin') }}/${data.id}"><em class="icon ni ni-edit"></em><span>Edit Admin</span></a></li>
                                                    <li class="divider"></li>
                                                    ${user_position}
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                    
                                </ul>
    
                                <!-- @View User Modal-->
                                <div class="modal fade" tabindex="-1" role="dialog" id="view_user_${data.id}">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                            <div class="modal-body modal-body-lg">
                                                <h5 class="modal-title">User</h5>
                                                
                                                <dl class="row pt-3">
                                                    <dt class="col-sm-3">Full Name</dt>
                                                    <dd class="col-sm-9">${data.name}</dd>
    
                                                    <dt class="col-sm-3">Email Address</dt>
                                                    <dd class="col-sm-9">${data.email}</dd>
    
                                                    <dt class="col-sm-3">Role</dt>
                                                    <dd class="col-sm-9">${data.role}</dd>
    
                                                    <dt class="col-sm-3">Status</dt>
                                                    <dd class="col-sm-9">
                                                        ${data.status == 'active' ? '<span class="badge badge-dot badge-success">Active</span>' : '<span class="badge badge-dot badge-danger">Inactive</span>'}
                                                    </dd>
    
                                                    <dt class="col-sm-3">Registered at</dt>
                                                    <dd class="col-sm-9">${moment(data.created_at).format('DD-MM-YYYY')}</dd>
                                                </dl>
                                            
                                            </div><!-- .modal-body -->
                                        </div><!-- .modal-content -->
                                    </div><!-- .modal-dialog -->
                                </div>
                                <!--View User .modal -->
                            `;
                        }
                    }
                ],
            });
            
            $('#users_table tbody').on('click', 'a.activate-user', function (e) { // activate user
                e.preventDefault();
    
                const dt = $.fn.DataTable.Api( $('#users_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data

                let unblockUrl = `{{ route('admin.activate.admin', ':id') }}`;
                unblockUrl = unblockUrl.replace(':id', data.id);
    
                Swal.fire({
                    title: 'Are you sure?',
                    text: "User would be able to have access after confirming!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, activate user!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'PUT',
                            url: unblockUrl,
                            data: {
                                "_token": `{{ csrf_token() }}`,
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('success')) {
                                    dt.ajax.reload();
                                    Swal.fire('Activated!', 'User has been activated.', 'success');
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
    
            $('#users_table tbody').on('click', 'a.suspend-user', function (e) { // add product to cart
                e.preventDefault();
    
                const dt = $.fn.DataTable.Api( $('#users_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data

                let blockUrl = `{{ route('admin.deactivate.admin', ':id') }}`;
                blockUrl = blockUrl.replace(':id', data.id);

                Swal.fire({
                    title: 'Are you sure?',
                    text: "User won't have access after confirming!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, suspend user!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'PUT',
                            url: blockUrl,
                            data: {
                                "_token": `{{ csrf_token() }}`,
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('success')) {
                                    dt.ajax.reload();
                                    Swal.fire('Suspended!', 'User has been suspended.', 'success');
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