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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>บัญชีรายชื่อเครื่องมือวัด</h5>
                            </div>
                            <form class="custom-validation" action="{{ route('clb-measuringlist.update',$hd->clb_measuring_lists_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ลำดับ</label>
                                            <input class="form-control" type="number" name="clb_measuring_lists_listno" value="{{$hd->clb_measuring_lists_listno}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">หมายเลขเครื่องมือวัด</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_code" value="{{$hd->clb_measuring_lists_code}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อเครื่องมือวัด</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_name" value="{{$hd->clb_measuring_lists_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ยี่ห้อ</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_brand" value="{{$hd->clb_measuring_lists_brand}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">รุ่น(Model)</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_model" value="{{$hd->clb_measuring_lists_model}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">Serial No</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_serialno" value="{{$hd->clb_measuring_lists_serialno}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ฝ่าย/แผนกที่ใช้งาน/จุดประจำ</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_department" value="{{$hd->clb_measuring_lists_department}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ช่วงใช้งานจริง</label>
                                            <input class="form-control" type="text" name="actualuseperiod" value="{{$hd->actualuseperiod}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ความละเอียด</label>
                                            <input class="form-control" type="text" name="resolution" value="{{$hd->resolution}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เกณฑ์ยอมรับ</label>
                                            <input class="form-control" type="text" name="acceptancecriteria" value="{{$hd->acceptancecriteria}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เริ่มใช้งาน</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_start" value="{{$hd->clb_measuring_lists_start}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">หมายเลขเอกสารคู่มือ</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_note"  value="{{$hd->clb_measuring_lists_note}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_remark" value="{{$hd->clb_measuring_lists_remark}}">
                                        </div>
                                    </div>
                                </div>
                                  <div class="row mt-3">
                                    <div class="col-6">
                                            <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid clb_measuring_lists_file1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2">
                                                        <a href="#" target="_blank" class="text-dark">รูปภาพ</a>
                                                        @if ($hd->clb_measuring_lists_file1)
                                                            <a href="{{ asset($hd->clb_measuring_lists_file1) }}" target="_blank">
                                                                <i class="fas fa-file"></i>
                                                            </a> 
                                                        @endif
                                                    </h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="clb_measuring_lists_file1" onchange="prevFile(this,'clb_measuring_lists_file1')" accept="image/*">
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
                                                    <img src="" class="img-fluid clb_measuring_lists_file2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2">
                                                        <a href="#" target="_blank" class="text-dark">ใบรับประกัน</a>
                                                        @if ($hd->clb_measuring_lists_file2)
                                                            <a href="{{ asset($hd->clb_measuring_lists_file2) }}" target="_blank">
                                                                <i class="fas fa-file"></i>
                                                            </a> 
                                                        @endif
                                                    </h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="clb_measuring_lists_file2" onchange="prevFile(this,'clb_measuring_lists_file2')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
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
                                                    <img src="" class="img-fluid clb_measuring_lists_file3" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2">
                                                        <a href="#" target="_blank" class="text-dark">คู่มือ</a>
                                                        @if ($hd->clb_measuring_lists_file3)
                                                            <a href="{{ asset($hd->clb_measuring_lists_file3) }}" target="_blank">
                                                                <i class="fas fa-file"></i>
                                                            </a> 
                                                        @endif
                                                    </h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile03"  name="clb_measuring_lists_file3" onchange="prevFile(this,'clb_measuring_lists_file3')">
                                                <label class="input-group-text" for="inputGroupFile03">Upload</label>
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
                                                    <img src="" class="img-fluid clb_measuring_lists_file4" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2">
                                                        <a href="#" target="_blank" class="text-dark">เอกสารการซื้อ</a>
                                                        @if ($hd->clb_measuring_lists_file4)
                                                            <a href="{{ asset($hd->clb_measuring_lists_file4) }}" target="_blank">
                                                                <i class="fas fa-file"></i>
                                                            </a> 
                                                        @endif
                                                    </h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile04"  name="clb_measuring_lists_file4" onchange="prevFile(this,'clb_measuring_lists_file4')">
                                                <label class="input-group-text" for="inputGroupFile04">Upload</label>
                                                </div>
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
                                    <hr>
                                    <table class="table table-striped mb-0 text-center table-sm table-bordered">
                                        <thead>
                                                    <tr>
                                                        <th rowspan="2" >#</th>
                                                        <th rowspan="2" >วันที่</th>
                                                        <th rowspan="2" >รายละเอียด</th>
                                                        <th rowspan="2" >ระยะเวลา</th>
                                                        <th colspan="4" >ประเภท</th>
                                                        <th rowspan="2" >ผู้รับผิดชอบ</th>
                                                        <th rowspan="2" >ผู้ตรวจสอบ</th>
                                                        <th rowspan="2" >จุดประจำห้อง</th>
                                                        <th rowspan="2" >สถานะ</th>
                                                        <th rowspan="2" >หมายเหตุ</th>
                                                        <th rowspan="2" ></th>
                                                    </tr>
                                                    <tr>
                                                        <th>Calibate</th>
                                                        <th>Cert No.</th>
                                                        <th>ซ่อมบำรุง</th>
                                                        <th>เลขใบแจ้งซ่อม</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableBody">
                                                    @foreach ($list as $item)
                                                        <tr>
                                                            <td>
                                                                <span class="row-number">{{ $loop->iteration }}</span>
                                                                <input type="hidden" name="clb_measuring_records_id[]" value="{{$item->clb_measuring_records_id}}">
                                                                <input
                                                                type="hidden"
                                                                name="clb_measuring_records_listno[]"
                                                                class="row-number-hidden"
                                                                value="{{ $item->clb_measuring_records_listno }}">
                                                            </td>
                                                            <td>
                                                                <input type="date" class="form-control" name="clb_measuring_records_date[]" value="{{$item->clb_measuring_records_date}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_remark[]" value="{{$item->clb_measuring_records_remark}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_timeline[]" value="{{$item->clb_measuring_records_timeline}}">
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="clb_measuring_records_calibate[]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox m-0"
                                                                    name="clb_measuring_records_calibate[]"
                                                                    value="1"
                                                                    {{ $item->clb_measuring_records_calibate == 1 ? 'checked' : '' }}>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_certno[]" value="{{$item->clb_measuring_records_certno}}">
                                                            </td>
                                                            <td>
                                                                <input type="hidden" name="clb_measuring_records_repaircheck[]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox m-0"
                                                                    name="clb_measuring_records_repaircheck[]"
                                                                    value="1"
                                                                    {{ $item->clb_measuring_records_repaircheck == 1 ? 'checked' : '' }}>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_repairdocu[]" value="{{$item->clb_measuring_records_repairdocu}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_person[]" value="{{$item->clb_measuring_records_person}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_review[]" value="{{$item->clb_measuring_records_review}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_location[]" value="{{$item->clb_measuring_records_location}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_status[]" value="{{$item->clb_measuring_records_status}}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control" name="clb_measuring_records_note[]" value="{{$item->clb_measuring_records_note}}">
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->clb_measuring_records_id }}')"><i class="fas fa-trash"></i></a>   
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>       
                                    </table>
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
@endsection
@section('script')
<script>
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        row.querySelector('.row-number').textContent = index + 1;
        row.querySelector('.row-number-hidden').value = index + 1;
    });
}
document.getElementById('addRowBtn').addEventListener('click', function () {
        const tbody = document.getElementById('tableBody');

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <span class="row-number"></span>
                <input type="hidden" name="clb_measuring_records_listno[]" class="row-number-hidden"/>
                <input type="hidden" name="clb_measuring_records_id[]" value="0">
            </td>
            <td><input type="date" name="clb_measuring_records_date[]" class="form-control"/></td>
            <td><input type="text" name="clb_measuring_records_remark[]" class="form-control"/></td>
            <td><input type="text" name="clb_measuring_records_timeline[]" class="form-control"/></td>
            <td><input type="checkbox" name="clb_measuring_records_calibate[]" class="form-check-input scale-checkbox m-0"/></td>
            <td><input type="text" name="clb_measuring_records_certno[]" class="form-control"/></td>
            <td><input type="checkbox" name="clb_measuring_records_repaircheck[]" class="form-check-input scale-checkbox m-0"/></td>
            <td><input type="text" name="clb_measuring_records_repairdocu[]" class="form-control"/></td>
            <td><input type="text" name="clb_measuring_records_person[]" class="form-control"/></td>
            <td><input type="text" name="clb_measuring_records_review[]" class="form-control"/></td>
            <td><input type="text" name="clb_measuring_records_location[]" class="form-control"/></td>
            <td><input type="text" name="clb_measuring_records_status[]" class="form-control"/></td>
            <td><input type="text" name="clb_measuring_records_note[]" class="form-control"/></td>
            <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
        `;

        tbody.appendChild(newRow);
        updateRowNumbers(); 
});
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers(); // อัปเดตลำดับหลังจากลบ
    }
});
confirmDel = (refid) =>{
Swal.fire({
    title: 'คุณแน่ใจหรือไม่ !',
    text: `คุณต้องการลบรายการนี้หรือไม่ ?`,
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
            url: `{{ url('/confirmDelMeasuringrec') }}`,
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "refid": refid,               
            },           
            dataType: "json",
            success: function(data) {
                // console.log(data);
                if (data.status == true) {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ยกเลิกรายการเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกรายการไม่สำเร็จ',
                        icon: 'error'
                    });
                }
               
            },
            error: function(data) {
                Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกรายการไม่สำเร็จ',
                        icon: 'error'
                    });            }
        });

    } else if ( // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
            title: 'ยกเลิก',
            text: 'โปรดตรวจสอบข้อมูลอีกครั้งเพื่อความถูกต้อง :)',
            icon: 'error'
        });
    }
});
}
</script>
@endsection