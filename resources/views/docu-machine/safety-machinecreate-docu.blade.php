@extends('layouts.main')
@section('content')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-transparent border-primary">
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
                        <div class="col-12">
                            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งสร้าง (เลขที่ : {{$hd->machine_repair_dochd_docuno}} สถานะ : {{$hd->machine_create_status_name}})</h5>                              
                            </div>                           
                            <h5>รายการแจ้งสร้าง ผู้แจ้ง : {{$hd->person_at}}</h5>
                            <div class="card-body">
                               <div class="row"> 
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="machine_repair_dochd_date" value="{{$hd->machine_repair_dochd_date}}" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ประเภท</label>
                                            <select class="form-select" name="machine_repair_dochd_type" required>
                                                @if ($hd->machine_repair_dochd_type == "ปกติ")
                                                    <option value="ปกติ">ปกติ</option>
                                                    <option value="ด่วน">ด่วน</option>
                                                @elseif($hd->machine_repair_dochd_type == "ด่วน")
                                                    <option value="ด่วน">ด่วน</option>
                                                    <option value="ปกติ">ปกติ</option>                                                  
                                                @endif
                                               
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่องาน</label>
                                            <input class="form-control" type="text" name="machine_code" value="{{$hd->machine_code}}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ที่ตั้ง</label>
                                            <input class="form-control" type="text" name="machine_repair_dochd_location" value="{{$hd->machine_repair_dochd_location}}" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">วันที่ต้องการเสร็จ</label>
                                        <input class="form-control" type="date" name="machine_repair_dochd_duedate" value="{{$hd->machine_repair_dochd_duedate}}" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">ปัญหา</label>
                                        <textarea class="form-control" name="machine_repair_dochd_case" required>{{$hd->machine_repair_dochd_case}}</textarea>
                                    </div>
                                </div>
                            </div>                                                     
                        </div>
                </div>
            </div>
        </div>
    </div>
     <div class="col-12">
        <div class="card">
              <div class="card-header bg-transparent border-primary">
                  <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ความคิดเห็นจป.วิชาชีพ</h5>                              
                        </div>
                       <form class="custom-validation" 
                        action="{{ route('machine-create-docus.safety-update', $hd->machine_repair_dochd_id) }}" 
                        method="POST" 
                        enctype="multipart/form-data">
                        @csrf    
                        @method('PUT') 
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">สถานะพื้นที่</label>
                                        <select class="form-select" name="safety_type" required>
                                            <option value="ใช้งานพื้นที่ได้ปกติ">ใช้งานพื้นที่ได้ปกติ</option>
                                            <option value="หยุดใช้งานพื้นที่">หยุดใช้งานพื้นที่</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">อุปกรณ์ความปลอดภัย</label>
                                        <textarea class="form-control" name="safety_ppe" required>{{$hd->safety_ppe}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ความคิดเห็น</label>
                                        <textarea class="form-control" name="safety_note" required>{{$hd->safety_note}}</textarea>
                                    </div>
                                </div>
                            </div>    
                            <div class="row">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid safety_pic1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">แนบหลักฐาน</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="safety_pic1" onchange="prevFile(this,'safety_pic1')">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                </div>
                                                </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-6">                                        
                                        <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid safety_pic2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">แนบหลักฐาน</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="safety_pic2" onchange="prevFile(this,'safety_pic2')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div>
                                                </div>
                                                </div>
                                        </div>
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
                        </div>
                        </form>
                  </div>
              </div>
        </div>
     </div>
</div>
@endsection
@section('script')
@endsection
   