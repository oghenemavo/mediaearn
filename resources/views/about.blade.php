@extends('layouts.app')

@section('content')

    <!-- page title -->
    <section class="section section--first section--bg" data-bg="img/section/section.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section__wrap">
                        <!-- section title -->
                        <h1 class="section__title">About us</h1>
                        <!-- end section title -->

                        <!-- breadcrumb -->
                        <ul class="breadcrumb">
                            <li class="breadcrumb__item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb__item breadcrumb__item--active">About us</li>
                        </ul>
                        <!-- end breadcrumb -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end page title -->

    <!-- privacy -->
    <section class="section">
        <div class="container">
            <div class="row">
                <!-- section text -->
                <div class="col-12">
                    <p class="section__text">
                        <span class="s1">
                        Hey there! We're Earner view, and we want to help you make money while you watch videos online. 
                        Unlike other platforms that takes rigorous vetting processes, we take pride in our onboarding system and you can start earning in moments.
                        We get funding from a community of business and product owners who wants a high review on their business products.
                        We also increased earning quotients by setting up a referral system that can increase your daily earnings, when your referral watches a video, you get a cut.
                        It's really simple: just sign up, watch some videos, and start earning rewards. 
                        You can cash out your earnings via PayPal, or use them to buy gift cards for popular retailers like Amazon, Target, and Walmart.
                        We started Earner view because we wanted to give everyone a fair chance to earn some extra money. 
                        Whether you're a stay-at-home mom looking to make a little extra cash, a college student trying to offset the cost of tuition, or someone who just loves watching videos, we want to help you out. 
                        So what are you waiting for? Sign up today and start earning!
                        </span>
                    </p>

                </div>
                <!-- end section text -->

                <!-- feature -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature">
                        <span class="feature__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M19,2H5A3,3,0,0,0,2,5V15a3,3,0,0,0,3,3H7.64l-.58,1a2,2,0,0,0,0,2,2,2,0,0,0,1.75,1h6.46A2,2,0,0,0,17,21a2,2,0,0,0,0-2l-.59-1H19a3,3,0,0,0,3-3V5A3,3,0,0,0,19,2ZM8.77,20,10,18H14l1.2,2ZM20,15a1,1,0,0,1-1,1H5a1,1,0,0,1-1-1V14H20Zm0-3H4V5A1,1,0,0,1,5,4H19a1,1,0,0,1,1,1Z"/></svg>
                        </span>
                        <h3 class="feature__title">Ultra HD</h3>
                        <p class="feature__text">All media displays are in crisp quality to give the best viewing output.</p>
                    </div>
                </div>
                <!-- end feature -->


                <!-- feature -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature">
                        <span class="feature__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M21,4H18V3a1,1,0,0,0-1-1H7A1,1,0,0,0,6,3V4H3A1,1,0,0,0,2,5V8a4,4,0,0,0,4,4H7.54A6,6,0,0,0,11,13.91V16H10a3,3,0,0,0-3,3v2a1,1,0,0,0,1,1h8a1,1,0,0,0,1-1V19a3,3,0,0,0-3-3H13V13.91A6,6,0,0,0,16.46,12H18a4,4,0,0,0,4-4V5A1,1,0,0,0,21,4ZM6,10A2,2,0,0,1,4,8V6H6V8a6,6,0,0,0,.35,2Zm8,8a1,1,0,0,1,1,1v1H9V19a1,1,0,0,1,1-1ZM16,8A4,4,0,0,1,8,8V4h8Zm4,0a2,2,0,0,1-2,2h-.35A6,6,0,0,0,18,8V6h2Z"/></svg>
                        </span>
                        <h3 class="feature__title">Referrals</h3>
                        <p class="feature__text">Earn extra when your refers watches a video</p>
                    </div>
                </div>
                <!-- end feature -->

                <!-- feature -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature">
                        <span class="feature__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M18,13.18V10a6,6,0,0,0-5-5.91V3a1,1,0,0,0-2,0V4.09A6,6,0,0,0,6,10v3.18A3,3,0,0,0,4,16v2a1,1,0,0,0,1,1H8.14a4,4,0,0,0,7.72,0H19a1,1,0,0,0,1-1V16A3,3,0,0,0,18,13.18ZM8,10a4,4,0,0,1,8,0v3H8Zm4,10a2,2,0,0,1-1.72-1h3.44A2,2,0,0,1,12,20Zm6-3H6V16a1,1,0,0,1,1-1H17a1,1,0,0,1,1,1Z"/></svg>
                        </span>
                        <h3 class="feature__title">Notifications</h3>
                        <p class="feature__text">Get instant Notifications on your payments</p>
                    </div>
                </div>
                <!-- end feature -->

                <!-- feature -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="feature">
                        <span class="feature__icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M22.60107,2.062a1.00088,1.00088,0,0,0-.71289-.71289A11.25224,11.25224,0,0,0,10.46924,4.97217L9.35431,6.296l-2.6048-.62848A2.77733,2.77733,0,0,0,3.36279,7.0249L1.1626,10.9248A.99989.99989,0,0,0,1.82422,12.394l3.07275.65869a13.41952,13.41952,0,0,0-.55517,2.43409,1.00031,1.00031,0,0,0,.28466.83642l3.1001,3.1001a.99941.99941,0,0,0,.707.293c.02881,0,.05762-.00147.08692-.00391a12.16892,12.16892,0,0,0,2.49157-.49l.64368,3.00318a1.0003,1.0003,0,0,0,1.46924.66162l3.90527-2.20264a3.03526,3.03526,0,0,0,1.375-3.30371l-.6687-2.759,1.23706-1.13751A11.20387,11.20387,0,0,0,22.60107,2.062ZM3.57227,10.72314,5.12842,7.96338a.82552.82552,0,0,1,1.06982-.37549l1.71741.4162-.65.77179A13.09523,13.09523,0,0,0,5.67633,11.174Zm12.47021,8.22217L13.32666,20.477l-.4295-2.00464a11.33992,11.33992,0,0,0,2.41339-1.61987l.74353-.68366.40344,1.66462A1.041,1.041,0,0,1,16.04248,18.94531ZM17.65674,11.98l-3.68457,3.38623a9.77348,9.77348,0,0,1-5.17041,2.3042l-2.4043-2.4043a10.932,10.932,0,0,1,2.40088-5.206l1.67834-1.99268a.9635.9635,0,0,0,.07813-.09277L11.98975,6.271a9.27757,9.27757,0,0,1,8.80957-3.12012A9.21808,9.21808,0,0,1,17.65674,11.98Zm-.923-6.16376a1.5,1.5,0,1,0,1.5,1.5A1.49992,1.49992,0,0,0,16.7337,5.81622Z"/></svg>
                        </span>
                        <h3 class="feature__title">Payouts</h3>
                        <p class="feature__text">Payouts run at the end of every day</p>
                    </div>
                </div>
                <!-- end feature -->

            </div>

            
            
        </div>

        
    </section>
    <!-- end privacy -->

@endsection