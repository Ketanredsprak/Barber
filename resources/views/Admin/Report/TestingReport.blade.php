<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ static_asset('admin/assets/images/favicon.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ static_asset('admin/assets/images/favicon.png') }}" type="image/x-icon">
    <title>Cuba - Premium Admin Template</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    
    
    <!-- IcoFont -->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/icofont.css') }}">
    
    <!-- Themify Icons -->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/themify.css') }}">
    
    <!-- Flag Icons -->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/flag-icon.css') }}">
    
    <!-- Feather Icons -->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/feather-icon.css') }}">
    
    <!-- Plugins CSS -->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/slick.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/slick-theme.css') }}">
    
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/animate.css') }}">
    
    
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/datatable-extension.css') }}">  
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/vendors/bootstrap.css') }}">
    
    <!-- App CSS -->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/style.css') }}">
    <link id="color" rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/color-1.css') }}" media="screen">
    
    <!-- Responsive CSS -->
    <link rel="stylesheet" type="text/css" href="{{ static_asset('admin/assets/css/responsive.css') }}">
</head>

<body>
    <!-- tap on top starts-->
    <div class="tap-top"><i data-feather="chevrons-up"></i></div>
    <!-- tap on tap ends--> 
    <!-- loader starts-->
    <div class="loader-wrapper">
        <div class="loader-index"> <span></span></div>
        <svg>
            <defs></defs>
            <filter id="goo">
                <feGaussianBlur in="SourceGraphic" stdDeviation="11" result="blur"></feGaussianBlur>
                <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="goo"></feColorMatrix>
            </filter>
        </svg>
    </div>
    <!-- loader ends-->
    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- Page Header Start-->

        <!-- Page Header Ends -->
        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <!-- Page Sidebar Start-->

            <!-- Page Sidebar Ends-->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-6">
                                <h4>Autofill Datatables</h4>
                            </div>
                            <div class="col-6">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.html">                                       
                                        <svg class="stroke-icon">
                                            <use href="{{ static_asset('admin/assets/svg/icon-sprite.svg#stroke-home') }}"></use>
                                        </svg></a></li>
                                    <li class="breadcrumb-item">Extension Data Tables</li>
                                    <li class="breadcrumb-item active">Autofill Datatables</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid starts-->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-header pb-0 card-no-border">
                                    <h4>HTML5 Export Buttons</h4>
                                </div>
                                <div class="card-body">
                                    <div class="dt-ext table-responsive">
                                        <table class="display" id="export-button">
                                            <thead>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Assign To</th>
                                                    <th>Age</th>
                                                    <th>Start date</th>
                                                    <th>Salary</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                </tr>
                                                <tr>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                </tr>    <tr>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                    <td>asd</td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Name</th>
                                                    <th>Position</th>
                                                    <th>Assign To</th>
                                                    <th>Age</th>
                                                    <th>Start date</th>
                                                    <th>Salary</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Container-fluid Ends-->
            </div>
            <!-- footer start-->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 footer-copyright text-center">
                            <p class="mb-0">Copyright 2023 © Cuba theme by pixelstrap</p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- latest jQuery -->
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}">
    </script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}">
    </script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}">
    </script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}">
    </script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}">
    </script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}">
    </script>
    <script src="{{ static_asset('admin/assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>

</body>
</html>
