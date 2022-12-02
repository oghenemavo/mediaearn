@extends('layouts.sections')

@section('main')
    <div class="sign section--bg" data-bg="{{ asset('app/img/section/section.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="sign__content">

                        <!-- content starts -->
                        @yield('content')
                        <!-- content ends -->

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection