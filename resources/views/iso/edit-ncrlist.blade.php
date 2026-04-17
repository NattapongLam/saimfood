@extends('layouts.main')
@section('content')
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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบควบคุมใบ NCR (NCR Log Sheet)</h5>
                            </div>
                            <form class="custom-validation" action="{{ route('iso-ncrlist.update',$hd->iso_ncr_lists_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-2"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">วันที่ออก NCR</label>
                                            <input class="form-control" type="date" name="iso_ncr_lists_date" value="{{$hd->iso_ncr_lists_date}}" readonly>
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เลขที่ NCR</label>
                                            <input class="form-control" name="iso_ncr_lists_docuno" value="{{$hd->iso_ncr_lists_docuno}}" readonly>
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ถึงหน่วยงาน</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_to" value="{{$hd->iso_ncr_lists_to}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">สำเนา</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_copy" value="{{$hd->iso_ncr_lists_copy}}" readonly>
                                        </div>
                                    </div>                                                                                                                       
                                </div>
                                <div class="row mt-2">                                      
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ผู้พบปัญหา</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_person" value="{{$hd->iso_ncr_lists_person}}" readonly>
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">เลขที่ใบสั่งซื้อ/สั่งผลิต</label>
                                            <input class="form-control" name="iso_ncr_lists_refdocu" value="{{$hd->iso_ncr_lists_refdocu}}" readonly>
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">พบปัญหาที่กระบวนการ</label>
                                            <select class="form-control" name="ms_processtype_name" disabled>
                                                <option value="{{$hd->ms_processtype_name}}">{{$hd->ms_processtype_name}}</option>                                              
                                            </select>
                                        </div>
                                    </div>                                                                                             
                                </div>
                                <div class="row mt-2">                                  
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" name="iso_ncr_lists_problem" disabled>{{$hd->iso_ncr_lists_problem}}</textarea>
                                        </div>
                                    </div>
                                    @if ($hd->iso_ncr_lists_file1)
                                        <a href="{{ asset($hd->iso_ncr_lists_file1) }}" target="_blank">
                                            <i class="fas fa-file"></i>
                                        </a> 
                                    @endif 
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
                @if ($hd->status == 1)
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้รับผิดชอบ</label>
                            <input class="form-control" type="text" name="cause_person" value="{{auth()->user()->name}}" readonly>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง</label>
                            <input class="form-control" type="text" name="cause_position">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">กำหนดการป้องแล้วเสร็จ</label>
                            <input class="form-control" type="date" name="cause_persondate" value="{{ old('cause_persondate', date('Y-m-d')) }}">
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
                @else
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้รับผิดชอบ</label>
                            <input class="form-control" type="text" name="cause_person" value="{{$hd->cause_person}}" readonly>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง</label>
                            <input class="form-control" type="text" name="cause_position" value="{{$hd->cause_position}}" readonly>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">กำหนดการป้องแล้วเสร็จ</label>
                            <input class="form-control" type="date" name="cause_persondate" value="{{$hd->cause_persondate}}" readonly>
                        </div>
                    </div>
                </div>   
                @endif        
                @if ($hd->status == 2)
                    <div class="row mt-2">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">ผู้อนุมัติ</label>
                                <input class="form-control" type="text" name="cause_approved"  value="{{auth()->user()->name}}" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">ตำแหน่ง</label>
                                <input class="form-control" type="text" name="cause_approvedposition">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">วันที่</label>
                                <input class="form-control" type="date" name="cause_approveddate" value="{{ old('cause_persondate', date('Y-m-d')) }}">
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
                @else
                    <div class="row mt-2">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">ผู้อนุมัติ</label>
                                <input class="form-control" type="text" name="cause_approved" value="{{$hd->cause_approved}}" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">ตำแหน่ง</label>
                                <input class="form-control" type="text" name="cause_approvedposition" value="{{$hd->cause_approvedposition}}" readonly>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label">วันที่</label>
                                <input class="form-control" type="date" name="cause_approveddate" value="{{$hd->cause_approveddate}}" readonly>
                            </div>
                        </div>
                    </div>
                @endif     
                <h6>หมายเหตุ : เมื่อทางแผนกผู้รับผิดชอบปัญหา</h6>  
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
                                >
                                แก้ไข (Rework)
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="rework_qty">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label class="form-label">วิธีการแก้ไข</label>
                            <input class="form-control" type="text" name="rework_correct">
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
                                >
                                แก้ไข (Reprocess)
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control" type="text" name="reprocess_qty">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label class="form-label">วิธีการแก้ไข</label>
                            <input class="form-control" type="text" name="reprocess_correct">
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
                                    name=""
                                    value="1"
                                >
                                ยอมรับกรณีพิเศษ
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control">
                        </div>
                    </div>
                    <div class="col-7">
                        <div class="form-group">
                            <label class="form-label">เหตุผลในการยอมรับ</label>
                            <input class="form-control">
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
                                    name=""
                                    value="1"
                                >
                                ส่งคืน(Reject)
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name=""
                                    value="1"
                                >
                                คัดแยกของเสียเพื่อส่งคืน
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control">
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
                                    name=""
                                    value="1"
                                >
                                ทำลาย(Scrap)
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-check-label">
                                <input 
                                    class="form-check-input"
                                    type="checkbox"
                                    name=""
                                    value="1"
                                >
                                เปลี่ยนสินค้าใหม่
                            </label>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <label class="form-label">จำนวน</label>
                            <input class="form-control">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">ผู้รับผิดชอบ</label>
                            <input class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง</label>
                            <input class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">ดำเนินการวันที่</label>
                            <input class="form-control" type="date">
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group">
                            <label class="form-label">แล้วเสร็จวันที่</label>
                            <input class="form-control" type="date">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ผู้อนุมัติ</label>
                            <input class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">ตำแหน่ง</label>
                            <input class="form-control" type="text">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่</label>
                            <input class="form-control" type="date">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
</script>
@endsection