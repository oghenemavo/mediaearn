@extends('layouts.admin.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/editors/summernote.css') }}">
@endpush

@section('content')

<div class="nk-block-head nk-block-head-lg wide-sm">
    <div class="nk-block-head-content">
        <h4 class="nk-block-title fw-normal">Edit Admin info & Details</h4>
        <div class="nk-block-des">
            <p class="lead">Manage Admin.</p>
        </div>
    </div>
</div>

<div class="nk-block nk-block-lg">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">Admin Info</h5>
            </div>

            <form id="edit_video" action="{{ route('admin.edit.admin', $admin->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="name">Full Name</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg  @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ $admin->name }}">
                        
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
                        <input type="text" class="form-control form-control-lg  @error('email') is-invalid @enderror"
                        id="email" name="email" value="{{ $admin->email }}">
                        
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
                                <option value="{{ $data->id }}" @selected($admin->roles()->first()->id == $data->id)>{{ ucfirst($data->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div data-error="role" class="error"></div>
                </div>

                <button type="submit" class="btn btn-lg btn-primary">Edit Admin</button>
            </form>

        </div>
    </div><!-- card -->
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>

    <script>
        $(function() {
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

            $('#edit_video').validate({
                rules: {
                    name: {
                        required: true,
                        minlength: 4,
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    role: {
                        required: true,
                    },
                }
            });

        });
    </script>
@endpush