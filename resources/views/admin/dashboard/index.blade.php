@extends('layouts.admin.app')

@section('content')
<!-- main content -->
    <div class="nk-block-head nk-block-head-sm">
        <div class="nk-block-between">
            <div class="nk-block-head-content">
                <h3 class="nk-block-title page-title">Admin Dashboard</h3>
                <div class="nk-block-des text-soft">
                    <p>Welcome to Earners View Dashboard.</p>
                </div>
            </div><!-- .nk-block-head-content -->
            
        </div><!-- .nk-block-between -->
    </div><!-- .nk-block-head -->
    <div class="nk-block">
        <div class="row g-gs">
            <div class="col-sm-4 col-xxl-12">
                <div class="nk-order-ovwg-data buy">
                    <div class="amount">{{ $total_videos }} <small class="currenct currency-usd">Videos</small></div>
                    <!-- <div class="info">Last month <strong>39,485 <span class="currenct currency-usd">USD</span></strong></div> -->
                    <div class="title"><em class="icon ni ni-arrow-down-left"></em> Total Videos</div>
                </div>
            </div>
            <div class="col-sm-4 col-xxl-12">
                <div class="nk-order-ovwg-data sell">
                    <div class="amount">{{ $total_users }} <small class="currenct currency-usd">User(s)</small></div>
                    <!-- <div class="info">Last month <strong>{{ $total_users }} <span class="currenct currency-usd">USD</span></strong></div> -->
                    <div class="title"><em class="icon ni ni-arrow-up-left"></em> Total Users</div>
                </div>
            </div>
            <div class="col-sm-4 col-xxl-12">
                <div class="nk-order-ovwg-data sell">
                    <div class="amount">{{ $active_videos }} <small class="currenct currency-usd">Active</small></div>
                    <!-- <div class="info">Last month <strong>39,485 <span class="currenct currency-usd">USD</span></strong></div> -->
                    <div class="title"><em class="icon ni ni-arrow-up-left"></em> Active Videos</div>
                </div>
            </div>
        </div><!-- .row -->
    </div><!-- .nk-block -->
<!-- main content -->
@endsection