@extends('layouts.admin.app')

@section('content')

<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Manage Categories</h4>
                    <div class="nk-block-des">
                        <p>Add and manage media categories.</p>
                    </div>
                </div>
                <div class="nk-block-head-content">
                    <ul class="nk-block-tools gx-3">
                        <li><a href="#" class="btn btn-icon btn-primary" data-toggle="modal" data-target="#create_category_modal"><em class="icon ni ni-plus"></em></a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <table id="category_table" class="nk-tb-list nk-tb-ulist" data-auto-responsive="false">
                    <thead>
                        <tr class="nk-tb-item nk-tb-head">
                            <th class="nk-tb-col tb-col-md"><span class="sub-text">Category</span></th>
                            <th class="nk-tb-col tb-col-lg"><span class="sub-text">Slug</span></th>
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

<!-- @Category Create Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="create_category_modal">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-lg">
                <h5 class="title">Add a Category</h5>
                
                <form id="create_category" action="{{ route('admin.media.create.category') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="category">Category</label>
                        </div>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control form-control-lg  @error('category') is-invalid @enderror"
                            id="category" name="category" value="{{ old('category') }}" autofocus>
                            
                            @error('category')
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
                                    <button type="submit" class="btn btn-lg btn-primary">Create Category</button>
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
</div><!--Category Create .modal -->
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>

    <script>
        $(function() {
            NioApp.DataTable($('#category_table'), {
                ajax: {
                    url: `{{ route('get.categories') }}`,
                    dataSrc: 'categories'
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
                        data        : 'category', className: 'nk-tb-col tb-col-md',
                        render      : function(data) {
                            return `<span>${data}</span>`;
                        }
                    },
                    { 
                        data        : 'slug', className   : 'nk-tb-col tb-col-lg',
                        render      : function(data) {
                            return `<span>${data}</span>`;
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
                            return `
                                <ul class="nk-tb-actions gx-1">
                                    <li>
                                        <div class="drodown">
                                            <a href="#" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <ul class="link-list-opt no-bdr">
                                                    <li><a href="#" class="edit-category" data-toggle="modal" data-target="#edit_category_${data.id}"><em class="icon ni ni-edit"></em><span>Edit Category</span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
    
                                <!-- @Edit category Modal-->
                                <div class="modal fade" tabindex="-1" role="dialog" id="edit_category_${data.id}">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
                                            <div class="modal-body modal-body-lg">
                                            <form action="{{ route('admin.media.edit.category') }}/${data.id}" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label class="form-label" for="category">Category</label>
                                                    </div>
                                                    <div class="form-control-wrap">
                                                        <input type="text" class="form-control form-control-lg  @error('category') is-invalid @enderror"
                                                        id="category" name="category" value="${data.category}" autofocus>
                                                        
                                                        @error('category')
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
                                                                <button type="submit" class="btn btn-lg btn-primary">Edit Category</button>
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
                                <!--View User .modal -->
                            `;
                        }
                    }
                ],
            });

            $('#category_table tbody').on('click', 'a.edit-category', function (e) { // activate user
                e.preventDefault();
    
                const dt = $.fn.DataTable.Api( $('#category_table') );
                let dtr = dt.row( $(this).parents('tr') ); // table row
                let data = dtr.data(); // row data

                const edit_category_form = $(this).offsetParent().offsetParent().next().find('form');

                const options = {
                    type: 'PUT',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: $(this).prop('action'),
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.hasOwnProperty('success')) {
                            dt.ajax.reload();
                            $(`#edit_category_${data.id}`).modal('hide');
                            NioApp.Toast(
                                `<h5>Update Successfully</h5>
                                <p>Category has been successfully updated.</p>`, 
                                'success',
                                {position: 'top-right'}
                            );
                        }
                        edit_category_form.find('button').text('Edit Category').prop('disabled', false);
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                        console.log(XMLHttpRequest.status)
                        console.log(XMLHttpRequest.statusText)
                        console.log(errorThrown)
                
                        // $(this).find('button').text('Edit Category').prop('disabled', false);

                        // validation response
                        let errors = XMLHttpRequest.responseJSON.errors;
                        if (errors.hasOwnProperty('name')) {
                            $('div[data-error="name"]').text(errors.name[0])
                        } 
                
                        // display toast alert
                        toastr.clear();
                        NioApp.Toast('Unable to process request now.', 'error', {position: 'top-right'});
                    }
                };
                
                edit_category_form.validate({
                    rules: {
                        category: {
                            required: true,
                            minlength: 3,
                            remote: {
                                url: `{{-- route('ajax.validate.media.category') --}}`,
                                data: {
                                    ignore_id: function() {
                                        return data.id;
                                    }
                                }
                            }
                        },
                    },
                    messages: {
                        category: {
                            remote: 'Category already exists'
                        }
                    },
                    submitHandler: function(form) {
                        $(form).find('button').prop('disabled', true);
                        $(form).ajaxSubmit(options);
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

            $('#create_category').validate({
                rules: {
                    category: {
                        required: true,
                        minlength: 3,
                        remote: `{{ route('ajax.validate.media.category') }}`
                    },
                },
                messages: {
                    category: {
                        remote: 'Category already exists'
                    }
                },
            });
        });
    </script>
@endpush