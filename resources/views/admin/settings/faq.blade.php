@extends('layouts.admin.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/editors/summernote.css?ver=2.8.0') }}">
@endpush

@section('content')

<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Manage FAQ</h4>
                    <div class="nk-block-des">
                        <p>view and manage faq.</p>
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
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">FAQ Title</span></th>
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Description</span></th>
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
                <h5 class="title">Add a FAQ</h5>
                
                <form id="create_video" action="{{ route('admin.create.faq') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="title">FAQ Title</label>
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
                            <label class="form-label" for="description">FAQ Description</label>
                        </div>
                        <div class="form-control-wrap">
                            <textarea class="form-control form-control-lg summernote-minimal @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                           
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
                                    <button type="submit" class="btn btn-lg btn-primary">Create FAQ</button>
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
    <script src="{{ asset('assets/js/libs/editors/summernote.js?ver=2.8.0') }}"></script>
    <script src="{{ asset('assets/js/editors.js?ver=2.8.0') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <script>
        $(function() {
            NioApp.DataTable($('#video_table'), {
                ajax: {
                    url: `{{ route('get.faqs') }}`,
                    dataSrc: 'faqs'
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
                    { 
                        data : 'description', className : 'nk-tb-col tb-col-md',
                        render      : function (data) {
                            return data.substring(0, 50) + '...';
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
                        targets   : 3,
                        className : 'nk-tb-col nk-tb-col-tools',
                        data      : null,
                        render    : function (data, type, full, meta) {
                            let showUrl = `{{ route('admin.show.faq', ':id') }}`;
                            showUrl = showUrl.replace(':id', data.id);

                            return `
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#" data-toggle="modal" data-target="#view_video_${data.id}"><em class="icon ni ni-eye"></em><span>View FAQ</span></a></li>
                                                    <li><a href="${showUrl}"><em class="icon ni ni-edit"></em><span>Edit FAQ</span></a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="#" class="text-danger delete-faq"><em class="icon ni ni-trash"></em><span>Delete FAQ</span></a></li>
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
                                                <h5 class="modal-title">FAQ</h5>
                                                
                                                <dl class="row pt-3">
                                                    <dt class="col-sm-3">Title</dt>
                                                    <dd class="col-sm-9">${data.title}</dd>

                                                    <dt class="col-sm-3 text-truncate">Plan Description</dt>
                                                    <dd class="col-sm-9">${data.description}</dd>
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

            $('#video_table tbody').on('click', 'a.delete-faq', function (e) { // activate user
                e.preventDefault();
    
                const dt = $.fn.DataTable.Api( $('#video_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data
                
                let deleteUrl = `{{ route('admin.delete.faq', ':id') }}`;
                deleteUrl = deleteUrl.replace(':id', data.id);
    
                Swal.fire({
                    title: 'Are you sure?',
                    text: "FAQ would be deleted!",
                    icon: 'error',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete FAQ!'
                }).then(function (result) {
                    if (result.value) {
                        $.ajax({
                            type: 'DELETE',
                            url: deleteUrl,
                            data: {
                                "_token": `{{ csrf_token() }}`
                            },
                            success: function(response) {
                                if (response.hasOwnProperty('success')) {
                                    dt.ajax.reload();
                                    NioApp.Toast('FAQ has been deleted.', 'success', {position: 'top-right'});
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
                }
            });
        });
    </script>
@endpush