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
                @foreach ($hd as $item)
                    <div class="col-xl-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="favorite-icon">
                                <a><i class="mdi mdi-checkbook"></i> {{$item->equipment_transfer_hd_docuno}}</a>
                            </div>
                            <img src="{{ asset($item->equipment_pic1 ?? 'images/no-image.png') }}" alt="" height="50" class="mb-3">
                            <h5 class="fs-17 mb-2"><a href="#" class="text-dark">{{$item->equipment_name}} ({{$item->equipment_code}})</a> <small class="text-muted fw-normal"><i class="mdi mdi-calendar-month"></i>{{ \Carbon\Carbon::parse($item->equipment_transfer_hd_date)->format('d/M/y') }}</small></h5>
                            <ul class="list-inline mb-0">
                                <li class="list-inline-item">
                                    <p class="text-muted fs-14 mb-1">Serial : {{$item->serial_number}}</p>
                                </li>
                                <li class="list-inline-item">
                                    <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i> {{$item->customer_address}}</p>
                                </li>
                            </ul>           
                            <div class="mt-3 hstack gap-2">
                            @if ($item->equipment_transfer_status_id == 1 || $item->equipment_transfer_status_id == 5)
                                <span class="badge rounded-1 badge-soft-warning">รอจัดส่ง</span>
                            @elseif($item->equipment_transfer_status_id == 2)
                                <span class="badge rounded-1 badge-soft-success">จัดส่งเรียบร้อย</span>
                            @elseif($item->equipment_transfer_status_id == 4)
                                <span class="badge rounded-1 badge-soft-danger">แจ้งซ่อม</span>
                            @endif
                            </div>
                            @if ($item->equipment_transfer_status_id == 4)
                                <div class="mt-4 hstack gap-2">
                                    <a href="#"><h6>เลขที่แจ้งซ่อม : {{$item->case->customer_repair_docu_docuno}} (สถานะ : {{$item->case->customer_repair_status_name}})</h6></a>
                                </div>
                            @else
                            <div class="mt-4 hstack gap-2">
                                <a href="{{ route('customer-repair.show', $item->equipment_transfer_dt_id) }}" class="btn btn-primary w-100">แจ้งซ่อม</a>
                            </div>
                            @endif
                                             
                        </div>
                    </div>
                </div>
                @endforeach               
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