@extends('layouts.admin.app')

@section('content')
<!-- main content -->
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Admin Settings</h3>
            </div><!-- .nk-block-head-content -->
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="card card-bordered">
            <div class="card-aside-wrap">
                <div class="card-content">
                    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#password_tab"><em class="icon ni ni-lock-alt"></em><span>Password</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#email_tab"><em class="icon ni ni-user"></em><span>Account</span></a>
                        </li>
                        @can('manage_site')
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#settings_tab"><em class="icon ni ni-setting"></em><span>Site Settings</span></a>
                            </li>
                        @endcan
                    </ul><!-- .nav-tabs -->

                    <div class="card-inner">
                        <div class="tab-content">
                            <div class="tab-pane active" id="password_tab">
                                <form id="update_password" action="{{ route('admin.update.password') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="current_password">Current Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg  @error('current_password') is-invalid @enderror"
                                            id="current_password" name="current_password" autofocus>
                                            
                                            @error('current_password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password">New Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg  @error('password') is-invalid @enderror"
                                            id="password" name="password">
                                            
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="password_confirmation">Confirm Password</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="password" class="form-control form-control-lg  @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" name="password_confirmation">
                                            
                                            @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-lg btn-primary"><em class="icon ni ni-lock-alt"></em> Update Password</button>
                                </form>
                            </div>

                            <div class="tab-pane" id="email_tab">
                                <form id="update_email" action="{{ route('admin.update.email') }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label class="form-label" for="email">Email</label>
                                        </div>
                                        <div class="form-control-wrap">
                                            <input type="email" class="form-control form-control-lg  @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ auth()->guard('admin')->user()->email }}" autofocus>
                                            
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-lg btn-primary"><em class="icon ni ni-user"></em> Update Email</button>
                                </form>
                            </div>

                            @can('manage_site')
                                <div class="tab-pane" id="settings_tab">
                                    <form id="app_settings">
                                        @foreach($app_settings as $settings)
                                            @if($settings->meta->get('type') == 'number') 
                                                <div class="form-group">
                                                    <div class="form-label-group">
                                                        <label class="form-label" for="{{ $settings->slug }}">{{ ucwords($settings->name) }}</label>
                                                    </div>
                                                    <div class="form-control-wrap">
                                                        <input 
                                                        type="number" min="{{ $settings->meta->get('min') }}" step="{{ $settings->meta->get('step') }}"
                                                        class="form-control form-control-lg"
                                                        id="{{ $settings->slug }}" name="settings_value" value="{{trim($settings->value)}}" 
                                                        data-id="{{ $settings->id }}" require
                                                        >
                                                        
                                                        @error('{{ $settings->slug }}')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-note">{{ $settings->description }}</div>
                                                </div>
                                            @elseif($settings->meta->get('type') == 'select') 
                                                <div class="form-group">
                                                    <label class="form-label">{{ ucwords($settings->name) }}</label>
                                                    <div class="form-control-wrap">
                                                        <select data-ui="lg" name="settings_value" class="form-select" data-id="{{ $settings->id }}" require>
                                                            @foreach($settings->meta->get('options') as $key => $data)
                                                                <option value="{{ $key }}" @if($key == $settings->value) selected @endif>
                                                                    {{ $data }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-note">{{ $settings->description }}</div>
                                                </div>
                                            @endif

                                        @endforeach

                                        <!-- <button type="submit" class="btn btn-lg btn-primary"><em class="icon ni ni-setting"></em> Update Site Settings</button> -->
                                    </form>
                                </div>
                            @endcan
                        </div>
                    </div>

                </div><!-- .card-content -->
            </div><!-- .card-aside-wrap -->
        </div><!-- .card -->
    </div><!-- .nk-block -->
<!-- main content -->
@endsection


@push('scripts')
    <script src="{{ asset('assets/js/additional-methods.min.js') }}"></script>

    <script>
        $(function() {
            $('#app_settings').change(function (e) {
                e.preventDefault();

                const formField = e.target;
                const id = formField.getAttribute('data-id');
                const selectedValue = formField.value

                if (selectedValue == '') {
                    Swal.fire('Error!', 'Value is required', 'error');
                } else {
                    let url = `{{ route('admin.edit.app.settings', ':id') }}`;
                    url = url.replace(':id', id);
    
                    $.ajax({
                        url,
                        type: 'PUT',  // change your route to use POST too
                        datatype: 'JSON',
                        context: this,
                        data: {
                            '_token': `{{ csrf_token() }}`, 
                            settings_value: selectedValue
                        },
                        success: function(response) {
                            if (response.hasOwnProperty('success')) {
                                NioApp.Toast('App Settings updated.', 'success', {position: 'top-right'});
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

            $('#update_password').validate({
                rules: {
                    current_password: {
                        required: true,
                        minlength: 5,
                    },
                    password: {
                        required: true,
                        minlength: 5
                    },
                    password_confirmation: {
                        equalTo: "#password"
                    }
                },
            });

            $('#update_email').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                },
            });
        });
    </script>
@endpush