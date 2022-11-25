@extends('layouts.admin.app')

@push('styles')
<link rel="stylesheet" href="{{ asset('assets/css/editors/tinymce.css?ver=2.8.0') }}">
<style>
    img.cover-image {
        width: 150px;
        height: 150px;
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
                    <h4 class="nk-block-title">Manage Promotion</h4>
                    <div class="nk-block-des">
                        <p>Add and manage promotion materials.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools gx-3">
                        <li><a href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#create_promotion_modal"><em class="icon ni ni-plus"></em></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table id="promotion_table" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Title</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Thumbnail</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Status</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Expires at</span></th>
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

<!-- @Promotion Create Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="create_promotion_modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Add a Promotion Material</h5>

                <form id="create_promotion" action="{{ route('admin.media.create.promotions') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="title">Title</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg  @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" autofocus>

                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">    
                        <label class="form-label">Expiry Date</label>    
                        <div class="form-control-wrap">        
                            <input type="text" name="expiry_date" class="form-control date-picker">    
                        </div>    
                    <div class="form-note">Date format <code>mm/dd/yyyy</code></div></div>

                    <div class="form-group">    
                        <label class="form-label">Expiry Time</label>    
                        <div class="form-control-wrap">        
                            <input type="text" name="expiry_time" class="form-control time-picker" placeholder="Input placeholder">    
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="material">Promotion Material</label>
                        <div class="form-control-wrap">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('material') is-invalid @enderror" id="material" name="material">
                                <label class="custom-file-label" for="material">Choose file</label>
                                @error('material')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                                <div data-error="cover" class="error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row gy-4">
                        <div class="col-12">
                            <ul class="align-center flex-wrap flex-sm-nowrap gx-4 gy-2">
                                <li>
                                    <button type="submit" class="btn btn-lg btn-primary">Create Promotion</button>
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
</div>
<!--Promotion Create .modal -->
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
        NioApp.DataTable($('#promotion_table'), {
            ajax: {
                url: `{{ route('get.promotions') }}`,
                dataSrc: 'promotions'
            },
            createdRow: function(row, data, dataIndex) {
                $(row).addClass('nk-tb-item');
            },
            buttons: [{
                text: 'Reload',
                className: 'btn reload px-2 btn-primary btn-sm',
                action: function(e, dt, node, config) {
                    dt.ajax.reload();
                },
            }, ],
            columns: [{
                    data: 'title',
                    className: 'nk-tb-col tb-col-md'
                },
                {
                    data: 'filename',
                    className: 'nk-tb-col tb-col-md',
                    render: function(data, type, full) {
                        let imageExt = ['jpeg','png','jpg','gif','svg',];
                        let material = data.split('.').pop().toLowerCase();
                        if (imageExt.includes(material)) {
                            return '<span class="badge badge-primary">Image</span>';
                        } else {
                            return '<span class="badge badge-warning">Video</span>';
                        }
                    }
                },
                {
                    data: 'status',
                    className: 'nk-tb-col tb-col-md',
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
                    data: 'expires_at',
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data) {
                        return `<span>${moment(data).format('DD-MM-YYYY hh:mm')}</span>`;
                    }
                },
                {
                    data: 'created_at',
                    className: 'nk-tb-col tb-col-lg',
                    render: function(data) {
                        return `<span>${moment(data).format('DD-MM-YYYY')}</span>`;
                    }
                },
            ],
            columnDefs: [{
                targets: 5,
                className: 'nk-tb-col nk-tb-col-tools',
                data: null,
                render: function(data, type, full, meta) {
                    let promotion_status = '';
                    if (data.status == '1') {
                        promotion_status = `<li><a href="#" class="block-promotion">
                                    <em class="icon ni ni-na text-danger"></em>
                                    <span class="text-danger">Block Promotion</span>
                                </a></li>`;
                    } else {
                        promotion_status = `<li><a href="#" class="activate-promotion">
                                    <em class="icon ni ni-check-circle text-success"></em>
                                    <span class="text-success">Activate Promotion</span>
                                </a></li>`;
                    }

                    let view = '';
                    let imageExt = ['jpeg','png','jpg','gif','svg',];
                    let material = data.material.split('.').pop().toLowerCase();
                    if (imageExt.includes(material)) {
                        view = `<img class="cover-image" src="${data.material}" alt="${data.title}">`;
                    } else {
                        view = `<iframe src="${data.material}" title="${data.title}" allowfullscreen></iframe>`;
                    }

                    return `
                        <ul class="nk-tb-actions gx-1">
                            <li>
                                <div class="drodown">
                                    <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <ul class="link-list-opt no-bdr">
                                            <li><a href="#" data-toggle="modal" data-target="#view_promotion_${data.id}"><em class="icon ni ni-eye"></em><span>View promotion</span></a></li>
                                            <li><a href="{{-- route('admin.media.edit.promotion') --}}/${data.id}"><em class="icon ni ni-edit"></em><span>Edit promotion</span></a></li>
                                            <li class="divider"></li>
                                            ${promotion_status}
                                        </ul>
                                    </div>
                                </div>
                            </li>
                        </ul>

                        <!-- @View Promotion Modal-->
                        <div class="modal fade" tabindex="-1" role="dialog" id="view_promotion_${data.id}">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                    <div class="modal-body modal-body-lg">
                                        <h5 class="modal-title">Advertisement Info</h5>
                                        
                                        <dl class="row pt-3">
                                            <dt class="col-sm-3">Title</dt>
                                            <dd class="col-sm-9">${data.title}</dd>

                                            <dt class="col-sm-3">Cover</dt>
                                            <dd class="col-sm-9">
                                                ${view}
                                            </dd>

                                            <dt class="col-sm-3">Status</dt>
                                            <dd class="col-sm-9">
                                                ${data.is_active ? '<span class="badge badge-dot badge-success">Active</span>' : '<span class="badge badge-dot badge-danger">Inactive</span>'}
                                            </dd>
                                        </dl>
                                    
                                    </div><!-- .modal-body -->
                                </div><!-- .modal-content -->
                            </div><!-- .modal-dialog -->
                        </div>
                        <!--View Promotion .modal -->
                    `;
                }
            }],
        });

        $('#promotion_table tbody').on('click', 'a.activate-promotion', function(e) { // activate user
            e.preventDefault();

            const dt = $.fn.DataTable.Api($('#promotion_table'));
            let dtr = dt.row($(this).parents('tr')); // table row
            let data = dtr.data(); // row data

            Swal.fire({
                title: 'Are you sure?',
                text: "Users would have access to this promotion!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, activate promotion!'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: "{{-- route('admin.media.unblock.promotion') --}}",
                        data: {
                            "_token": `{{ csrf_token() }}`,
                            promotion_id: data.id,
                        },
                        success: function(response) {
                            if (response.hasOwnProperty('success')) {
                                dt.ajax.reload();
                                Swal.fire('Activated!', 'Promotion has been activated.', 'success');
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest.responseJSON.errors);
                            console.log(XMLHttpRequest.status)
                            console.log(XMLHttpRequest.statusText)
                            console.log(errorThrown)

                            // display toast alert
                            toastr.clear();
                            toastr.options = {
                                "timeOut": "7000",
                            }
                            NioApp.Toast('Unable to process request now.', 'error', {
                                position: 'top-right'
                            });
                        }
                    });

                }
            });
        });

        $('#promotion_table tbody').on('click', 'a.block-promotion', function(e) { // add product to cart
            e.preventDefault();

            const dt = $.fn.DataTable.Api($('#promotion_table'));
            let dtr = dt.row($(this).parents('tr')); // table row
            let data = dtr.data(); // row data

            Swal.fire({
                title: 'Are you sure?',
                text: "User won't have access to this content!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, suspend user!'
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        type: 'PUT',
                        url: "{{-- route('admin.media.block.promotion') --}}",
                        data: {
                            "_token": `{{ csrf_token() }}`,
                            promotion_id: data.id,
                        },
                        success: function(response) {
                            if (response.hasOwnProperty('success')) {
                                dt.ajax.reload();
                                Swal.fire('Blocked!', 'Promotion has been blocked.', 'success');
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            console.log(XMLHttpRequest.responseJSON.errors);
                            console.log(XMLHttpRequest.status)
                            console.log(XMLHttpRequest.statusText)
                            console.log(errorThrown)

                            // display toast alert
                            toastr.clear();
                            toastr.options = {
                                "timeOut": "7000",
                            }
                            NioApp.Toast('Unable to process request now.', 'error', {
                                position: 'top-right'
                            });
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

        $.validator.addMethod('filesize', function(value, element, param) {
            return this.optional(element) || (element.files[0].size <= param * 1000000)
        }, 'File size must be less than {0} MB');

        $('#create_promotion').validate({
            rules: {
                title: {
                    required: true,
                    minlength: 4,
                },
                expiry_date: {
                    required: true,
                },
                expiry_time: {
                    required: true,
                },
                material: {
                    required: true,
                    accept: "image/*,video/*",
                    filesize: 30,
                },
            },
            messages: {
                material: {
                    accept: 'Only Image & Video file formats are accepted',
                }
            },
        });
    });
</script>
@endpush