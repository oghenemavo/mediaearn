@extends('layouts.admin.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/editors/summernote.css') }}">
@endpush

@section('content')

<div class="nk-block-head nk-block-head-lg wide-sm">
    <div class="nk-block-head-content">
        <h4 class="nk-block-title fw-normal">Edit FAQ info & Details</h4>
        <div class="nk-block-des">
            <p class="lead">Customize FAQ content.</p>
        </div>
    </div>
</div>

<div class="nk-block nk-block-lg">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">FAQ Details Setup</h5>
            </div>

            <form id="edit_video" action="{{ route('admin.edit.faq', $faq->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="title">Title</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg  @error('title') is-invalid @enderror"
                        id="title" name="title" value="{{ $faq->title }}">
                        
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
                        <textarea class="form-control summernote-minimal form-control-lg  @error('description') is-invalid @enderror" id="description" name="description" rows="3">{!! $faq->description !!}</textarea>
                        
                        @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-lg btn-primary">Edit FAQ</button>
            </form>

        </div>
    </div><!-- card -->
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/libs/editors/summernote.js') }}"></script>
    <script src="{{ asset('assets/js/editors.js') }}"></script>
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
                    title: {
                        required: true,
                        minlength: 4,
                    },
                    description: {
                        required: true,
                        minlength: 10,
                    },
                }
            });

        });
    </script>
@endpush