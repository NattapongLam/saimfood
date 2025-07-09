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
                                    <br>
                                    <div class="row">
                                        <table class="table table-bordered dt-responsive  nowrap w-100 text-center">
                                            <thead>
                                                <tr>
                                                    <th>สถานะ</th>
                                                    <th>วันที่</th>
                                                    <th>เลขที่</th>
                                                    <th>ประเภท</th>
                                                    <th>ปัญหา</th>
                                                    <th>ผู้แจ้งซ่อม</th>
                                                    <th>ผู้ดำเนินการ</th>
                                                    <th></th>
                                                    <th>จป.</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($repair as $item)
                                                <tr>
                                                    <td>
                                                        @if ($item->machine_repair_status_id == 1 || $item->machine_repair_status_id == 9)
                                                            <span class="badge bg-warning">{{$item->machine_repair_status_name}}</span>                                                           
                                                        @elseif($item->machine_repair_status_id == 7 || $item->machine_repair_status_id == 8)
                                                            <span class="badge bg-danger">{{$item->machine_repair_status_name}}</span>   
                                                        @elseif($item->machine_repair_status_id == 6)
                                                            <span class="badge bg-success">{{$item->machine_repair_status_name}}</span>  
                                                        @else
                                                            <span class="badge bg-secondary">{{$item->machine_repair_status_name}}</span>
                                                        @endif                                                      
                                                    </td>
                                                    <td>{{$item->machine_repair_dochd_date}}</td>
                                                    <td>{{$item->machine_repair_dochd_docuno}}</td>
                                                    <td>
                                                        @if ($item->machine_repair_dochd_type == "ด่วน")
                                                            <span class="badge badge-soft-danger">งาน :  {{$item->machine_repair_dochd_type}}</span>
                                                        @else
                                                            <span class="badge badge-soft-primary">งาน :  {{$item->machine_repair_dochd_type}}</span>
                                                        @endif
                                                       
                                                        @if ($item->repairer_type)
                                                            @if ($item->repairer_type == "หยุดเครื่อง")
                                                                <br><span class="badge badge-soft-danger">สถานะ : {{$item->repairer_type}}</span>
                                                            @else
                                                                <br><span class="badge badge-soft-primary">สถานะ : {{$item->repairer_type}}</span>
                                                            @endif

                                                        @endif
                                                        @if ($item->repairer_problem)
                                                            @if ($item->repairer_problem == "ควรซื้อใหม่")
                                                                <br><span class="badge badge-soft-danger">เพิ่มเติม : {{$item->repairer_problem}}</span>
                                                            @else
                                                                <br><span class="badge badge-soft-primary">เพิ่มเติม :{{$item->repairer_problem}}</span>
                                                            @endif
                                                        
                                                        @endif

                                                    </td>
                                                    <td>
                                                        {{$item->machine_repair_dochd_case}}<br>
                                                        (ที่ตั้ง : {{$item->machine_repair_dochd_location}})
                                                    </td>
                                                    <td>      
                                                        {{$item->person_at}}                                                
                                                    </td>
                                                    <td>  
                                                        @if ($item->accepting_at)
                                                            ผู้รับงานซ่อม : {{$item->accepting_at}}  
                                                        @endif    
                                                        @if ($item->repairer_at)
                                                            <br>ผู้ซ่อม : {{$item->repairer_at}}   
                                                        @endif
                                                                                                    
                                                    </td>
                                                    <td>
                                                        @if($item->machine_repair_status_id == 6)
                                                            <a href="{{ route('machine-repair-docus.edit', $item->machine_repair_dochd_id) }}"class="btn btn-primary btn-sm">รายละเอียด</a>
                                                        @elseif ($item->machine_repair_status_id <> 7 || $item->machine_repair_status_id <> 8)
                                                            <a href="{{ route('machine-repair-docus.edit', $item->machine_repair_dochd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> อัพเดท</a>                                
                                                        @endif                                                      
                                                    </td>
                                                    <td>
                                                        @if($item->safety_at)
                                                            {{{$item->safety_type}}}<br>
                                                            ความเห็น : {{$item->safety_note}}
                                                        @else
                                                            @if ($item->machine_repair_status_id <> 7 || $item->machine_repair_status_id <> 8)
                                                            <a href="{{ route('machine-repair-docus.show', $item->machine_repair_dochd_id) }}"class="btn btn-secondary btn-sm">บันทึก</a> 
                                                            @endif   
                                                        @endif  
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        </table>
                                    </div>
                                    <br>
                                    <div class="row">
                                    <div class="col-xl-12 col-lg-12">
                                        <div class="card">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs nav-tabs-custom justify-content-center pt-2" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link active" data-bs-toggle="tab" href="#all-post" role="tab" aria-selected="true">
                                                    ตรวจเช็คประจำวัน
                                                    </a>
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <a class="nav-link" data-bs-toggle="tab" href="#archive" role="tab" aria-selected="false" tabindex="-1">
                                                    PM ประจำปี
                                                    </a>
                                                </li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content p-4">
                                                <div class="tab-pane active show" id="all-post" role="tabpanel">
                                                    <div class="row">
                                                        <table class="table table-bordered dt-responsive  nowrap w-100 text-center">
                                                <thead>
                                                    <tr>
                                                        <th>วันที่</th>
                                                        <th>หมายเหตุ</th>
                                                        <th>ผู้บันทึก</th>
                                                        <th>ผู้อนุมัติ</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($checksheet as $item)
                                                        <tr>
                                                            <td>{{$item->machine_checksheet_docu_hd_date}}</td>
                                                            <td>{{$item->machine_checksheet_docu_hd_note}}</td>
                                                            <td>
                                                            {{$item->person_at}} 
                                                            </td>
                                                            <td>
                                                                {{$item->approved_at}} 
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('machine-checksheet-docus.edit', $item->machine_checksheet_docu_hd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> อัพเดท</a>                                                                                                                  
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            </div>
                                            </div>

                                            <div class="tab-pane" id="archive" role="tabpanel">
                                                <table class="table table-bordered dt-responsive  nowrap w-100 text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>วันที่</th>
                                                            <th>หมายเหตุ</th>
                                                            <th>Plan</th>
                                                            <th>Action</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                     <tbody>
                                            @foreach ($plan as $item)
                                                <tr>
                                                    <td>{{$item->machine_planingdocu_dt_date}}</td>
                                                    <td>{{$item->machine_planingdocu_dt_note}}</td>
                                                    <td>
                                                        @if($item->machine_planingdocu_dt_plan)
                                                            <input class="form-check-input" type="checkbox" id="formCheckcolor1" checked="">
                                                        @else
                                                            <input class="form-check-input" type="checkbox" id="formCheckcolor1">
                                                        @endif  
                                                    </td>
                                                    <td>
                                                        @if($item->machine_planingdocu_dt_action)
                                                            <input class="form-check-input" type="checkbox" id="formCheckcolor2" checked="">
                                                        @else
                                                            <input class="form-check-input" type="checkbox" id="formCheckcolor2">
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($item->machine_planingdocu_dt_action == 0)
                                                            <a href="{{ route('machine-planing-docus.edit', $item->machine_planingdocu_dt_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> อัพเดท</a>                                                        
                                                        @endif                                                        
                                                    </td>
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