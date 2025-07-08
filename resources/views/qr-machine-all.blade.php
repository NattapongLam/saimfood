<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>บริษัท สยาม ฟูดส์ แอนด์ เบฟเวอร์เรจ โซลูชั่น จำกัด</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="บริษัท สยาม ฟูดส์ แอนด์ เบฟเวอร์เรจ โซลูชั่น จำกัด" name="description" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{asset('assets/images/favicon.ico')}}">
        <!-- Bootstrap Css -->
        <link href="{{asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    </head>
<body data-sidebar="dark" data-layout-mode="light">
    <div id="layout-wrapper">
        <header id="page-topbar">
            <div class="navbar-header">
            </div>
        </header>
        <div class="page-content">
           <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-transparent border-primary">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                <h3 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>รหัสเครื่อง : {{$mc->machine_code}} ชื่อเครื่อง : {{$mc->machine_name}}</h3>
                                                <div class="page-title-right">
                                                    <h3 class="my-0 text-primary">
                                                        Serial : {{$mc->serial_number}}
                                                        @if ($mc->machine_pic2)
                                                            <a href="{{ asset($mc->machine_pic2) }}" target="_blank"><i class="fas fa-file"></i>ใบรับประกัน</a>
                                                        @endif
                                                        @if ($mc->machine_pic3)
                                                            <a href="{{ asset($mc->machine_pic3) }}" target="_blank"><i class="fas fa-file"></i>คู่มือ</a>
                                                        @endif
                                                    </h3>
                                                </div>                  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>เพิ่มเติม : {{$mc->machine_details}}</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <center>
                                        <div class="col-12">
                                            <img src="{{ asset($mc->machine_pic1 ?? 'images/no-image.png') }}" class="img-fluid" alt="Responsive image">
                                        </div>                                       
                                        </center>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-4">
                                            <a href="{{route('machine-repair-docus.create')}}" class="btn btn-soft-primary btn-lg">
                                                แจ้งซ่อม
                                            </a>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
<div class="rightbar-overlay"></div>
 <!-- JAVASCRIPT -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<!-- App js -->
<script src="{{asset('assets/js/app.js')}}"></script>
</body>
</html>