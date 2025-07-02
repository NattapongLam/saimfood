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
                                    <form class="custom-validation" action="{{ route('machine-planings.store') }}" method="POST" enctype="multipart/form-data" validate>
                                    @csrf                                    
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
                                                            <option value="{{$item->machine_code}}">{{$item->machine_code}}/{{$item->machine_name}}</option>
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
                                                <textarea class="form-control" name="machine_planing_hd_note"></textarea>
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
                <input type="hidden" name="machine_planing_dt_listno[]" class="row-number-hidden"/>
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
</script>
@endsection