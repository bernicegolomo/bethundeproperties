<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

<meta charset="utf-8" />
    <title>
        @isset($title)
            {{ $title }} | 
        @endisset
        {{ config('app.name') }}
    </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Bethunde property management" name="description" />
    <meta content="Bethunde property management" name="Bethunde" />
    <!-- App favicon -->
    
    <link href="{{asset('assets/images/logo/favicon.png')}}" rel="icon" type="image/x-icon">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="{{asset('assets/libs/swiper/swiper-bundle.min.css')}}" rel="stylesheet" />

    <!-- Layout config Js -->
    <script src="{{asset('assets/js/layout.js')}}"></script>
    <!-- Bootstrap Css -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    
    <!-- App Css-->
    <link href="{{asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">

        <header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="{{url('user/dashboard')}}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{asset('assets/images/logo/logo.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('assets/images/logo/logo.png')}}" alt="" height="17">
                        </span>
                    </a>

                    <a href="{{url('user/dashboard')}}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{asset('assets/images/logo/logo.png')}}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{asset('assets/images/logo/logo.png')}}" alt="" height="17">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

                <!-- App Search-->
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Student search..." autocomplete="off"
                            id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                            id="search-close-options"></span>
                    </div>                    
                </form>
            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown d-md-none topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="bx bx-search fs-22"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                        aria-labelledby="page-header-search-dropdown">
                        <form class="p-3">
                            <div class="form-group m-0">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search student ..."
                                        aria-label="Recipient's username">
                                    <button class="btn btn-primary" type="submit"><i
                                            class="mdi mdi-magnify"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>


                
                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bx bx-fullscreen fs-22'></i>
                    </button>
                </div>

                

                
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <!--<img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg" alt="Header Avatar">-->
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{Auth::user()->name}}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                    @if(Auth::user()->is_admin == 1)
                                        Super Administrator
                                    @else
                                        Lawyer | Agent
                                    @endif
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <a class="dropdown-item" href="{{url('user/profile')}}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>
                        
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{url('logout')}}"><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
        <!-- ========== App Menu ========== -->
        <div class="app-menu navbar-menu">
            <!-- LOGO -->
            <div class="navbar-brand-box" style="background:#fff;">
                <!-- Dark Logo-->
                <a href="{{url('user/dashboard')}}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo/logo.png')}}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo/logo.png')}}" alt="" height="50">
                    </span>
                </a>
                <!-- Light Logo-->
                <a href="{{url('user/dashboard')}}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="{{asset('assets/images/logo/logo.png')}}" alt="" height="50">
                    </span>
                    <span class="logo-lg">
                        <img src="{{asset('assets/images/logo/logo.png')}}" alt="" height="50">
                    </span>
                </a>
                <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>

            <div id="scrollbar">
                <div class="container-fluid">

                    <div id="two-column-menu">
                    </div>
                    <ul class="navbar-nav" id="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('user/dashboard')}}">
                                <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                            </a>
                        </li> <!-- end Dashboard Menu -->
                        @if(Auth::user()->is_admin == 1)
                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('user/manageadmins')}}">
                                <i class="ri-team-fill"></i> <span data-key="t-users">Manage Users</span>
                            </a>
                        </li> <!-- end Admin Menu -->

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('user/manageproperty')}}">
                                <i class="ri-home-3-line"></i> <span data-key="t-property">Manage Property</span>
                            </a>
                        </li> <!-- end Property Menu -->

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('user/managetenants')}}">
                                <i class="ri-group-2-line"></i> <span data-key="t-tenant">Manage Tenants</span>
                            </a>
                        </li> <!-- end Tenants Menu -->

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="{{url('user/rents')}}">
                                <i class="ri-money-dollar-circle-line"></i> <span data-key="t-tenant">Manage Rents</span>
                            </a>
                        </li> <!-- end Tenants Menu -->
                        @endif

                        <li class="nav-item">
                            <a class="nav-link menu-link" href="#sidebarReport" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarUsers">
                                <i class=" ri-bar-chart-box-line"></i> <span data-key="t-report">Reports</span>
                            </a>
                            <div class="collapse menu-dropdown" id="sidebarReport">
                                <ul class="nav nav-sm flex-column">
                                    @if(Auth::user()->is_admin == 1)
                                        <li class="nav-item">
                                            <a href="{{url('user/propertyreport')}}" class="nav-link" data-key="t-rproperty">Property Report</a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a href="{{url('user/tenantreport')}}" class="nav-link" data-key="t-rtenant"> Tenant Report </a>
                                    </li>

                                    @if(Auth::user()->is_admin == 1)
                                        <li class="nav-item">
                                            <a href="{{url('user/financialreport')}}" class="nav-link" data-key="t-freport">Financial Report</a>
                                        </li> 
                                    @endif                                   
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>

            <div class="sidebar-background"></div>
        </div>
        <!-- Left Sidebar End -->
        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            @yield('content')

            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <script>document.write(new Date().getFullYear())</script> Powered by eLED Global Services Limited
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <!-- end main content-->

    </div>
    <!-- END layout-wrapper -->



    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>


    

    <!-- JAVASCRIPT -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    
    <script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
    <script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
    <script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/pages/plugins/lord-icon-2.1.0.js')}}"></script>
    <script src="{{asset('assets/js/plugins.js')}}"></script>

    <!-- apexcharts -->
    <script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Swiper Js -->
    <script src="{{asset('assets/libs/swiper/swiper-bundle.min.js')}}"></script>

    <!-- CRM js -->
    <script src="{{asset('assets/js/pages/dashboard-crypto.init.js')}}"></script>

    <!-- form wizard init -->
    <script src="{{asset('assets/js/pages/form-wizard.init.js')}}"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{asset('assets/js/pages/select2.init.js')}}"></script>
    <!-- App js -->
    <script src="{{asset('assets/js/app.js')}}"></script>

    <!--select2 cdn-->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="{{asset('assets/js/pages/select2.init.js')}}"></script>

    <script>

    $(document).ready(function() {
    $("#select2insidemodal").select2({
        dropdownParent: $("#payModal")
    });
    });

    </script>

    <script>
        function onlyNumberKey(evt) {

            // Only ASCII character in that range allowed
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>

    <script type='text/javascript'>
        $(document).ready(function(){
            // Country change
            $('#propertyz').change(function(){

                // Property id
                var id = $(this).val();
                var url = '{{ url("getflats", ":id") }}';
                url = url.replace(':id', id);

                // Empty the dropdown
                $('#flat').find('option').not(':first').remove();

                // AJAX request
                $.ajax({
                //url: url,
                url:"{{ url('getflats') }}" + '/' + id,
                type: 'get',
                dataType: 'json',
                success: function(response){

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                        var id = response['data'][i].id;
                        var name = response['data'][i].flatno;
                        var descr = response['data'][i].description;

                        var option = "<option value='"+id+"'>"+name+ ' ' +descr+" </option>";

                        $("#flat").append(option);
                        }
                    }

                }
                });
            });
        });
    </script>

    <script type='text/javascript'>
        $(document).ready(function(){
            // flat change
            $('#flat').change(function(){

                
                var id = $(this).val();
                var pid = document.getElementById("propertyz").value
                // Empty the dropdown
                $('#rent').find('option').not(':first').remove();

                // AJAX request
                $.ajax({
                //url: url,
                url:"{{ url('getflatfees') }}" + '/' + pid + '/' + id,
                type: 'get',
                dataType: 'json',
                success: function(response){

                    var len = 0;
                    if(response['data'] != null){
                        len = response['data'].length;
                    }

                    if(len > 0){
                        // Read data and create <option >
                        for(var i=0; i<len; i++){

                        var id = response['data'][i].id;
                        var name = response['data'][i].fee;
                        //var amount = name.toLocaleString('en-US');
                        var amount = new Intl.NumberFormat('en-US').format(name);

                        var option = "<option value='"+id+"'>"+amount+" </option>";

                        $("#rent").append(option);
                        }
                    }

                }
                });
            });
        });
    </script>




@stack('scripts')
</body>

</html>