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
            <div class="row p-1">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-transparent border-primary">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                                <h3 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>เลขที่ : {{$hd->equipment_transfer_hd_docuno}} วันที่ : {{ \Carbon\Carbon::parse($hd->equipment_transfer_hd_date)->translatedFormat('j F Y') }}</h3>
                                                <div class="page-title-right">
                                                    <h3 class="my-0 text-primary">
                                                        ลูกค้า  : {{$hd->customer_fullname}} ผู้ติดต่อ : {{$hd->contact_person}} เบอร์ : {{$hd->contact_tel}}
                                                    </h3>
                                                </div>                  
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
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