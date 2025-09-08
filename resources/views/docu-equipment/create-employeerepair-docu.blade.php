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
                            @if(Session::has('error'))
                            <div class="alert alert-danger alert-block">
                                <strong>{{ Session::get('error') }}</strong>
                            </div>
                            @endif
                            @if(Session::has('success'))
                            <div class="alert alert-success alert-block">
                                <strong>{{ Session::get('success') }}</strong>
                            </div>
                            @endif       
                        </div>
                        <h5><strong>เอกสารแจ้งซ่อม</strong></h5>
                        <form class="custom-validation" action="{{ route('customer-repair.store') }}" method="POST" enctype="multipart/form-data" validate>
                        @csrf   
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">วันที่ซื้อ</label>
                                    <input class="form-control" name="equipment_transfer_hd_docuno" type="date" value="{{$hd->equipmente_date}}" readonly>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">รหัสเครื่อง</label>
                                    <input class="form-control" name="equipment_transfer_hd_docuno" type="text" value="{{$hd->equipment_code}}" readonly>
                                    <input type="hidden" name="equipment_transfer_dt_id" value="0">
                                </div>
                            </div>                            
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">ลูกค้า</label>
                                    <input class="form-control" name="customer_fullname" type="text" value="บริษัท สยาม ฟูดส์ แอนด์ เบฟเวอร์เรจ โซลูชั่น จำกัด" readonly>
                                    <input type="hidden" name="customer_id" value="0">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">ที่อยู่จัดส่ง</label>
                                    <input class="form-control" name="customer_address" type="text" value="99/7 ม.4 ตำบลบ้านคลองสวน อำเภอพระสมุทรเจดีย์ จังหวัดสมุทรปราการ 10290" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">รหัสเครื่อง</label>
                                    <input class="form-control" name="equipment_code" type="text" value="{{$hd->equipment_code}}" readonly>
                                    <input type="hidden" name="equipment_id" value="{{$hd->equipment_id}}">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">ชื่อเครื่อง</label>
                                    <input class="form-control" name="equipment_name" type="text" value="{{$hd->equipment_name}}" readonly>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">ผู้ติดต่อ</label>
                                    <input class="form-control" name="contact_person" type="text"
                                        value="{{ auth()->check() ? auth()->user()->name : old('contact_person') }}"
                                        required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">เบอร์โทร</label>
                                    <input class="form-control" name="contact_tel" type="text" value="02-461-5919" required>
                                </div>
                            </div>
                        </div> 
                        <br>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">รายละเอียดอาการเสีย</label>
                                    <textarea class="form-control" name="customer_repair_docu_case" rows="10" required></textarea>
                                </div>
                            </div>
                        </div>  
                        <br>
                        <div class="form-group">
                            <div class="d-flex flex-wrap gap-2 justify-content">
                                <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                    บันทึก
                                </button>
                            </div>
                        </div>
                    </form>                   
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