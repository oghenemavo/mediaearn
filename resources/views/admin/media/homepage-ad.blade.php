@extends('layouts.admin.app')

@section('content')

<div class="components-preview wide-md mx-auto">
    <div class="nk-block nk-block-lg">
        <div class="nk-block-head">
            <div class="nk-block-between-md g-4">
                <div class="nk-block-head-content">
                    <h4 class="nk-block-title">Manage Homepage Ad</h4>
                    <div class="nk-block-des">
                        <p>Add and manage Homepage Ad materials.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-preview">
            <div class="card-inner">
                <h5 class="title">Add a Promotion Material</h5>

                <form id="create_promotion" action="{{ route('admin.media.create.home-ad') }}" method="post" enctype="multipart/form-data">
                    @csrf

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

                    <button type="submit" class="btn btn-lg btn-primary">Create Promotion</button>

                </form>
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

                <form id="create_promotion" action="{{ route('admin.media.create.home-ad') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <div class="custom-control custom-control-lg custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="homepage_ad" name="homepage_ad">    <label class="custom-control-label" for="homepage_ad">Home Page Ad</label>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-lg btn-primary">Create Promotion</button>

                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
<!--Promotion Create .modal -->
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
                    accept: "image/*",
                    filesize: 30,
                },
            },
            messages: {
                material: {
                    accept: 'Only Image file formats are accepted',
                }
            },
        });
    });
</script>
@endpush
