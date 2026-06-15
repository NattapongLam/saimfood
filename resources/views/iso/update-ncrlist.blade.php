@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-12">
        <form class="custom-validation" action="{{ route('iso-ncrlist.update',$hd->iso_ncr_lists_id) }}" method="POST" enctype="multipart/form-data" validate>
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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบควบคุมใบ NCR (NCR Log Sheet)</h5>
                            </div>
                          
                            <div class="card-body">
                                <input type="hidden" name="checktype" value="update">
                                <div class="row mt-2"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">วันที่ออก NCR</label>
                                            <input class="form-control" type="date" name="iso_ncr_lists_date" value="{{$hd->iso_ncr_lists_date}}">
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เลขที่ NCR</label>
                                            <input class="form-control" name="iso_ncr_lists_docuno" value="{{$hd->iso_ncr_lists_docuno}}">
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ถึงหน่วยงาน</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_to" value="{{$hd->iso_ncr_lists_to}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">สำเนา</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_copy" value="{{$hd->iso_ncr_lists_copy}}">
                                        </div>
                                    </div>                                                                                                                       
                                </div>
                                <div class="row mt-2">                                      
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ผู้พบปัญหา</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_person" value="{{$hd->iso_ncr_lists_person}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">เลขที่ใบสั่งซื้อ/สั่งผลิต</label>
                                            <input class="form-control" name="iso_ncr_lists_refdocu" value="{{$hd->iso_ncr_lists_refdocu}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">พบปัญหาที่กระบวนการ</label>
                                            <select class="form-control" name="ms_processtype_name">
                                                <option value="{{$hd->ms_processtype_name}}">{{$hd->ms_processtype_name}}</option>    
                                                @foreach ($process as $item)
                                                    <option value="{{$item->ms_processtype_name}}">{{$item->ms_processtype_name}}</option>
                                                @endforeach                                          
                                            </select>
                                        </div>
                                    </div>                                                                                             
                                </div>
                                <div class="row mt-2">                                  
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" name="iso_ncr_lists_problem">{{$hd->iso_ncr_lists_problem}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ไฟล์แนบ</label>
                                            <input class="form-control" type="file" name="iso_ncr_lists_file1">
                                            @if ($hd->iso_ncr_lists_file1)
                                                <a href="{{ asset($hd->iso_ncr_lists_file1) }}" target="_blank">
                                                    <i class="fas fa-file"></i>
                                                </a> 
                                            @endif 
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ไฟล์แนบ</label>
                                            <input class="form-control" type="file" name="iso_ncr_lists_file2">
                                            @if ($hd->iso_ncr_lists_file2)
                                                <a href="{{ asset($hd->iso_ncr_lists_file2) }}" target="_blank">
                                                    <i class="fas fa-file"></i>
                                                </a> 
                                            @endif 
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
                <h5>การแก้ไข-การป้องกัน (ผู้รับผิดชอบปัญหา)</h5>
                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="material_check"
                                    value="1"
                                    {{ $hd->material_check == 1 ? 'checked' : '' }}
                                >
                                วัตถุดิบ (Raw materials)
                            </label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="human_check"
                                    value="1"
                                    {{ $hd->human_check == 1 ? 'checked' : '' }}
                                >
                                พนักงาน (Human)
                            </label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="machinery_check"
                                    value="1"
                                    {{ $hd->machinery_check == 1 ? 'checked' : '' }}
                                >
                                เครื่องจักร (Machinery)
                            </label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="method_check"
                                    value="1"
                                    {{ $hd->method_check == 1 ? 'checked' : '' }}
                                >
                                วิธีการ (Methods)
                            </label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="environment_check"
                                    value="1"
                                    {{ $hd->environment_check == 1 ? 'checked' : '' }}
                                >
                                สิ่งแวดล้อม (Environment)
                            </label>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="other_check"
                                    value="1"
                                    {{ $hd->other_check == 1 ? 'checked' : '' }}
                                >
                                อื่นๆ (Others)
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">รายละเอียดของสาเหตุ :</label>
                            <textarea class="form-control" name="cause_remark">{{$hd->cause_remark}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <div class="form-group">
                            <label class="form-label">แนวทางป้องกัน :</label>
                            <textarea class="form-control" name="cause_prevent">{{$hd->cause_prevent}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้รับผิดชอบ</label>
                            <input class="form-control" type="text" name="cause_person" value="{{$hd->cause_person}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง</label>
                            <input class="form-control" type="text" name="cause_position" value="{{$hd->cause_position}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">กำหนดการป้องแล้วเสร็จ</label>
                            <input class="form-control" type="date" name="cause_persondate" value="{{$hd->cause_persondate}}">
                        </div>
                    </div>
                </div>          
                    <div class="row mt-2">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">ผู้อนุมัติ</label>
                                <input class="form-control" type="text" name="cause_approved" value="{{$hd->cause_approved}}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">ตำแหน่ง</label>
                                <input class="form-control" type="text" name="cause_approvedposition" value="{{$hd->cause_approvedposition}}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">วันที่</label>
                                <input class="form-control" type="date" name="cause_approveddate" value="{{$hd->cause_approveddate}}">
                            </div>
                        </div>
                    </div> 
                <h6>หมายเหตุ : เมื่อทางแผนกผู้รับผิดชอบปัญหา ได้รับเอกสารใบ NCR กรุณาระบุสาเหตุ-การป้องกัน และตอบกลับมายังฝ่ายควบคุมคุณภาพภายใน 7 วัน</h6>  
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>การดำเนินการแก้ไขกับผลิตภัณฑ์</h5>
                <div class="row mt-2">
                     <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="rework_check"
                                    value="1"
                                    {{ $hd->rework_check == 1 ? 'checked' : '' }}
                                >
                                แก้ไข (Rework)
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="rework_qty" value="{{$hd->rework_qty}}">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label class="form-label">วิธีการแก้ไข</label>
                            <input class="form-control" type="text" name="rework_correct" value="{{$hd->rework_correct}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                     <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="reprocess_check"
                                    value="1"
                                    {{ $hd->reprocess_check == 1 ? 'checked' : '' }}
                                >
                                แก้ไข (Reprocess)
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="reprocess_qty" value="{{$hd->reprocess_qty}}">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label class="form-label">วิธีการแก้ไข</label>
                            <input class="form-control" type="text" name="reprocess_correct" value="{{$hd->reprocess_correct}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="acceptance_check"
                                    value="1"
                                    {{ $hd->acceptance_check == 1 ? 'checked' : '' }}
                                >
                                ยอมรับกรณีพิเศษ
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="acceptance_qty" value="{{$hd->acceptance_qty}}">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label class="form-label">เหตุผลในการยอมรับ</label>
                            <input class="form-control" type="text" name="acceptance_correct" value="{{$hd->acceptance_correct}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="reject_check"
                                    value="1"
                                    {{ $hd->reject_check == 1 ? 'checked' : '' }}
                                >
                                ส่งคืน(Reject)
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="reject_qty" value="{{$hd->reject_qty}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="return_check"
                                    value="1"
                                    {{ $hd->return_check == 1 ? 'checked' : '' }}
                                >
                                คัดแยกของเสียเพื่อส่งคืน
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="return_qty" value="{{$hd->return_qty}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="scrap_check"
                                    value="1"
                                    {{ $hd->scrap_check == 1 ? 'checked' : '' }}
                                >
                                ทำลาย(Scrap)
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="scrap_qty" value="{{$hd->scrap_qty}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="change_check"
                                    value="1"
                                    {{ $hd->change_check == 1 ? 'checked' : '' }}
                                >
                                เปลี่ยนสินค้าใหม่
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="change_qty" value="{{$hd->change_qty}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">ผู้รับผิดชอบ</label>
                            <input class="form-control" type="text" name="corrective_person" value="{{$hd->corrective_person}}" >
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง</label>
                            <input class="form-control" type="text" name="corrective_position" value="{{$hd->corrective_position}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">ดำเนินการวันที่</label>
                            <input class="form-control" type="date" name="corrective_date" value="{{$hd->corrective_date}}">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">แล้วเสร็จวันที่</label>
                            <input class="form-control" type="date" name="corrective_duedate" value="{{$hd->corrective_duedate}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้อนุมัติ</label>
                            <input class="form-control" type="text" name="corrective_approved" value="{{$hd->corrective_approved}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง</label>
                            <input class="form-control" type="text" name="corrective_approvedposition" value="{{$hd->corrective_approvedposition}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่</label>
                            <input class="form-control" type="date" name="corrective_approveddate" value="{{$hd->corrective_approveddate}}">
                        </div>
                    </div>
                </div>               
            </div>
        </div>
         <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <h4 class="text-center">เอกสารแนบปิด NCR</h4>
                    <h5 class="text-center">การติดตามแนวทางป้องกัน</h5>
                     <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">จากการติดตามแนวทางป้องกันสรุปได้ว่า</label>
                                <textarea class="form-control" rows="10" name="following_note">{{$hd->following_note}}</textarea>
                            </div>
                        </div>                    
                    </div>
                    <div class="row mt-2">   
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">ไฟล์แนบ</label>
                                <input class="form-control" type="file" name="following_file">
                                @if ($hd->following_file)
                                    <a href="{{ asset($hd->following_file) }}" target="_blank">
                                        <i class="fas fa-file"></i>
                                    </a> 
                                @endif 
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">ลงชื่อผู้บันทึก</label>
                                <input class="form-control" type="text" name="following_person" value="{{$hd->following_person}}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">วันที่</label>
                                <input class="form-control" type="date" name="following_date" value="{{$hd->following_date}}">
                            </div>
                        </div> 
                    </div>
                    <hr>
                    <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-between align-items-center mb-2">
                        <h5 class="my-0">เอกสารแนบ: รายงานผลิตภัณฑ์ที่ไม่เป็นไปตามข้อกำหนด (Non-conformity Report : NCR)</h5>
                        <button type="button" class="btn btn-success btn-sm" id="addNcrRowBtn">
                            <i class="fas fa-plus me-1"></i> เพิ่มรายการผลิตภัณฑ์ NCR
                        </button>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-centered align-middle" id="ncrTable">
                                <thead class="table-light text-center">
                                    <tr>
                                        <th style="width: 5%;">ลำดับ</th>
                                        <th style="width: 25%;">ชื่อผลิตภัณฑ์</th>
                                        <th style="width: 15%;">รหัสผลิตภัณฑ์</th>
                                        <th style="width: 15%;">Lot/Batch No</th>
                                        <th style="width: 15%;">จำนวนทั้งหมด</th>
                                        <th style="width: 20%;">หมายเหตุ</th>
                                        <th style="width: 5%;">ลบ</th>
                                    </tr>
                                </thead>
                                <tbody id="ncrTableBody">
                                    @if(count($dt) > 0)
                                        @foreach ($dt as $key => $item)
                                        <tr>
                                            <td class="text-center ncr-row-number">
                                                {{$key + 1}}
                                                <input type="hidden" name="iso_ncr_products_id[{{$key}}]" value="{{$item->iso_ncr_products_id}}">
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" name="following_productname[{{$key}}]" value="{{$item->following_productname}}" required >
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" name="following_productcode[{{$key}}]" value="{{$item->following_productcode}}" required >
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" name="following_productlot[{{$key}}]" value="{{$item->following_productlot}}" >
                                            </td>
                                            <td>
                                                <input class="form-control form-control-sm" type="text" name="following_productqty[{{$key}}]" value="{{$item->following_productqty}}">
                                            </td>
                                            <td>
                                                <textarea class="form-control form-control-sm" rows="1" name="following_productnote[{{$key}}]">{{$item->following_productnote}}</textarea>
                                            </td>
                                            <td class="text-center">
    
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->iso_ncr_products_id }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        @if ($hd->status == 4)
                                        <tr>
                                            <td class="text-center ncr-row-number">1</td>
                                            <td><input class="form-control form-control-sm" type="text" name="following_productname[0]" required></td>
                                            <td><input class="form-control form-control-sm" type="text" name="following_productcode[0]" required></td>
                                            <td><input class="form-control form-control-sm" type="text" name="following_productlot[0]"></td>
                                            <td><input class="form-control form-control-sm" type="text" name="following_productqty[0]"></td>
                                            <td><textarea class="form-control form-control-sm" rows="1" name="following_productnote[0]"></textarea></td>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-secondary btn-sm" disabled><i class="fas fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endif
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                    {{-- <div class="row mt-2">
                        <h5 class="text-center">เอกสารแนบ:รายงานผลิตภัณฑ์ที่ไม่เป็นไปตามข้อกำหนด (Non-conformity Report :NCR)</h5>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">ชื่อผลิตภัณฑ์</label>
                                <input class="form-control" type="text" name="following_productname" value="{{$hd->following_productname}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">รหัสผลิตภัณฑ์</label>
                                <input class="form-control" type="text" name="following_productcode" value="{{$hd->following_productcode}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Lot/Batch No</label>
                                <input class="form-control" type="text" name="following_productlot" value="{{$hd->following_productlot}}">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">จำนวนทั้งหมด</label>
                                <input class="form-control" type="text" name="following_productqty" value="{{$hd->following_productqty}}">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-label">หมายเหตุ</label>
                                <textarea class="form-control" rows="3" name="following_productnote">{{$hd->following_productnote}}</textarea>
                            </div>
                        </div>
                    </div>                      --}}
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>การตรวจติดตามและการปิด NCR</h5>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="accept_proposed1"
                                    value="1"
                                    {{ $hd->accept_proposed1 == 1 ? 'checked' : '' }}
                                >
                                ยอมรับแนวทางการแก้ไข/ป้องกัน
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="accept_proposed2"
                                    value="1"
                                    {{ $hd->accept_proposed2 == 1 ? 'checked' : '' }}
                                >
                                ไม่ยอมรับแนวทางการแก้ไข/ป้องกัน ครั้งที่ 1
                            </label>
                            <input class="form-control" type="text" name="accept_proposed2_note" value="{{$hd->accept_proposed2_note}}" >
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name="accept_proposed3"
                                    value="1"
                                    {{ $hd->accept_proposed3 == 1 ? 'checked' : '' }}
                                >
                                ไม่ยอมรับแนวทางการแก้ไข/ป้องกัน ครั้งที่ 2
                            </label>
                            <input class="form-control" type="text" name="accept_proposed3_note" value="{{$hd->accept_proposed3_note}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">ผู้ตรวจติดตาม</label>
                            <input class="form-control" type="text" name="proposed_person" value="{{$hd->proposed_person}}">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">ผู้อนุมัติปิดการตรวจติดตาม</label>
                            <input class="form-control" type="text" name="proposed_approved" value="{{$hd->proposed_approved}}">
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
const ncrTbody = document.getElementById('ncrTableBody');

function updateNcrRowNumbers() {
    if (!ncrTbody) return;
    ncrTbody.querySelectorAll('tr').forEach((row, index) => {
        const numberTd = row.querySelector('.ncr-row-number');
        if (numberTd) numberTd.textContent = index + 1;
    });
}

const addBtn = document.getElementById('addNcrRowBtn');
if (addBtn && ncrTbody) {
    addBtn.addEventListener('click', function () {
        const uniqueIndex = Date.now();
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="text-center ncr-row-number">
                <input type="hidden" name="iso_ncr_products_id[${uniqueIndex}]" value="0">
            </td>
            <td><input class="form-control form-control-sm" type="text" name="following_productname[${uniqueIndex}]" required></td>
            <td><input class="form-control form-control-sm" type="text" name="following_productcode[${uniqueIndex}]" required></td>
            <td><input class="form-control form-control-sm" type="text" name="following_productlot[${uniqueIndex}]"></td>
            <td><input class="form-control form-control-sm" type="text" name="following_productqty[${uniqueIndex}]"></td>
            <td><textarea class="form-control form-control-sm" rows="1" name="following_productnote[${uniqueIndex}]"></textarea></td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm deleteNcrRow">
                    <i class="fas fa-trash"></i>
                </button>
            </td>
        `;
        ncrTbody.appendChild(newRow);
        updateNcrRowNumbers();
    });

    ncrTbody.addEventListener('click', function (e) {
        const btn = e.target.closest('.deleteNcrRow');
        if (btn) {
            btn.closest('tr').remove();
            updateNcrRowNumbers();
        }
    });
}

confirmDel = (refid) => {
    Swal.fire({
        title: 'คุณแน่ใจหรือไม่ !',
        text: 'คุณต้องการลบรายการนี้หรือไม่ ?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger',
        buttonsStyling: false
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: '{{ url("/confirmDelNcrProduct") }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'refid': refid,
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({ title: 'สำเร็จ', text: 'ยกเลิกรายการเรียบร้อยแล้ว', icon: 'success' })
                            .then(function() { location.reload(); });
                    } else {
                        Swal.fire({ title: 'ไม่สำเร็จ', text: 'ยกเลิกรายการไม่สำเร็จ', icon: 'error' });
                    }
                },
                error: function() {
                    Swal.fire({ title: 'ไม่สำเร็จ', text: 'ยกเลิกรายการไม่สำเร็จ', icon: 'error' });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({ title: 'ยกเลิก', text: 'โปรดตรวจสอบข้อมูลอีกครั้งเพื่อความถูกต้อง :)', icon: 'error' });
        }
    });
}
</script>
@endsection