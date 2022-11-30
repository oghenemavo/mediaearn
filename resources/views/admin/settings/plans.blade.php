@extends('layouts.admin.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/editors/tinymce.css?ver=2.8.0') }}">
    <style>
        img.cover-image {
            width: 150px;
            height:150px;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')

<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Manage Plans</h4>
                    <div class="nk-block-des">
                        <p>view and manage plans.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools gx-3">
                        <li><a href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#create_video_modal"><em class="icon ni ni-plus"></em></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table id="video_table" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Plan Name</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Price</span></th>
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


<!-- @Video Create Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="create_video_modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Add a Plan</h5>
                
                <form id="create_video" action="{{ route('admin.create.plans') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="title">Plan Title</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg  @error('title') is-invalid @enderror"
                            id="title" name="title" value="{{ old('title') }}" autofocus>
                            
                            @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="price">Price</label>
                        </div>
                        <div class="form-control-wrap">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon3">&#8358;</span>
                                </div>
                                <input type="number" class="form-control form-control-lg  @error('price') is-invalid @enderror"
                                id="price" name="price" value="{{ old('price') }}" min="100" step="0.01" max="1000000000">
                            
                                @error('price')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="description">Plan Description</label>
                        </div>
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-lg  @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                           
                           
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row gy-4">
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button type="submit" class="btn btn-lg btn-primary">Create Plan</button>
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
    <script src="{{ asset('assets/js/libs/editors/tinymce.js?ver=2.8.0') }}"></script>
    <script src="{{ asset('assets/js/editors.js?ver=2.8.0') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <script>
        $(function() {
            NioApp.DataTable($('#video_table'), {
                ajax: {
                    url: `{{ route('get.plans') }}`,
                    dataSrc: 'plans'
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
                    { data: 'title', className: 'nk-tb-col tb-col-md' },
                    { data : 'price', className : 'nk-tb-col tb-col-md' },
                    { 
                        data : 'status', className : 'nk-tb-col tb-col-md',
                        render: function(data) {
                            var activity = '';
                            if (data == '0') {
                                activity += `<span class="badge badge-dim badge-pill badge-gray">Inactive</span>`;
                            } else {
                                activity += `<span class="badge badge-dim badge-pill badge-success">Active</span>`;
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
                        targets   : 4,
                        className : 'nk-tb-col nk-tb-col-tools',
                        data      : null,
                        render    : function (data, type, full, meta) {
                            let video_status = '';
                            if (data.status == '1') {
                                video_status += `<li><a href="#" class="block-video">
                                    <em class="icon ni ni-na text-danger"></em>
                                    <span class="text-danger">Deactivate Plan</span>
                                </a></li>`;
                            } else {
                                video_status = `<li><a href="#" class="activate-video">
                                    <em class="icon ni ni-check-circle text-success"></em>
                                    <span class="text-success">Activate Plan</span>
                                </a></li>`;
                            }

                            let showUrl = `{{ route('admin.show.plans', ':id') }}`;
                            showUrl = showUrl.replace(':id', data.id);

                            return `
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#" data-toggle="modal" data-target="#view_video_${data.id}"><em class="icon ni ni-eye"></em><span>View Plan</span></a></li>
                                                    <li><a href="${showUrl}"><em class="icon ni ni-edit"></em><span>Edit Plan</span></a></li>
                                                    <li class="divider"></li>
                                                    ${video_status}
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <!-- @View Video Modal-->
                                <div class="modal fade" tabindex="-1" role="dialog" id="view_video_${data.id}">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                            <div class="modal-body modal-body-lg">
                                                <h5 class="modal-title">User</h5>
                                                
                                                <dl class="row pt-3">
                                                    <dt class="col-sm-3">Title</dt>
                                                    <dd class="col-sm-9">${data.title}</dd>

                                                    <dt class="col-sm-3 text-truncate">Video Description</dt>
                                                    <dd class="col-sm-9">${data.description}</dd>
    
                                                    <dt class="col-sm-3">Price</dt>
                                                    <dd class="col-sm-9">&#8358;${data.price}</dd>
    
                                                    <dt class="col-sm-3">Discount</dt>
                                                    <dd class="col-sm-9">${data.set_discount ? '&#8358;' + data.set_discount : 'No Discount Set' }</dd>
    
                                                    <dt class="col-sm-3">Status</dt>
                                                    <dd class="col-sm-9">
                                                        ${data.status == '1' ? '<span class="badge badge-dot badge-success">Active</span>' : '<span class="badge badge-dot badge-danger">Inactive</span>'}
                                                    </dd>
                                                </dl>
                                            
                                            </div><!-- .modal-body -->
                                        </div><!-- .modal-content -->
                                    </div><!-- .modal-dialog -->
                                </div>
                                <!--View Video .modal -->
                            `;
                        }
                    }
                ],
            });

            $('#video_table tbody').on('click', 'a.activate-video', function (e) { // activate user
                e.preventDefault();
    
                const dt = $.fn.DataTable.Api( $('#video_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data
                
                let activateUrl = `{{ route('admin.activate.plans', ':id') }}`;
                activateUrl = activateUrl.replace(':id', data.id);
    
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Users would have access to this plan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, activate plan!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'PUT',
                            url: activateUrl,
                            data: {
                                "_token": `{{ csrf_token() }}`, 
                                video_id: data.id,
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('success')) {
                                    dt.ajax.reload();
                                    NioApp.Toast('Plan has been activated.', 'success', {position: 'top-right'});
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
    
            $('#video_table tbody').on('click', 'a.block-video', function (e) { // add product to cart
                e.preventDefault();
    
                const dt = $.fn.DataTable.Api( $('#video_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data

                let deactivateUrl = `{{ route('admin.deactivate.plans', ':id') }}`;
                deactivateUrl = deactivateUrl.replace(':id', data.id);
    
                Swal.fire({
                    title: 'Are you sure?',
                    text: "User won't have access to this content!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Block plan!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'PUT',
                            url: deactivateUrl,
                            data: {
                                "_token": `{{ csrf_token() }}`, 
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('success')) {
                                    dt.ajax.reload();
                                    NioApp.Toast('Plan has been deactivated.', 'info', {position: 'top-right'});
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

            $.validator.setDefaults({
                errorElement: "div",
                errorClass: 'invalid-feedback',
                highlight: function highlight(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function unhighlight(element) {
                    $(element).removeClass('is-invalid');
                },
                errorPlacement: function errorPlacement(error, element) {
                    error.insertAfter(element);
                }
            });

            $('#create_video').validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 4,
                    },
                    description: {
                        required: true,
                        minlength: 20,
                    },
                    price: {
                        required: true,
                        min: 100,
                        max: 1000000000,
                    },
                }
            });
        });
    </script>
@endpush