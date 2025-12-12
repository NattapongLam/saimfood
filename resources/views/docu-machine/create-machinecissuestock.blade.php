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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบรับอะไหล่</h5>                                
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="custom-validation" action="{{ route('machine-issue-docus.store') }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">วันที่</label>
                                        <input class="form-control" type="date" name="machine_issuestock_hd_date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">ผู้จำหน่าย</label>
                                        <input class="form-control" type="text" name="machine_issuestock_hd_vendor" required>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">ผู้ติดต่อ</label>
                                        <input class="form-control" type="text" name="machine_issuestock_hd_contact">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">เบอร์โทร</label>
                                        <input class="form-control" type="text" name="machine_issuestock_hd_tel">
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุ</label>
                                        <input class="form-control" type="text" name="machine_issuestock_hd_note">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-6">
                                            <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid machine_issuestock_hd_file1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">เอกสารแนบ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="machine_issuestock_hd_file1" onchange="prevFile(this,'machine_issuestock_hd_file1')">
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
                                                    <img src="" class="img-fluid machine_issuestock_hd_file2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">เอกสารแนบ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="machine_issuestock_hd_file2" onchange="prevFile(this,'machine_issuestock_hd_file2')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div>
                                                </div>
                                                </div>
                                            </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-12" style="text-align: right;">
                                        <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                                    </div>
                                    <table class="table table-striped mb-0 text-center">
                                        <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รหัสสินค้า</th>
                                                        <th>ชื่อสินค้า</th>
                                                        <th>หน่วยนับ</th>
                                                        <th>จำนวน</th>
                                                        <th>ราคาต่อหน่วย</th>
                                                        <th>หมายเหตุ</th>
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
function prevFile(input, elm) {
                if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.' + elm).attr('src', e.target.result);
                    file = input.files[0];
                }

                reader.readAsDataURL(input.files[0]);
            }
}
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
                <input type="hidden" name="machine_issuestock_dt_listno[]" class="row-number-hidden"/>
            </td>
            <td><input type="text" name="machine_issuestock_dt_code[]" class="form-control"/></td>
            <td><input type="text" name="machine_issuestock_dt_name[]" class="form-control"/></td>
            <td><input type="text" name="machine_issuestock_dt_unit[]" class="form-control"/></td>
            <td><input type="text" name="machine_issuestock_dt_qty[]" class="form-control"/></td>
            <td><input type="text" name="machine_issuestock_dt_price[]" class="form-control"/></td>
            <td><input type="text" name="machine_issuestock_dt_note[]" class="form-control"/></td>
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