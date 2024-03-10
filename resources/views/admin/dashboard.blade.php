<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>{{ $setting->value ?? 'Default Site Title' }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- twitter-bootstrap-wizard css -->
        <link rel="stylesheet" href="{{ asset('Backend_Theme/assets/libs/twitter-bootstrap-wizard/prettify.css')}}">

        <!-- jquery.vectormap css -->
        <link href="{{ asset('Backend_Theme/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet') }}" type="text/css" />

        <!-- Plugins css -->
        <link href="{{ asset('Backend_Theme/assets/libs/dropzone/min/dropzone.min.css')}}" rel="stylesheet" type="text/css" />

        <!-- Font-Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- DataTables -->
        <link href="<link href="{{ asset('Backend_Theme/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="<link href="{{ asset('Backend_Theme/assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="<link href="{{ asset('Backend_Theme/assets/libs/datatables.net-select-bs4/css//select.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

        <link href="{{ asset('Backend_Theme/assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">

        <link href="{{ asset('Backend_Theme/assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">

        <link href="{{ asset('Backend_Theme/assets/libs/spectrum-colorpicker2/spectrum.min.css" rel="stylesheet')}}" type="text/css">

        <link href="{{ asset('Backend_Theme/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">

        <!-- DataTables -->
        <link href="{{ asset('Backend_Theme/assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

        <!-- Responsive datatable examples -->
        <link href="{{ asset('Backend_Theme/assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet') }}" type="text/css" />

        <!--Toastr-->
        <link rel="stylesheet" type="text/css" href="{{ asset('Backend_Theme/assets/libs/toastr/build/toastr.min.css') }}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('Backend_Theme/assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('Backend_Theme/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css"  rel="stylesheet"/>
        <!-- App Css-->
        <link href="{{ asset('Backend_Theme/assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />
    </head>

    <body data-topbar="dark">


    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner">
                    <i class="ri-loader-line spin-icon"></i>
                </div>
            </div>
        </div>

        <!-- Begin page -->
        <div id="layout-wrapper">
            @include('admin.body.header')

            <!-- ========== Left Sidebar Start ========== -->
            @include('admin.body.sidebar')
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">
                @yield('content')
                <!-- End Page-content -->
                @include('admin.body.footer')
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('Backend_Theme/assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/node-waves/waves.min.js')}}"></script>


        <script src="{{ asset('Backend_Theme/assets/libs/select2/js/select2.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/admin-resources/bootstrap-filestyle/bootstrap-filestyle.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/bootstrap-maxlength/bootstrap-maxlength.min.js')}}"></script>


        <!-- apexcharts -->
        <script src="{{ asset('Backend_Theme/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

        <!-- Plugins js -->
        <script src="{{ asset('Backend_Theme/assets/libs/dropzone/min/dropzone.min.js')}}"></script>


        <!-- jquery.vectormap map -->
        <script src="{{ asset('Backend_Theme/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>

        <!-- Required datatable js -->
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>

        <!-- Responsive examples -->
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>

        <script src="{{ asset('Backend_Theme/assets/js/pages/dashboard.init.js')}}"></script>

        <!-- App js -->
        <script src="{{ asset('Backend_Theme/assets/js/app.js')}}"></script>
          <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

        <!-- Required datatable js -->
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/jszip/jszip.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/pdfmake/build/pdfmake.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/pdfmake/build/vfs_fonts.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-select/js/dataTables.select.min.js') }}"></script>

        <!-- Responsive examples -->
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('Backend_Theme/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script>


        <!-- Datatable init js -->
        <script src="{{ asset('Backend_Theme/assets/js/pages/datatables.init.js') }}"></script>

        <!-- toastr plugin -->
        <script src="{{ asset('Backend_Theme/assets/libs/toastr/build/toastr.min.js') }}"></script>

        <!-- toastr init -->
        <script src="{{ asset('Backend_Theme/assets/js/pages/toastr.init.js') }}"></script>

        <!-- twitter-bootstrap-wizard js -->
        <script src="{{ asset('Backend_Theme/assets/libs/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js')}}"></script>

        <script src="{{ asset('Backend_Theme/assets/libs/twitter-bootstrap-wizard/prettify.js')}}"></script>

        <!-- form wizard init -->
        <script src="{{ asset('Backend_Theme/assets/js/pages/form-wizard.init.js')}}"></script>
        <script src="{{ asset('Backend_Theme/assets/js/pages/form-advanced.init.js')}}"></script>

        <script>
            @if(Session::has('message'))
                var type = "{{ Session::get('alert-type','info') }}";
                var messages = @json(Session::get('message'));

                // Check if messages is an array
                if (Array.isArray(messages)) {
                    // Loop through each message and display it
                    messages.forEach(function(message) {
                        switch(type) {
                            case 'info':
                                toastr.info(message);
                                break;
                            case 'success':
                                toastr.success(message);
                                break;
                            case 'warning':
                                toastr.warning(message);
                                break;
                            case 'error':
                                toastr.error(message);
                                break;
                        }
                    });
                } else {
                    // If message is a string, display it
                    switch(type) {
                        case 'info':
                            toastr.info(messages);
                            break;
                        case 'success':
                            toastr.success(messages);
                            break;
                        case 'warning':
                            toastr.warning(messages);
                            break;
                        case 'error':
                            toastr.error(messages);
                            break;
                    }
                }
            @endif
            </script>

    </body>

</html>
