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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ตั้งค่าตรวจเช็คตามแผน</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">  
                                    <form class="custom-validation" action="{{ route('machine-planings.update',$hd->machine_planing_hd_id) }}" method="POST" enctype="multipart/form-data" validate>
                                    @csrf
                                    @method('PUT')                                      
                                    <div class="col-12"> 
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        เครื่องจักรและอุปกรณ์
                                                    </label>
                                                    <select class="select2 form-select" name="machine_code" required 
                                                        oninvalid="this.setCustomValidity('กรุณากรอกเครื่องจักรและอุปกรณ์')" 
                                                        oninput="this.setCustomValidity('')">
                                                        <option value="">กรุณาเลือก</option>
                                                        @foreach ($machine as $item)
                                                            <option value="{{$item->machine_code}}"
                                                                {{ $item->machine_code == $hd->machine_code ? 'selected' : '' }}>
                                                                {{$item->machine_code}}/{{$item->machine_name}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>                                          
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        หมายเหตุ
                                                    </label>
                                                </div>
                                                <textarea class="form-control" name="machine_planing_hd_note">{{$hd->machine_planing_hd_note}}</textarea>
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
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($hd->details->where('machine_planing_dt_flag', true) as $key => $item)
                                                        <tr>
                                                            <td>
                                                                {{$item->machine_planing_dt_listno}}
                                                                <input type="hidden" value="{{$item->machine_planing_dt_listno}}" name="machine_planing_dt_listno[]">
                                                                <input type="hidden" value="{{$item->machine_planing_dt_id}}" name="machine_planing_dt_id[]">
                                                            </td>
                                                            <td>
                                                                <input class="form-control" type="text" value="{{$item->machine_planing_dt_remark}}" name="machine_planing_dt_remark[]">                                                               
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->machine_planing_dt_id }}')"><i class="fas fa-trash"></i></a> 
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
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "เลือกเครื่องจักร",
        allowClear: true,
        width: '100%'
    });
});
let listNoStart = {{ $hd->details->where('machine_planing_dt_flag', true)->max('machine_planing_dt_listno') ?? 0 }};
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        const listno = listNoStart + index + 1;
        row.querySelector('.row-number').textContent = listno;
        row.querySelector('.row-number-hidden').value = listno;
    });
}
document.getElementById('addRowBtn').addEventListener('click', function () {
        const tbody = document.getElementById('tableBody');

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <span class="row-number"></span>
                <input type="hidden" name="machine_planing_dt_listno[]" class="row-number-hidden"/>
                <input type="hidden" value="0" name="machine_planing_dt_id[]">
            </td>
            <td><input type="text" name="machine_planing_dt_remark[]" class="form-control"/></td>
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
            url: `{{ url('/confirmDelMachinePlaning') }}`,
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