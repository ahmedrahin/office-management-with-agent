<!doctype html>
<html lang="en">

<head>
	
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesdesign" name="author" />
    <title>@yield('page-title') | {{ \App\Models\Settings::site_title() }} </title>

    <!--favicon-->
    @php
        $favIcon = \App\Models\Settings::shop_fav();
    @endphp
    @if(!is_null($favIcon))
        <link rel="icon" href="{{ asset($favIcon->fav_icon) }}" type="image/png" />
    @endif

    <!-- jquery.vectormap css -->
    <link href="{{ asset('backend/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('backend/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('backend/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('backend/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/custom.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <link href="{{ asset('agent/css/agent.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Sweet Alert-->
    <link href="{{asset('backend/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    @yield('page-css')

</head>
@php
    $logo = \App\Models\Settings::shop_logo();
@endphp
<body data-topbar="colored" data-layout="horizontal">
	<!--wrapper-->
	<div id="layout-wrapper">
       
        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">
                        <a href="index.html" class="logo logo-dark">
                            <span class="logo-sm">
                                <img src="{{ asset($logo->logo) }}" alt="logo-sm" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset($logo->logo) }}" alt="logo-dark" height="20">
                            </span>
                        </a>

                        <a href="index.html" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset($logo->logo) }}" alt="logo-sm-light" height="22">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset($logo->logo) }}" alt="logo-light" height="20">
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <i class="ri-menu-2-line align-middle"></i>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="ri-search-line"></span>
                        </div>
                    </form>

                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="ri-search-line"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">
                
                            <form class="p-3">
                                <div class="mb-3 m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ...">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit"><i class="ri-search-line"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown d-none d-lg-inline-block ms-1">
                        <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown"
                              data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-notification-3-line"></i>
                            <span class="noti-dot"></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#!" class="small"> View All</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                <i class="ri-shopping-cart-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">Your order is placed</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <img src="assets/images/users/avatar-3.jpg"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="mb-1">James Lemire</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">It will seem like simplified English.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="avatar-xs me-3">
                                            <span class="avatar-title bg-success rounded-circle font-size-16">
                                                <i class="ri-checkbox-circle-line"></i>
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <h6 class="mb-1">Your item is shipped</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">If several languages coalesce the grammar</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 3 min ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <a href="" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <img src="assets/images/users/avatar-4.jpg"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="mb-1">Salena Layfield</h6>
                                            <div class="font-size-12 text-muted">
                                                <p class="mb-1">As a skeptical Cambridge friend of mine occidental.</p>
                                                <p class="mb-0"><i class="mdi mdi-clock-outline"></i> 1 hours ago</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top">
                                <div class="d-grid">
                                    <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                        <i class="mdi mdi-arrow-right-circle me-1"></i> View More..
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="dropdown d-inline-block user-dropdown">
                        <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1">Julia</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="#"><i class="ri-user-line align-middle me-1"></i> Profile</a>
                            <a class="dropdown-item" href="#"><i class="ri-wallet-2-line align-middle me-1"></i> My Wallet</a>
                            <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end mt-1">11</span><i class="ri-settings-2-line align-middle me-1"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="ri-lock-unlock-line align-middle me-1"></i> Lock screen</a>
                            <div class="dropdown-divider"></div>
                            <a class="text-danger dropdown-item" href="{{ route('agent.logout') }}"
                            style="font-weight: 600;font-size:16px;"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="ri-shut-down-line align-middle me-1 text-danger"></i> Logout
                            </a>

                            <form id="logout-form" action="{{ route('agent.logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>
		
        <div class="topnav">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">

                            <li class="nav-item">
                                <a class="nav-link" href="index.html">
                                    <i class="ri-dashboard-line me-2"></i> Dashboard
                                </a>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-uielement" role="button"
                                >
                                    <i class="ri-pencil-ruler-2-line me-2"></i>UI Elements <div class="arrow-down"></div>
                                </a>

                                <div class="dropdown-menu mega-dropdown-menu px-2 dropdown-mega-menu-xl"
                                    aria-labelledby="topnav-uielement">
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-alerts.html" class="dropdown-item">Alerts</a>
                                                <a href="ui-buttons.html" class="dropdown-item">Buttons</a>
                                                <a href="ui-cards.html" class="dropdown-item">Cards</a>
                                                <a href="ui-carousel.html" class="dropdown-item">Carousel</a>
                                                <a href="ui-dropdowns.html" class="dropdown-item">Dropdowns</a>
                                                <a href="ui-grid.html" class="dropdown-item">Grid</a>
                                                <a href="ui-images.html" class="dropdown-item">Images</a>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-lightbox.html" class="dropdown-item">Lightbox</a>
                                                <a href="ui-modals.html" class="dropdown-item">Modals</a>
                                                <a href="ui-offcanvas.html" class="dropdown-item">Offcanvas</a>
                                                <a href="ui-rangeslider.html" class="dropdown-item">Range Slider</a>
                                                <a href="ui-roundslider.html" class="dropdown-item">Round slider</a>
                                                <a href="ui-session-timeout.html" class="dropdown-item">Session Timeout</a>
                                                <a href="ui-progressbars.html" class="dropdown-item">Progress Bars</a>                                           
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div>
                                                <a href="ui-sweet-alert.html" class="dropdown-item">Sweetalert 2</a>
                                                <a href="ui-tabs-accordions.html" class="dropdown-item">Tabs & Accordions</a>
                                                <a href="ui-typography.html" class="dropdown-item">Typography</a>
                                                <a href="ui-video.html" class="dropdown-item">Video</a>
                                                <a href="ui-general.html" class="dropdown-item">General</a>
                                                <a href="ui-rating.html" class="dropdown-item">Rating</a>
                                                <a href="ui-notifications.html" class="dropdown-item">Notifications</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </li>
                
               

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-apps" role="button"
                                >
                                    <i class="ri-apps-2-line me-2"></i>Apps <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-apps">

                                    <a href="calendar.html" class="dropdown-item">Calendar</a>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-email"
                                            role="button">
                                            Email <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-email">
                                            <a href="email-inbox.html" class="dropdown-item">Inbox</a>
                                            <a href="email-read.html" class="dropdown-item">Read Email</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-components" role="button"
                                >
                                    <i class="ri-stack-line me-2"></i>Components <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-components">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            Advance UI <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="advance-rangeslider.html" class="dropdown-item">Range Slider</a>
                                            <a href="advance-roundslider.html" class="dropdown-item">Round Slider</a>
                                            <a href="advance-session-timeout.html" class="dropdown-item">Session Timeout</a>
                                            <a href="advance-sweet-alert.html" class="dropdown-item">Sweetalert 2</a>
                                            <a href="advance-rating.html" class="dropdown-item">Rating</a>
                                            <a href="advance-notification.html" class="dropdown-item">Notification</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-form"
                                            role="button">
                                            Forms <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-form">
                                            <a href="form-elements.html" class="dropdown-item">Elements</a>
                                            <a href="form-validation.html" class="dropdown-item">Validation</a>
                                            <a href="form-advanced.html" class="dropdown-item">Advanced Plugins</a>
                                            <a href="form-editors.html" class="dropdown-item">Editors</a>
                                            <a href="form-uploads.html" class="dropdown-item">File Upload</a>
                                            <a href="form-xeditable.html" class="dropdown-item">Xeditable</a>
                                            <a href="form-wizard.html" class="dropdown-item">Wizard</a>
                                            <a href="form-mask.html" class="dropdown-item">Mask</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-table"
                                            role="button">
                                            Tables <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-table">
                                            <a href="tables-basic.html" class="dropdown-item">Basic Tables</a>
                                            <a href="tables-datatable.html" class="dropdown-item">Data Tables</a>
                                            <a href="tables-responsive.html" class="dropdown-item">Responsive Table</a>
                                            <a href="tables-editable.html" class="dropdown-item">Editable Table</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-charts"
                                            role="button">
                                            Charts <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-charts">
                                            <a href="charts-apex.html" class="dropdown-item">Apex charts</a>
                                            <a href="charts-chartjs.html" class="dropdown-item">Chartjs</a>
                                            <a href="charts-flot.html" class="dropdown-item">Flot Chart</a>
                                            <a href="charts-knob.html" class="dropdown-item">Jquery Knob Chart</a>
                                            <a href="charts-sparkline.html" class="dropdown-item">Sparkline Chart</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-icons"
                                            role="button">
                                            Icons <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-icons">
                                            <a href="icons-remix.html" class="dropdown-item">Remix Icons</a>
                                            <a href="icons-materialdesign.html" class="dropdown-item">Material Design</a>
                                            <a href="icons-dripicons.html" class="dropdown-item">Dripicons</a>
                                            <a href="icons-fontawesome.html" class="dropdown-item">Font awesome 5</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-map"
                                            role="button">
                                            Maps <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-map">
                                            <a href="maps-google.html" class="dropdown-item">Google Maps</a>
                                            <a href="maps-vector.html" class="dropdown-item">Vector Maps</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-more" role="button"
                                >
                                    <i class="ri-file-copy-2-line me-2"></i>Pages <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-more">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-auth"
                                            role="button">
                                            Authentication <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-auth">
                                            <a href="auth-login.html" class="dropdown-item">Login</a>
                                            <a href="auth-register.html" class="dropdown-item">Register</a>
                                            <a href="auth-recoverpw.html" class="dropdown-item">Recover Password</a>
                                            <a href="auth-lock-screen.html" class="dropdown-item">Lock Screen</a>
                                        </div>
                                    </div>
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-utility"
                                            role="button">
                                            Utility <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-utility">
                                            <a href="pages-starter.html" class="dropdown-item">Starter Page</a>
                                            <a href="pages-timeline.html" class="dropdown-item">Timeline</a>
                                            <a href="pages-directory.html" class="dropdown-item">Directory</a>
                                            <a href="pages-invoice.html" class="dropdown-item">Invoice</a>
                                            <a href="pages-404.html" class="dropdown-item">Error 404</a>
                                            <a href="pages-500.html" class="dropdown-item">Error 500</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-layout" role="button">
                                    <i class="ri-layout-3-line me-2"></i><span key="t-layouts">Layouts</span> <div class="arrow-down"></div>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="topnav-layout">
                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-verti"
                                            role="button">
                                            <span key="t-vertical">Vertical</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layout-verti">
                                            <a href="layouts-dark-sidebar.html" class="dropdown-item" key="t-dark-sidebar">Dark Sidebar</a>
                                            <a href="layouts-compact-sidebar.html" class="dropdown-item" key="t-compact-sidebar">Compact Sidebar</a>
                                            <a href="layouts-icon-sidebar.html" class="dropdown-item" key="t-icon-sidebar">Icon Sidebar</a>
                                            <a href="layouts-boxed.html" class="dropdown-item" key="t-boxed-width">Boxed Width</a>
                                            <a href="layouts-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>
                                            <a href="layouts-colored-sidebar.html" class="dropdown-item" key="t-colored-sidebar">Colored Sidebar</a>
                                        </div>
                                    </div>

                                    <div class="dropdown">
                                        <a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori"
                                            role="button">
                                            <span key="t-horizontal">Horizontal</span> <div class="arrow-down"></div>
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
                                            <a href="layouts-horizontal.html" class="dropdown-item" key="t-horizontal">Horizontal</a>
                                            <a href="layouts-hori-topbar-light.html" class="dropdown-item" key="t-topbar-light">Topbar light</a>
                                            <a href="layouts-hori-boxed-width.html" class="dropdown-item" key="t-boxed-width">Boxed width</a>
                                            <a href="layouts-hori-preloader.html" class="dropdown-item" key="t-preloader">Preloader</a>
                                            <a href="layouts-hori-colored-header.html" class="dropdown-item" key="t-colored-topbar">Colored Header</a>
                                        </div>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <div class="main-content">
           @yield('body-content')

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <script>document.write(new Date().getFullYear())</script> © Upcube.
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-end d-none d-sm-block">
                                Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesdesign
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
	    </div>
	</div>
     <!-- END layout-wrapper --> 
	<!--end wrapper-->
    
	<!-- Script File -->
    <script src="{{ asset('backend/libs/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('backend/libs/simplebar/simplebar.min.js') }}"></script>
    <script src="{{ asset('backend/libs/node-waves/waves.min.js') }}"></script>

    <!-- jquery.vectormap map -->
    <script src="{{ asset('backend/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('backend/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js') }}"></script>

    <script src="{{ asset('backend/js/pages/dashboard.init.js') }}"></script>
    <!-- App js -->
    <script src="{{ asset('backend/js/app.js') }}"></script>
    <!-- Sweet alert init js-->
    <script src="{{asset('backend/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{asset('backend/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    @yield('page-script')
    <script>
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Access Denied!',
                text: '{{ session('error') }}',
            });
        @endif
    </script>
    
</body>
</html>