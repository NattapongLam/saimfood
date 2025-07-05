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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งซ่อม (เลขที่ : {{$hd->machine_repair_dochd_docuno}} สถานะ : {{$hd->machine_repair_status_name}})</h5>                              
                            </div>
                            <form class="custom-validation" action="{{ route('machine-repair-docus.update',$hd->machine_repair_dochd_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf    
                            @method('PUT')  
                            <h5>รายการแจ้งซ่อม ผู้แจ้ง : {{$hd->person_at}}</h5>
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
                                            <label class="form-label">เครื่องจักร</label>
                                            <select class="select2 form-select" name="machine_code" required>
                                                <option value="">กรุณาเลือก</option>
                                                @foreach ($machine as $item)
                                                <option value="{{$item->machine_code}}" {{ $item->machine_code == $hd->machine_code ? 'selected' : '' }}>
                                                    {{$item->machine_code}} / {{$item->machine_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ที่ตั้ง</label>
                                            <input class="form-control" type="type" name="machine_repair_dochd_location" value="{{$hd->machine_repair_dochd_location}}" required>
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
                            @if ($hd->machine_repair_status_id == 1 || $hd->machine_repair_status_id == 9)
                            <h5>รายละเอียดการรับงานซ่อม</h5>
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="form-group">
                                         <label class="form-label">วันที่คาดว่าจะซ่อมเสร็จ</label>
                                         <input class="form-control" type="date" name="accepting_duedate" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุรับงานซ่อม</label>
                                        <textarea class="form-control" name="accepting_note" required>{{$hd->accepting_note}}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                     <div class="col-12" style="text-align: right;">
                                                <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                                            </div>
                                            <table class="table table-striped mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รายละเอียด</th>
                                                        <th>ค่าใช้จ่าย</th>
                                                        <th>หมายเหตุ</th>
                                                        <th>ชื่อร้าน</th>                                                       
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hd->details as $key => $item)
                                                        <tr>
                                                            <td>
                                                                {{$item->machine_repair_docdt_listno}}
                                                                <input type="hidden" name="machine_repair_docdt_listno[]" value="{{$item->machine_repair_docdt_listno}}">
                                                            </td>
                                                            <td>                              
                                                                <input class="form-control" name="machine_repair_docdt_remark[]" value="{{$item->machine_repair_docdt_remark}}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="machine_repair_docdt_cost[]" value="{{number_format($item->machine_repair_docdt_cost,2)}}">                                                              
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="machine_repair_docdt_note[]" value="{{$item->machine_repair_docdt_note}}">                                    
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="machine_repair_docdt_vendor[]" value="{{$item->machine_repair_docdt_vendor}}">                                    
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="machine_repair_docdt_id[]" value="{{$item->machine_repair_docdt_id}}">
                                                                <div class="square-switch">
                                                                    @if($item->machine_repair_docdt_flag == 1)
                                                                    <input type="checkbox" id="square-switch1" switch="none" name="machine_repair_docdt_flag[]" value="true" checked/>
                                                                    @else
                                                                    <input type="checkbox" id="square-switch1" switch="none" name="machine_repair_docdt_flag[]" />
                                                                    @endif
                                                                    <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach   
                                                </tbody>
                                                <tbody id="tableBody">
                                                </tbody>
                                            </table>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="d-flex flex-wrap gap-2 justify-content">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                            รับงานซ่อม
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @elseif($hd->machine_repair_status_id == 2)
                            <h5>รายละเอียดการรับงานซ่อม ผู้รับงานซ่อม : {{$hd->accepting_at}} วันที่ : {{$hd->accepting_date}}</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group">
                                         <label class="form-label">วันที่คาดว่าจะซ่อมเสร็จ</label>
                                         <input class="form-control" type="date" name="accepting_duedate" value="{{$hd->accepting_duedate}}" readonly>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุรับงานซ่อม</label>
                                        <textarea class="form-control" name="accepting_note" required>{{$hd->accepting_note}}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <h5>เพิ่มเติม</h5>
                                    <table class="table table-striped table-bordered mb-0 text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>รายการ</th>
                                                            <th>ค่าใช้จ่าย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th>ชื่อร้าน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hd->details->where('machine_repair_docdt_flag', true) as $key => $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{$item->machine_repair_docdt_remark}}</td>
                                                                <td>{{number_format($item->machine_repair_docdt_cost,2)}}</td>
                                                                <td>{{$item->machine_repair_docdt_note}}</td>
                                                                <td>{{$item->machine_repair_docdt_vendor}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                    </table>         
                                </div>                                                           
                            </div>
                            <h5>รายละเอียดอนุมัติซ่อม</h5>
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="form-group">
                                        <label class="form-label">เลือกสถานะ</label>
                                        <select class="form-select" name="machine_repair_status_id" required>
                                            <option value="">กรุณาเลือก</option>
                                            @foreach ($status as $item)
                                               <option value="{{$item->machine_repair_status_id}}">{{$item->machine_repair_status_name}}</option> 
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุอนุมัติซ่อม</label>
                                        <textarea class="form-control" name="approval_note"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="d-flex flex-wrap gap-2 justify-content">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                            อนุมัติซ่อม
                                        </button>
                                    </div>
                                </div>
                             </div>
                            @elseif($hd->machine_repair_status_id == 3)
                            <h5>รายละเอียดการรับงานซ่อม  ผู้รับงานซ่อม : {{$hd->accepting_at}} วันที่ : {{$hd->accepting_date}}</h5>
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุรับงานซ่อม</label>
                                        <textarea class="form-control" name="accepting_note" readonly>{{$hd->accepting_note}}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <h5>เพิ่มเติม</h5>
                                    <table class="table table-striped table-bordered mb-0 text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>รายการ</th>
                                                            <th>ค่าใช้จ่าย</th>
                                                            <th>หมายเหตุ</th>
                                                            <th>ชื่อร้าน</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hd->details->where('machine_repair_docdt_flag', true) as $key => $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{$item->machine_repair_docdt_remark}}</td>
                                                                <td>{{number_format($item->machine_repair_docdt_cost,2)}}</td>
                                                                <td>{{$item->machine_repair_docdt_note}}</td>
                                                                <td>{{$item->machine_repair_docdt_vendor}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                    </table>
                                </div>
                                </div>
                                <h5>รายละเอียดอนุมัติซ่อม  ผู้อนุมัติซ่อม : {{$hd->approval_at}} วันที่ : {{$hd->approval_date}}</h5>
                                <div class="card-body">              
                                <div class="row">
                                     <div class="form-group">
                                        <label class="form-label">หมายเหตุอนุมัติซ่อม</label>
                                        <textarea class="form-control" name="approval_note" readonly>{{$hd->approval_note}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <h5>ผลการซ่อม</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วัน-เวลาที่ซ่อมเสร็จ</label>
                                            @php
                                                date_default_timezone_set('Asia/Bangkok');
                                            @endphp
                                            <input class="form-control" type="datetime-local" name="repairer_datetime" value="{{ date('Y-m-d\TH:i') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">สถานะเครื่องจักร</label>
                                            <select class="form-select" name="repairer_type" required>
                                                <option value="หยุดเครื่อง">หยุดเครื่อง</option>
                                                <option value="ทำงานปกติ">ทำงานปกติ</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">สถานะปัญหา</label>
                                            <select class="form-select" name="repairer_problem" required>
                                                <option value="ใช้งานได้ต่อ">ใช้งานได้ต่อ</option>
                                                <option value="ควรซื้อใหม่">ควรซื้อใหม่</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>                              
                                <div class="row">
                                     <div class="form-group">
                                        <label class="form-label">รายละเอียด</label>
                                        <textarea class="form-control" name="repairer_note" required>{{$hd->repairer_note}}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid repairer_pic1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">แนบหลักฐานการซ่อม</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="repairer_pic1" onchange="prevFile(this,'repairer_pic1')">
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
                                                    <img src="" class="img-fluid repairer_pic2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">แนบหลักฐานการซ่อม</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="repairer_pic2" onchange="prevFile(this,'repairer_pic2')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div>
                                                </div>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">    
                                    <div class="col-12" style="text-align: right;">
                                        <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                                    </div>                               
                                    <table class="table table-striped mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รายละเอียด</th>
                                                        <th>ค่าใช้จ่าย</th>
                                                        <th>หมายเหตุ</th>
                                                        <th>ชื่อร้าน</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                </tbody>
                                    </table>
                                </div>
                                <br>
                                <div class="form-group">
                                    <div class="d-flex flex-wrap gap-2 justify-content">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                            บันทึกผลการซ่อม
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @elseif($hd->machine_repair_status_id == 4)
                            <h5>รายละเอียดการรับงานซ่อม  ผู้รับงานซ่อม : {{$hd->accepting_at}} วันที่ : {{$hd->accepting_date}}</h5>
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุรับงานซ่อม</label>
                                        <textarea class="form-control" name="accepting_note" readonly>{{$hd->accepting_note}}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <h5>เพิ่มเติม</h5>
                                    <table class="table table-striped table-bordered mb-0 text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>รายการ</th>
                                                            <th>ค่าใช้จ่าย</th>
                                                            <th>หมายเหตุ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hd->details->where('machine_repair_docdt_flag', true) as $key => $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{$item->machine_repair_docdt_remark}}</td>
                                                                <td>{{number_format($item->machine_repair_docdt_cost,2)}}</td>
                                                                <td>{{$item->machine_repair_docdt_note}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                    </table>
                                </div>
                                </div>
                                <h5>รายละเอียดอนุมัติซ่อม  ผู้อนุมัติซ่อม : {{$hd->approval_at}} วันที่ : {{$hd->approval_date}}</h5>
                                <div class="card-body">              
                                <div class="row">
                                     <div class="form-group">
                                        <label class="form-label">หมายเหตุอนุมัติซ่อม</label>
                                        <textarea class="form-control" name="approval_note" readonly>{{$hd->approval_note}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <h5>
                                ผลการซ่อม  ผู้ซ่อม : {{$hd->repairer_at}} 
                                @if ($hd->repairer_pic1)
                                    <a href="{{ asset('/'.$hd->repairer_pic1) }}" target="_blank"><i class="fas fa-image"></i></a>
                                @endif
                                @if ($hd->repairer_pic2)
                                    <a href="{{ asset('/'.$hd->repairer_pic2) }}" target="_blank"><i class="fas fa-image"></i></a>
                                @endif
                            </h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">วัน-เวลาที่ซ่อมเสร็จ</label>
                                                @php
                                                    date_default_timezone_set('Asia/Bangkok');
                                                @endphp
                                                <input class="form-control" type="datetime-local" name="repairer_datetime" value="{{$hd->repairer_datetime}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">สถานะเครื่องจักร</label>
                                                <input class="form-control" type="text" name="repairer_type" value="{{$hd->repairer_type}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">สถานะปัญหา</label>
                                                <input class="form-control" type="text" name="repairer_problem" value="{{$hd->repairer_problem}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" name="repairer_note" readonly>{{$hd->repairer_note}}</textarea>
                                        </div>
                                    </div>                                   
                                </div>
                                <h5>ตรวจสอบการซ่อม</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">หมายเหตุตรวจสอบ</label>
                                                <textarea class="form-control" name="inspector_note">{{$hd->inspector_note}}</textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="d-flex flex-wrap gap-2 justify-content">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                                    ตรวจสอบการซ่อม
                                                </button>
                                            </div>
                                        </div>
                                    </div>                          
                            @elseif($hd->machine_repair_status_id == 5)
                               <h5>รายละเอียดการรับงานซ่อม  ผู้รับงานซ่อม : {{$hd->accepting_at}} วันที่ : {{$hd->accepting_date}}</h5>
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุรับงานซ่อม</label>
                                        <textarea class="form-control" name="accepting_note" readonly>{{$hd->accepting_note}}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <h5>เพิ่มเติม</h5>
                                    <table class="table table-striped table-bordered mb-0 text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>รายการ</th>
                                                            <th>ค่าใช้จ่าย</th>
                                                            <th>หมายเหตุ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hd->details->where('machine_repair_docdt_flag', true) as $key => $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{$item->machine_repair_docdt_remark}}</td>
                                                                <td>{{number_format($item->machine_repair_docdt_cost,2)}}</td>
                                                                <td>{{$item->machine_repair_docdt_note}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                    </table>
                                </div>
                                </div>
                                <h5>รายละเอียดอนุมัติซ่อม  ผู้อนุมัติซ่อม : {{$hd->approval_at}} วันที่ : {{$hd->approval_date}}</h5>
                                <div class="card-body">              
                                <div class="row">
                                     <div class="form-group">
                                        <label class="form-label">หมายเหตุอนุมัติซ่อม</label>
                                        <textarea class="form-control" name="approval_note" readonly>{{$hd->approval_note}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <h5>
                                ผลการซ่อม  ผู้ซ่อม : {{$hd->repairer_at}} 
                                @if ($hd->repairer_pic1)
                                    <a href="{{ asset('/'.$hd->repairer_pic1) }}" target="_blank"><i class="fas fa-image"></i></a>
                                @endif
                                @if ($hd->repairer_pic2)
                                    <a href="{{ asset('/'.$hd->repairer_pic2) }}" target="_blank"><i class="fas fa-image"></i></a>
                                @endif
                            </h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">วัน-เวลาที่ซ่อมเสร็จ</label>
                                                @php
                                                    date_default_timezone_set('Asia/Bangkok');
                                                @endphp
                                                <input class="form-control" type="datetime-local" name="repairer_datetime" value="{{$hd->repairer_datetime}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">สถานะเครื่องจักร</label>
                                                <input class="form-control" type="text" name="repairer_type" value="{{$hd->repairer_type}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">สถานะปัญหา</label>
                                                <input class="form-control" type="text" name="repairer_problem" value="{{$hd->repairer_problem}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" name="repairer_note" readonly>{{$hd->repairer_note}}</textarea>
                                        </div>
                                    </div>                                   
                                </div>
                                <h5>ตรวจสอบการซ่อม ผู้ตรวจสอบ : {{$hd->inspector_at}} วันที่ : {{$hd->inspector_date}}</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">หมายเหตุตรวจสอบ</label>
                                                <textarea class="form-control" name="inspector_note" readonly>{{$hd->inspector_note}}</textarea>
                                            </div>
                                        </div>                                      
                                    </div>
                                <h5>ปิดงานซ่อม</h5>
                                    <div class="card-body"> 
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">หมายเหตุปิดงาน</label>
                                                <textarea class="form-control" name="closing_note">{{$hd->closing_note}}</textarea>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <div class="d-flex flex-wrap gap-2 justify-content">
                                                <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                                    ปิดงาน
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                            @elseif($hd->machine_repair_status_id == 6)
                                  <h5>รายละเอียดการรับงานซ่อม  ผู้รับงานซ่อม : {{$hd->accepting_at}} วันที่ : {{$hd->accepting_date}}</h5>
                            <div class="card-body">
                                <div class="row"> 
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุรับงานซ่อม</label>
                                        <textarea class="form-control" name="accepting_note" readonly>{{$hd->accepting_note}}</textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <h5>เพิ่มเติม</h5>
                                    <table class="table table-striped table-bordered mb-0 text-center">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>รายการ</th>
                                                            <th>ค่าใช้จ่าย</th>
                                                            <th>หมายเหตุ</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($hd->details->where('machine_repair_docdt_flag', true) as $key => $item)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{$item->machine_repair_docdt_remark}}</td>
                                                                <td>{{number_format($item->machine_repair_docdt_cost,2)}}</td>
                                                                <td>{{$item->machine_repair_docdt_note}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                    </table>
                                </div>
                                </div>
                                <h5>รายละเอียดอนุมัติซ่อม  ผู้อนุมัติซ่อม : {{$hd->approval_at}} วันที่ : {{$hd->approval_date}}</h5>
                                <div class="card-body">              
                                <div class="row">
                                     <div class="form-group">
                                        <label class="form-label">หมายเหตุอนุมัติซ่อม</label>
                                        <textarea class="form-control" name="approval_note" readonly>{{$hd->approval_note}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <h5>
                                ผลการซ่อม  ผู้ซ่อม : {{$hd->repairer_at}} 
                                @if ($hd->repairer_pic1)
                                    <a href="{{ asset('/'.$hd->repairer_pic1) }}" target="_blank"><i class="fas fa-image"></i></a>
                                @endif
                                @if ($hd->repairer_pic2)
                                    <a href="{{ asset('/'.$hd->repairer_pic2) }}" target="_blank"><i class="fas fa-image"></i></a>
                                @endif
                            </h5>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">วัน-เวลาที่ซ่อมเสร็จ</label>
                                                @php
                                                    date_default_timezone_set('Asia/Bangkok');
                                                @endphp
                                                <input class="form-control" type="datetime-local" name="repairer_datetime" value="{{$hd->repairer_datetime}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">สถานะเครื่องจักร</label>
                                                <input class="form-control" type="text" name="repairer_type" value="{{$hd->repairer_type}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label class="form-label">สถานะปัญหา</label>
                                                <input class="form-control" type="text" name="repairer_problem" value="{{$hd->repairer_problem}}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="form-group">
                                            <label class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" name="repairer_note" readonly>{{$hd->repairer_note}}</textarea>
                                        </div>
                                    </div>                                   
                                </div>
                                <h5>ตรวจสอบการซ่อม ผู้ตรวจสอบ : {{$hd->inspector_at}} วันที่ : {{$hd->inspector_date}}</h5>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">หมายเหตุตรวจสอบ</label>
                                                <textarea class="form-control" name="inspector_note" readonly>{{$hd->inspector_note}}</textarea>
                                            </div>
                                        </div>                                      
                                    </div>
                                <h5>ปิดงานซ่อม ผู้ปิดงาน : {{$hd->closing_at}} วันที่ : {{$hd->closing_date}}</h5>
                                    <div class="card-body"> 
                                        <div class="row">
                                            <div class="form-group">
                                                <label class="form-label">หมายเหตุปิดงาน</label>
                                                <textarea class="form-control" name="closing_note" readonly>{{$hd->closing_note}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                            @endif                      
                            </form>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "เลือกเครื่องจักร",
        allowClear: true,
        width: '100%'
    });
});
let listNoStart = {{ $hd->details->max('machine_repair_docdt_listno') ?? 0 }};
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        const listno = listNoStart + index + 1;
        row.querySelector('.row-number').textContent = listno;
        row.querySelector('.row-number-hidden').value = listno;
    });
}
document.addEventListener('DOMContentLoaded', function () {
    const addRowBtn = document.getElementById('addRowBtn');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', function () {
            const tbody = document.getElementById('tableBody');

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <span class="row-number"></span>
                    <input type="hidden" name="machine_repair_docdt_listno[]" class="row-number-hidden"/>
                </td>
                <td><input type="text" name="machine_repair_docdt_remark[]" class="form-control"/></td>
                <td><input type="text" name="machine_repair_docdt_cost[]" value="0"  class="form-control"/></td>
                <td><input type="text" name="machine_repair_docdt_note[]" class="form-control"/></td>
                <td><input type="text" name="machine_repair_docdt_vendor[]" class="form-control"/></td>
                <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
            `;

            tbody.appendChild(newRow);
            updateRowNumbers();
        });
    }
});
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers(); // อัปเดตลำดับหลังจากลบ
    }
});
</script>
@endsection