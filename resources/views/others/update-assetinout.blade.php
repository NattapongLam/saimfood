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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบนำทรัพย์สินออกนอกบริษัท</h5>                               
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="custom-validation" action="{{ route('asset-inout.update',$hd->assetinout_hd_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf 
                            @method('PUT')   
                            <input type="hidden" name="checkdoc" value="Update">
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label">วันที่</label>
                                    <input class="form-control" type="date" name="assetinout_hd_date" value="{{$hd->assetinout_hd_date }}" readonly>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">เลขที่</label>
                                    <input class="form-control" type="text" name="assetinout_hd_docuno" value="{{$hd->assetinout_hd_docuno}}" readonly>
                                    <input type="hidden" name="assetinout_hd_docunum" value="{{$hd->assetinout_hd_docunum}}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label">คู่ค้า</label>
                                    <input class="form-control" type="text" name="assetinout_hd_vendor" value="{{$hd->assetinout_hd_vendor}}"  readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label">ผู้ติดต่อ</label>
                                    <input class="form-control" type="text" name="assetinout_hd_contact" value="{{$hd->assetinout_hd_contact}}" readonly>
                                </div>
                                <div class="col-3">
                                    <label class="form-label">เบอร์โทร</label>
                                    <input class="form-control" type="text" name="assetinout_hd_tel" value="{{$hd->assetinout_hd_tel}}" readonly>
                                </div>
                                <div class="col-6">
                                    <label class="form-label">หมายเหตุ</label>
                                    <input class="form-control" type="text" name="assetinout_hd_note" value="{{$hd->assetinout_hd_note}}" readonly>
                                </div>
                            </div>
                            <div class="row">
                                @if ($hd->assetinout_hd_file1)
                                <div class="col-6">
                                    <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid assetinout_hd_file1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->assetinout_hd_file1) }}" target="_blank" class="text-dark">ไฟล์แนบ</a></h5>                                   
                                                {{-- <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="assetinout_hd_file1" onchange="prevFile(this,'assetinout_hd_file1')">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                </div>
                                                </div> --}}
                                                </div>
                                    </div>        
                                </div>  
                                @endif
                                @if ($hd->assetinout_hd_file2)
                                <div class="col-6">
                                            <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid assetinout_hd_file2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->assetinout_hd_file2) }}" target="_blank" class="text-dark">ไฟล์แนบ</a></h5>                                   
                                                {{-- <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="assetinout_hd_file2" onchange="prevFile(this,'assetinout_hd_file2')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div>
                                                </div> --}}
                                                </div>
                                            </div>
                                </div>  
                                @endif
                               
                            </div>
                            <div class="row">
                                    {{-- <div class="col-12" style="text-align: right;">
                                        <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                                    </div> --}}
                                    <table class="table table-striped mb-0 text-center">
                                        <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รายละเอียด</th>
                                                        <th>จำนวน</th>
                                                        <th>หมายเหตุ</th>
                                                        {{-- <th></th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dt as $item)
                                                        <tr>
                                                            <td>
                                                                {{$item->assetinout_dt_listno}}
                                                                <input type="hidden" name="assetinout_dt_id[]" value="{{$item->assetinout_dt_id}}">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="assetinout_dt_name[]" value="{{$item->assetinout_dt_name}}" readonly>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="assetinout_dt_qty[]" value="{{$item->assetinout_dt_qty}}" readonly>
                                                            </td>
                                                            <td>
                                                                <input class="form-control" name="assetinout_dt_note[]" value="{{$item->assetinout_dt_note}}" readonly>
                                                            </td>
                                                            {{-- <td>
                                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->assetinout_dt_id }}')"><i class="fas fa-trash"></i></a>  
                                                            </td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                                <tbody id="tableBody">
                                                </tbody>       
                                    </table>
                            </div> 
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">สถานะ</label>
                                    <select class="form-control" name="assetinout_statuses_id">
                                        @foreach ($sta as $item)
                                            <option value="{{$item->assetinout_statuses_id}}">{{$item->assetinout_statuses_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">หมายเหตุ</label>
                                    <textarea class="form-control" name="approved_remark"></textarea>
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
                <input type="hidden" name="assetinout_dt_listno[]" class="row-number-hidden"/>
            </td>
            <td><input type="text" name="assetinout_dt_name[]" class="form-control"/></td>
            <td><input type="text" name="assetinout_dt_qty[]" class="form-control"/></td>
            <td><input type="text" name="assetinout_dt_note[]" class="form-control"/></td>
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
            url: `{{ url('/confirmDelAssetinoutDt') }}`,
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