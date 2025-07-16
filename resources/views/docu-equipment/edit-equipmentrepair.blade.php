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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งซ่อมลูกค้า เลขที่ : {{$case->customer_repair_docu_docuno}} สถานะ : {{$case->customer_repair_status_name}}</h5>
                                <div class="page-title-right">                                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="custom-validation" action="{{ route('equipment-repair.update',$case->customer_repair_docu_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf   
                            @method('PUT')  
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">ลูกค้า</label>
                                        <input class="form-control" value="{{$case->customer_fullname}}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">ที่อยู่</label>
                                        <input class="form-control" value="{{$case->customer_address}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">ผู้ติดต่อ</label>
                                        <input class="form-control" value="{{$case->contact_person}}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">เบอร์โทร</label>
                                        <input class="form-control" value="{{$case->contact_tel}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">รหัสอุปกรณ์</label>
                                        <input class="form-control" value="{{$case->equipment_code}}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">ชื่ออุปกรณ์</label>
                                        <input class="form-control" value="{{$case->equipment_name}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">รายละเอียดอาการเสีย</label>
                                        <textarea class="form-control" name="customer_repair_docu_case" rows="5" readonly>{{$case->customer_repair_docu_case}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h5>รายละเอียดรับงานซ่อม</h5>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">ความเห็นช่าง</label>
                                        <select class="form-select" name="person_result" required>
                                            <option value="เข้าซ่อมหน้างาน">เข้าซ่อมหน้างาน</option>
                                            <option value="นำเครื่องกลับมาซ่อม">นำเครื่องกลับมาซ่อม</option>
                                            <option value="เปลี่ยนเครื่องใหม่">เปลี่ยนเครื่องใหม่</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <label class="form-label">เพิ่มเติม</label>
                                        <input class="form-control" type="text" name="result_remark" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                 <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">วันที่จะดำเนินการเสร็จ</label>
                                        <input class="form-control"  type="date" name="person_date" required>
                                    </div>
                                 </div>
                                 <div class="col-9">
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุ</label>
                                        <input class="form-control"  type="text" name="person_note">
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
                                            <th>ชื่อร้าน</th> 
                                            <th>ค่าใช้จ่าย</th>                                                         
                                            <th>แนบไฟล์</th>                                                        
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableBody"></tbody>
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
        const listno = index + 1;
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
                    <input type="hidden" name="customer_repair_sub_listno[]" class="row-number-hidden"/>
                </td>
                <td><input type="text" name="customer_repair_sub_remark[]" class="form-control"/></td>               
                <td><input type="text" name="customer_repair_sub_vendor[]" class="form-control"/></td>
                <td><input type="text" name="customer_repair_sub_cost[]" value="0"  class="form-control"/></td>
                <td><input type="file" name="customer_repair_sub_file[]" class="form-control"/></td>
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