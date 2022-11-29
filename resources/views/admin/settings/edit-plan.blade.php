@extends('layouts.admin.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/css/editors/tinymce.css?ver=2.8.0') }}">
@endpush

@section('content')

<div class="nk-block-head nk-block-head-lg wide-sm">
    <div class="nk-block-head-content">
        <h4 class="nk-block-title fw-normal">Edit Plan info & Details</h4>
        <div class="nk-block-des">
            <p class="lead">Customize plan content.</p>
        </div>
    </div>
</div>

<div class="nk-block nk-block-lg">
    <div class="card card-bordered">
        <div class="card-inner">
            <div class="card-head">
                <h5 class="card-title">Plan Details Setup</h5>
            </div>

            <form id="edit_video" action="{{ route('admin.edit.plans', $plan->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="title">Title</label>
                    </div>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control form-control-lg  @error('title') is-invalid @enderror"
                        id="title" name="title" value="{{ $plan->title }}">
                        
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="description">Plan Description</label>
                    </div>
                    <div class="form-control-wrap">
                        <textarea class="form-control form-control-lg  @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ $plan->description }}</textarea>
                        
                        @error('description')
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
                            id="price" name="price" value="{{ $plan->price }}" min="1" step="0.01">
                        
                            @error('charges')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="custom-control custom-switch">    
                    <input type="checkbox" class="custom-control-input" id="set_discount" name="set_discount" @if ($plan->meta->get('set_discount') == true) checked @endif>    
                    <label class="custom-control-label" for="set_discount">Set Discount</label>
                </div>
                <br><br>

                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="discount">Discount</label>
                    </div>
                    <div class="form-control-wrap">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon3">&#8358;</span>
                            </div>
                            <input type="number" class="form-control form-control-lg  @error('discount') is-invalid @enderror"
                            id="discount" name="discount" value="{{ $plan->meta->get('discount') }}" @if ($plan->meta->get('set_discount')) min="1" @endif step="0.01">
                        
                            @error('charges')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-lg btn-primary">Edit Plan</button>
            </form>

        </div>
    </div><!-- card -->
</div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/js/libs/editors/tinymce.js?ver=2.8.0') }}"></script>
    <script src="{{ asset('assets/js/editors.js?ver=2.8.0') }}"></script>
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="{{ asset('assets/js/jquery.form.js') }}"></script>

    <script>
        $(function() {
            $('#set_discount').change(function(e) {
                if ($(e.target).is(':checked')) {
                    $('#discount').attr('min', '1');
                } else {
                    $('#discount').removeAttr('min');
                }
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

            $('#edit_video').validate({
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
                    discount: {
                        required: false,
                        number: true,
                    },
                }
            });

        });
    </script>
@endpush