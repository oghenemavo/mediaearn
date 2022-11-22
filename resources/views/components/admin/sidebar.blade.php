<!-- sidebar @s -->
<div class="nk-sidebar nk-sidebar-fixed " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('images/earners-logo.png') }}" srcset="{{ asset('images/earners-logo.png 2x') }}" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('images/earners-logo.png') }}" srcset="{{ asset('images/earners-logo.png 2x') }}" alt="logo-dark">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-body" data-simplebar>
            <div class="nk-sidebar-content">
                <div class="nk-sidebar-menu">
                    <ul class="nk-menu">
                        <li class="nk-menu-heading">
                            <h6 class="overline-title text-primary-alt">Dashboards</h6>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item">
                            <a href="{{ route('admin.dashboard') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-live"></em></span>
                                <span class="nk-menu-text">Dashboard</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-play-circle"></em></span>
                                <span class="nk-menu-text">Media Management</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.media.categories') }}" class="nk-menu-link"><span class="nk-menu-text">Categories</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.media.videos') }}" class="nk-menu-link"><span class="nk-menu-text">Videos</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.media.promotions') }}" class="nk-menu-link"><span class="nk-menu-text">Promotions</span></a>
                                </li>
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item">
                            <a href="{{ route('admin.users') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-user-alt"></em></span>
                                <span class="nk-menu-text">Users</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item has-sub">
                            <a href="#" class="nk-menu-link nk-menu-toggle">
                                <span class="nk-menu-icon"><em class="icon ni ni-file-text"></em></span>
                                <span class="nk-menu-text">Reports</span>
                            </a>
                            <ul class="nk-menu-sub">
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.report.transactions') }}" class="nk-menu-link"><span class="nk-menu-text">Transactions</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.report.payouts') }}" class="nk-menu-link"><span class="nk-menu-text">Payouts</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.report.referrals') }}" class="nk-menu-link"><span class="nk-menu-text">Referrals</span></a>
                                </li>
                                <li class="nk-menu-item">
                                    <a href="{{ route('admin.report.video-logs') }}" class="nk-menu-link"><span class="nk-menu-text">Video Logs</span></a>
                                </li>
                            </ul><!-- .nk-menu-sub -->
                        </li><!-- .nk-menu-item -->
                        <li class="nk-menu-item">
                            <a href="{{ route('admin.settings') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><em class="icon ni ni-lock-alt"></em></span>
                                <span class="nk-menu-text">Settings</span>
                            </a>
                        </li><!-- .nk-menu-item -->
                        
                        
                    </ul><!-- .nk-menu -->
                </div><!-- .nk-sidebar-menu -->
                <div class="nk-sidebar-footer">
                    <ul class="nk-menu nk-menu-footer">
                    </ul><!-- .nk-footer-menu -->
                </div><!-- .nk-sidebar-footer -->
            </div><!-- .nk-sidebar-content -->
        </div><!-- .nk-sidebar-body -->
    </div><!-- .nk-sidebar-element -->
</div>
<!-- sidebar @e -->