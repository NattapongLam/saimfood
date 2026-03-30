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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบขอดำเนินการเอกสาร DOCUMENT ACTION REQUSEST (DAR)</h5>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('iso-darlist.update',$hd->iso_dar_lists_id) }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf  
                                @method('PUT')
                                <div class="row mt-2"> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ฝ่าย/แผนก</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_department" value="{{$hd->iso_dar_lists_department}}" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วัตถุประสงค์</label>
                                            <select class="form-select" name="iso_dar_lists_objective" required>
                                                <option value="{{$hd->iso_dar_lists_objective}}">{{$hd->iso_dar_lists_objective}}</option>
                                                <option value="จัดทำเอกสารใหม่">จัดทำเอกสารใหม่</option>
                                                <option value="แก้ไข/ปรับปรุงเอกสาร">แก้ไข/ปรับปรุงเอกสาร</option>
                                                <option value="ขอสำเนาเอกสารเพิ่ม">ขอสำเนาเอกสารเพิ่ม</option>
                                                <option value="ยกเลิกเอกสาร">ยกเลิกเอกสาร</option>
                                                <option value="อื่นๆ">อื่นๆ</option>
                                            </select>
                                            <br>
                                            <input class="form-control" type="text" name="objective_remark" value="{{$hd->objective_remark}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                          <div class="form-group">
                                            <label class="form-label">ประเภทเอกสาร</label>
                                            <select class="form-select" name="iso_dar_lists_docutype" required>
                                                <option value="{{$hd->iso_dar_lists_docutype}}">{{$hd->iso_dar_lists_docutype}}</option>
                                                <option value="คู่มือคุณภาพ (QM)">คู่มือคุณภาพ (QM)</option>
                                                <option value="แบบฟอร์ม (F)">แบบฟอร์ม (F)</option>
                                                <option value="ขั้นตอนการปฏิบัตงาน (QP)">ขั้นตอนการปฏิบัตงาน (QP)</option>
                                                <option value="SD - เอกสารสนับสนุนภายในของฝ่าย/แผนก">SD - เอกสารสนับสนุนภายในของฝ่าย/แผนก</option>
                                                <option value="WI (วิธีปฏิบัตงาน)">WI (วิธีปฏิบัตงาน)</option>
                                                <option value="SE - เอกสารสนับสนุนภายนอกของฝ่าย/แผนก">SE - เอกสารสนับสนุนภายนอกของฝ่าย/แผนก</option>
                                            </select>
                                            <br>
                                            <input class="form-control" type="text" name="docutype_remark" value="{{$hd->docutype_remark}}">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row mt-2">
                                    {{-- <div class="col-12" style="text-align: right;">
                                        <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                                    </div>
                                    <hr> --}}
                                    <table class="table table-bordered mb-0 text-center">
                                        <thead>
                                            <tr>
                                                <th rowspan="2">#</th>
                                                <th rowspan="2">
                                                    รหัสเอกสาร<br>
                                                    (Document No.)
                                                </th>
                                                <th colspan="2">
                                                    แก้ไขครั้งที่ (Revision no)
                                                </th>
                                                <th rowspan="2">ชื่อเอกสาร</th>
                                                <th rowspan="2"></th>
                                            </tr>
                                            <tr>
                                                <th>เก่า</th>
                                                <th>ใหม่</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tableBody">
                                            @foreach ($dt as $item)
                                            <tr>
                                                <td>
                                                    <span class="row-number">{{$item->iso_dar_subs_listno}}</span>
                                                    <input type="hidden"
                                                        name="iso_dar_subs_listno[]"
                                                        class="row-number-hidden"
                                                        value="{{$item->iso_dar_subs_listno}}">
                                                </td>

                                                <td>
                                                    <input class="form-control"
                                                        name="iso_dar_subs_code[]"
                                                        value="{{$item->iso_dar_subs_code}}">
                                                </td>

                                                <td>
                                                    <input class="form-control"
                                                        name="iso_dar_subs_rev1[]"
                                                        value="{{$item->iso_dar_subs_rev1}}">
                                                </td>

                                                <td>
                                                    <input class="form-control"
                                                        name="iso_dar_subs_rev2[]"
                                                        value="{{$item->iso_dar_subs_rev2}}">
                                                </td>

                                                <td>
                                                    <input class="form-control"
                                                        name="iso_dar_subs_name[]"
                                                        value="{{$item->iso_dar_subs_name}}">
                                                </td>

                                                <td>
                                                    {{-- <button type="button" class="btn btn-danger btn-sm deleteRow">
                                                        ลบ
                                                    </button> --}}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>      
                                    </table>
                                </div>
                                <br>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">เหตุผลที่ร้องขอ</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_reason" value="{{$hd->iso_dar_lists_reason}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">เอกสารแนบ</label>
                                            <input class="form-control" type="file" name="iso_dar_lists_file">
                                            @if ($hd->iso_dar_lists_file)
                                                <a href="{{ asset($hd->iso_dar_lists_file) }}" target="_blank">
                                                    <i class="fas fa-file"></i>
                                                </a> 
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ร้องขอ</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_person" value="{{$hd->iso_dar_lists_person}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input 
                                                class="form-control" 
                                                type="date" 
                                                name="iso_dar_lists_date"
                                                value="{{$hd->iso_dar_lists_date }}"
                                            >
                                        </div>
                                    </div>
                                </div> 
                                @if ($hd->approved_status == "รอทบทวน")
                                    <div class="row mt-2">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ทบทวน</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_reviewer" value="{{auth()->user()->name}}" readonly>
                                        </div>
                                    </div>                                  
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="iso_dar_lists_reviewerdate" value="{{ old('iso_dar_lists_date', date('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_reviewernote">
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
                                @elseif($hd->approved_status == "ทบทวนแล้ว")
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ทบทวน</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_reviewer" value="{{$hd->iso_dar_lists_reviewer}}" readonly>
                                        </div>
                                    </div>                                  
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="iso_dar_lists_reviewerdate" value="{{$hd->iso_dar_lists_reviewerdate}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_reviewernote" value="{{$hd->iso_dar_lists_reviewernote}}">
                                        </div>
                                    </div>
                                </div>               
                                <div class="row mt-2">
                                    <div class="col-4">
                                          <div class="form-group">
                                            <label class="form-label">การตัดสินใจของผู้อนุมัติ</label>
                                            <select class="form-select" name="approved_status">
                                                <option value="">กรุณาเลือก</option>
                                                <option value="อนุมัติ">อนุมัติ</option>
                                                <option value="ไม่อนุมัติ">ไม่อนุมัติ</option>
                                            </select>
                                            <br>
                                            <input class="form-control" type="text" name="approved_remark">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ลงชื่อผู้อนุมัติ</label>
                                            <input class="form-control" type="text" name="approved_by" value="{{auth()->user()->name}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="approved_date" value="{{ old('iso_dar_lists_date', date('Y-m-d')) }}">
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
                                            <label class="form-label">ผู้ทบทวน</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_reviewer" value="{{$hd->iso_dar_lists_reviewer}}" readonly>
                                        </div>
                                    </div>                                  
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="iso_dar_lists_reviewerdate" value="{{$hd->iso_dar_lists_reviewerdate}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="iso_dar_lists_reviewernote" value="{{$hd->iso_dar_lists_reviewernote}}">
                                        </div>
                                    </div>
                                </div>               
                                <div class="row mt-2">
                                    <div class="col-4">
                                          <div class="form-group">
                                            <label class="form-label">การตัดสินใจของผู้อนุมัติ</label>
                                            <select class="form-select" name="approved_status">
                                                <option value="{{$hd->approved_status}}">{{$hd->approved_status}}</option>
                                                <option value="อนุมัติ">อนุมัติ</option>
                                                <option value="ไม่อนุมัติ">ไม่อนุมัติ</option>
                                            </select>
                                            <br>
                                            <input class="form-control" type="text" name="approved_remark" value="{{$hd->approved_remark}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ลงชื่อผู้อนุมัติ</label>
                                            <input class="form-control" type="text" name="approved_by" value="{{$hd->approved_by}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="approved_date" value="{{ $hd->approved_date }}">
                                        </div>
                                    </div>
                                </div>
                                @endif                                                            
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <h5>สำหรับเจ้าหน้าที่ควบคุมเอกสาร</h5>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="form-group">
                            <label class="form-label">หมายเหตุ</label>
                            <input class="form-control" type="text" name="dc_remark" value="{{$hd->dc_remark}}">
                        </div>
                    </div>
                </div>              
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">DAR No.</label>
                            <input class="form-control" type="text" name="dc_ref1" value="{{$hd->dc_ref1}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                             <label class="form-label"></label>
                            <input class="form-control" type="text" name="dc_ref2" value="{{$hd->dc_ref2}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <h5>ชนิดของเอกสาร</h5>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่มีผลลังคับใช้</label>
                            <input class="form-control" type="date" name="effective_date1" value="{{$hd->effective_date1}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                             <label class="form-label"></label>
                            <input class="form-control" type="date" name="effective_date2" value="{{$hd->effective_date2}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <select class="form-select" name="docutype">
                                <option value="เอกสารควบคุม">เอกสารควบคุม</option>
                                <option value="เอกสารไม่ควบคุม">เอกสารไม่ควบคุม</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่เริ่มดำเนินการ</label>
                            <input class="form-control" type="date" name="start_date1" value="{{$hd->start_date1}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                             <label class="form-label"></label>
                            <input class="form-control" type="date" name="start_date2" value="{{$hd->start_date2}}">
                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-4">
                        <div class="form-group">
                            <label class="form-label">วันที่เอกสารดำเนินการแล้วเสร็จ</label>
                            <input class="form-control" type="date" name="dc_date" value="{{$hd->dc_date}}">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                             <label class="form-label">ลงชื่อผู้รับผิดชอบ (DC)</label>
                            <input class="form-control" type="text" name="dc_by" value="{{$hd->dc_by}}" readonly>
                        </div>
                    </div>
                </div>
                @if ($hd->approved_status == "อนุมัติ" || $hd->approved_status == "ไม่อนุมัติ")
                    <br>
                                <div class="form-group">
                                    <div class="d-flex flex-wrap gap-2 justify-content">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                            บันทึก
                                        </button>
                                    </div>
                                </div>
                                </form>
                @endif              
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
function updateRowNumbers() {

    const rows =
        document.querySelectorAll('#tableBody tr');

    rows.forEach((row, index) => {

        const no =
            index + 1;

        const span =
            row.querySelector('.row-number');

        const hidden =
            row.querySelector('.row-number-hidden');

        if(span)
            span.textContent = no;

        if(hidden)
            hidden.value = no;

    });

}

// initial run
updateRowNumbers();


document
.getElementById('addRowBtn')
.addEventListener('click', function () {

    const tbody =
        document.getElementById('tableBody');

    const newRow =
        document.createElement('tr');

    newRow.innerHTML = `
        <td>
            <span class="row-number"></span>
            <input type="hidden"
                   name="iso_dar_subs_listno[]"
                   class="row-number-hidden">
        </td>

        <td>
            <input type="text"
                   name="iso_dar_subs_code[]"
                   class="form-control">
        </td>

        <td>
            <input type="text"
                   name="iso_dar_subs_rev1[]"
                   class="form-control">
        </td>

        <td>
            <input type="text"
                   name="iso_dar_subs_rev2[]"
                   class="form-control">
        </td>

        <td>
            <input type="text"
                   name="iso_dar_subs_name[]"
                   class="form-control">
        </td>

        <td>
            <button type="button"
                    class="btn btn-danger btn-sm deleteRow">
                ลบ
            </button>
        </td>
    `;

    tbody.appendChild(newRow);

    updateRowNumbers();

});


document
.getElementById('tableBody')
.addEventListener('click', function (e) {

    if(
        e.target.classList.contains('deleteRow')
    ){

        e.target
        .closest('tr')
        .remove();

        updateRowNumbers();

    }

});
</script>
@endsection