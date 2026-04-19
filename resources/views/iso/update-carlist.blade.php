@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-12">
        <form class="custom-validation" action="{{ route('iso-carlist.update',$hd->iso_car_lists_id) }}" method="POST" enctype="multipart/form-data" validate>
        @csrf  
        @method('PUT')
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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งดำเนินการแก้ไข (Corrective Action Request : CAR)</h5>                            
                            </div>
                            <div class="card-body">
                               <input type="hidden" name="checktype" value="update">
                                <div class="row mt-2"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">CAR NO :</label>
                                            <input class="form-control" type="text" name="iso_car_lists_docuno" value="{{$hd->iso_car_lists_docuno}}" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">กรณีออก CAR ใหม่ อ้างอิง CAR เก่าเลขที่</label>
                                            <input class="form-control" type="text" name="iso_car_lists_refno" value="{{$hd->iso_car_lists_refno}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">กรุณาเลือก</label>
                                            <select class="form-control" name="type_name" required>
                                                <option value="{{$hd->type_name}}">{{$hd->type_name}}</option>
                                                <option value="(I) การตรวจติดตามคุณภาพภายใน">(I) การตรวจติดตามคุณภาพภายใน</option>
                                                <option value="(C) ข้อร้องเรียบจากลูกค้า">(C) ข้อร้องเรียบจากลูกค้า</option>
                                                <option value="(N) ปัญหาเรื่องผลิตภัณฑ์ที่ไม่เป็นไปตามข้อกำหนด">(N) ปัญหาเรื่องผลิตภัณฑ์ที่ไม่เป็นไปตามข้อกำหนด</option>
                                                <option value="(O) อื่นๆ (ระบุ)">(O) อื่นๆ (ระบุ)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เพิ่มเติมจากการเลือก</label>
                                            <input class="form-control" type="text" name="type_remark" value="{{$hd->type_remark}}">
                                        </div>
                                    </div>  
                                </div>
                                <br>
                                <h4>ผลการตรวจติดตาม</h4>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">รายละเอียดที่เกิดปัญหา :</label>
                            <textarea class="form-control" name="iso_car_lists_problem">{{$hd->iso_car_lists_problem}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">ผิดข้อกำหนดระบบมาตรฐานที่ :</label>
                            <input class="form-control" type="text" name="iso_car_lists_requirement" value="{{$hd->iso_car_lists_requirement}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้ออกใบแจ้งดำเนินการแก้ไข</label>
                            <input class="form-control" type="text" name="iso_car_lists_person" value="{{$hd->iso_car_lists_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง</label>
                            <input class="form-control" type="text" name="iso_car_lists_position" value="{{$hd->iso_car_lists_position}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่</label>
                            <input class="form-control" type="date" name="iso_car_lists_date" value="{{$hd->iso_car_lists_date}}">
                        </div>
                    </div>
                </div>
                            </div>                          
                        </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>การวิเคราะห์ปัญหาและหาแนวทางแก้ไข (การวิเคราะห์ปัญหา,วิธีการแก้ไข/ป้องกันจะต้องเสร็จภายในเวลา 7 วัน หลังจากวันที่ออกใบ CAR)</h4>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">สาเหตุของปัญหา</label>
                            <select class="form-control" name="cause_name">
                                <option value="{{$hd->cause_name}}">{{$hd->cause_name}}</option>
                                <option value="คน">คน</option>
                                <option value="วัตถุดิบ">วัตถุดิบ</option>
                                <option value="เครื่องจักร">เครื่องจักร</option>
                                <option value="วิธีการ">วิธีการ</option>
                                <option value="อื่นๆ">อื่นๆ</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label class="form-label">เพิ่มเติม</label>
                            <input class="form-control" type="text" name="cause_remark" value="{{$hd->cause_remark}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">วิเคราะห์จากสาเหตุ</label>
                            <textarea class="form-control" name="cause_analysis">{{$hd->cause_analysis}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">การดำเนินการการแก้ไขเบื้องต้น</label>
                            <textarea class="form-control" name="cause_actions">{{$hd->cause_actions}}</textarea>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">การดำเนินการการแก้ไขป้องกันไม่ให้เกิดซ้ำ</label>
                            <textarea class="form-control" name="cause_recurrence">{{$hd->cause_recurrence}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">กำหนดการแก้ไข/ป้องกันแล้วเสร็จ ภายในวันที่</label>
                            <input class="form-control" type="date" name="cause_duedate" value="{{$hd->cause_duedate}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้รับผิดชอบการแก้ไข :</label>
                            <input class="form-control" type="text" name="cause_person" value="{{$hd->cause_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง :</label>
                            <input class="form-control" type="text" name="cause_position" value="{{$hd->cause_position}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="cause_date" value="{{$hd->cause_date}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้ออกใบแจ้งดำเนินการแก้ไข :</label>
                            <input class="form-control" type="text" name="cause_correction_person" value="{{$hd->cause_correction_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง :</label>
                            <input class="form-control" type="text" name="cause_correction_position" value="{{$hd->cause_correction_position}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="cause_correction_date" value="{{$hd->cause_correction_date}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตัวแทนฝ่ายบริหาร :</label>
                            <input class="form-control" type="text" name="cause_management_person" value="{{$hd->cause_management_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="cause_management_date" value="{{$hd->cause_management_date}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>การติดตามผล</h4>
                <label class="form-label">การติดตามผลการแก้ไข/ป้องกัน ครั้งที่ 1</label>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">                        
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="measuresone_check"
                                    value="1"
                                    {{ $hd->measuresone_check == 1 ? 'checked' : '' }}>
                                 ดำเนินการแก้ไขเสร็จตามที่กำหนด
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="measuresone_next"
                                    value="1"
                                    {{ $hd->measuresone_next == 1 ? 'checked' : '' }}>
                                 ไม่สามารถดำเนินการแก้ไขแล้วเสร็จตามที่กำหนดไว้
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">กำหนดการแก้ไข ครั้งที่ 2 เสร็จภายในวันที่ </label>
                            <input class="form-control" type="date" name="measuresone_date" value="{{$hd->measuresone_date}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">หมายเหตุ/สิ่งที่พบในการดำเนินการแก้ไข :</label>
                            <textarea class="form-control" name="measuresone_remark">{{$hd->measuresone_remark}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้รับผิดชอบการแก้ไข :</label>
                            <input class="form-control" type="text" name="measuresone_person" value="{{$hd->measuresone_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง :</label>
                            <input class="form-control" type="text" name="measuresone_position" value="{{$hd->measuresone_position}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="measuresone_persondate" value="{{$hd->measuresone_persondate}}">
                        </div>
                    </div>
                </div>
                 <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้ติดตามผล :</label>
                            <input class="form-control" type="text" name="measuresone_correction_person" value="{{$hd->measuresone_correction_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง :</label>
                            <input class="form-control" type="text" name="measuresone_correction_position" value="{{$hd->measuresone_correction_position}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="measuresone_correction_date" value="{{$hd->measuresone_correction_date}}">
                        </div>
                    </div>
                </div>
                 <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตัวแทนฝ่ายบริหาร :</label>
                            <input class="form-control" type="text" name="measuresone_management_person" value="{{$hd->measuresone_management_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="measuresone_management_date" value="{{$hd->measuresone_management_date}}">
                        </div>
                    </div>
                </div>
                <label class="form-label">การติดตามผลการแก้ไข/ป้องกัน ครั้งที่ 2</label>
                <div class="row mt-2">
                    <div class="col-6">
                        <div class="form-group">                        
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="measurestwo_check"
                                    value="1"
                                    {{ $hd->measurestwo_check == 1 ? 'checked' : '' }}>
                                 ดำเนินการแก้ไขเสร็จตามที่กำหนด
                            </label>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="measurestwo_next"
                                    value="1"
                                    {{ $hd->measurestwo_next == 1 ? 'checked' : '' }}>
                                 ไม่สามารถดำเนินการแก้ไขแล้วเสร็จตามที่กำหนดไว้
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">หมายเหตุ/สิ่งที่พบในการดำเนินการแก้ไข :</label>
                            <textarea class="form-control" name="measurestwo_remark">{{$hd->measurestwo_remark}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้รับผิดชอบการแก้ไข :</label>
                            <input class="form-control" type="text" name="measurestwo_person" value="{{$hd->measurestwo_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง :</label>
                            <input class="form-control" type="text" name="measurestwo_position" value="{{$hd->measurestwo_position}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="measurestwo_date" value="{{$hd->measurestwo_date}}">
                        </div>
                    </div>
                </div>
                 <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้ติดตามผล :</label>
                            <input class="form-control" type="text" name="measurestwo_correction_person" value="{{$hd->measurestwo_correction_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง :</label>
                            <input class="form-control" type="text" name="measurestwo_correction_position" value="{{$hd->measurestwo_correction_position}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="measurestwo_correction_date" value="{{$hd->measurestwo_correction_date}}">
                        </div>
                    </div>
                </div>
                 <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตัวแทนฝ่ายบริหาร :</label>
                            <input class="form-control" type="text" name="measurestwo_management_person" value="{{$hd->measurestwo_management_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="measurestwo_management_date" value="{{$hd->measurestwo_management_date}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h4>สรุปผลการแก้ไข</h4>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">                        
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="close_car"
                                    value="1"
                                    {{ $hd->close_car == 1 ? 'checked' : '' }}>
                                ปิด CAR
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="new_car"
                                    value="1"
                                    {{ $hd->new_car == 1 ? 'checked' : '' }}>
                                ออก CAR ใหม่
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">CAR NO :</label>
                            <input class="form-control" type="text" name="new_docuno" value="{{$hd->new_docuno}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">หมายเหตุ :</label>
                            <textarea class="form-control" name="car_remark">{{$hd->car_remark}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตัวแทนฝ่ายบริหาร :</label>
                            <input class="form-control" type="text" name="car_management_person" value="{{$hd->car_management_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่ :</label>
                            <input class="form-control" type="date" name="car_management_date" value="{{$hd->car_management_date}}">
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
@endsection
@section('script')
<script>
</script>
@endsection