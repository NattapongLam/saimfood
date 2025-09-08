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
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                             <div class="col-xl-6">
                                                <div class="product-detai-imgs">
                                                    <div class="row">
                                                        <div class="col-md-2 col-sm-3 col-4">
                                                            <div class="nav flex-column nav-pills " id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                                                <a class="nav-link active" id="product-1-tab" data-bs-toggle="pill" href="#product-1" role="tab" aria-controls="product-1" aria-selected="true">
                                                                    <img src="{{ asset($mc->equipment_pic1 ?? 'images/no-image.png') }}" alt="" class="img-fluid mx-auto d-block rounded">
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7 offset-md-1 col-sm-9 col-8">
                                                            <div class="tab-content" id="v-pills-tabContent">
                                                                <div class="tab-pane fade show active" id="product-1" role="tabpanel" aria-labelledby="product-1-tab">
                                                                    <div>
                                                                        <img src="{{ asset($mc->equipment_pic1 ?? 'images/no-image.png') }}" alt="" class="img-fluid mx-auto d-block">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="text-center">
                                                                <a href="{{ route('customer-repair.edit', $mc->equipment_id) }}" class="btn btn-primary waves-effect waves-light mt-2 me-1">
                                                                    แจ้งซ่อม
                                                                </a>
                                                            </div>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="mt-4 mt-xl-3">
                                                    <h5 style="color: red"><strong>สถานะ : {{$mc->equipment_status_name}}</strong></h5>
                                                    <a href="javascript: void(0);" class="text-primary">{{$mc->equipment_code}}</a>
                                                    <h4 class="mt-1 mb-3">{{$mc->equipment_name}}</h4>  
                                                    <p class="text-muted mb-4">Serial : {{$mc->serial_number}}</p>
                                                    <p class="text-muted mb-4">{{$mc->equipment_details}}</p>
                                                    <p class="text-muted mb-4">สถานที่ตั้ง : {{$mc->equipment_location}}</p>
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <div>
                                                                @if ($mc->equipment_pic2)
                                                                    <a class="text-muted" href="{{ asset($mc->equipment_pic2) }}" target="_blank">
                                                                        <i class="fas fa-file font-size-16 align-middle text-primary me-1"></i> ใบรับประกัน
                                                                    </a>
                                                                @endif                                                               
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div>
                                                                @if ($mc->equipment_pic3)
                                                                    <a class="text-muted" href="{{ asset($mc->equipment_pic3) }}" target="_blank">
                                                                        <i class="fas fa-file font-size-16 align-middle text-primary me-1"></i> คู่มือ
                                                                    </a>
                                                                @endif                                              
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <h5><strong>ประวัติการซ่อม</strong></h5>
                            <div class="table-responsive">
                                <table class="table table-bordered dt-responsive  nowrap w-100 text-center">
                                <thead>
                                    <tr>
                                        <th>สถานะ</th>
                                        <th>เลขที่</th>
                                        <th>อุปกรณ์</th>
                                        <th>อาการ</th>
                                        <th>ผู้แจ้ง</th>
                                        <th>สถานที่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hd as $item)
                                        <tr>
                                            <td>{{$item->customer_repair_status_name}}</td>
                                            <td>{{$item->customer_repair_docu_docuno}}</td>
                                            <td>{{$item->equipment_code}} {{$item->equipment_name}}</td>
                                            <td>{{$item->customer_repair_docu_case}}</td>
                                            <td>{{$item->customer_fullname}} ({{$item->contact_person}})</td>
                                            <td>{{$item->customer_address}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
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