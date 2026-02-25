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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>
                                        แผนการตรวจสอบน้ำใช้ในโรงงาน (Water Quality Testing Plan)
                                    </h5>                              
                            </div>
                            <form class="custom-validation" action="{{ route('iso-waterqualityplan.store') }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ปี</label>
                                            <select class="form-control" name="iso_water_quality_plans_date">
                                            @for ($i = date('Y'); $i >= 2025; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3"> 
                                    <div class="col-12" style="text-align: right;">
                                        <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                                    </div>
                                    <hr>
                                    <div class="col-12">
                                        <div class="table-responsive">
                                        <table class="table table-bordered dt-responsive nowrap w-100 text-center table-sm">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="width:5%">ลำดับ</th>
                                                    <th rowspan="2" style="width:10%">สถานที่</th>
                                                    <th rowspan="2" style="width:10%">บริเวณจุดเก็บน้ำ</th>
                                                    <th colspan="12">เดือน</th>
                                                    <th rowspan="2" style="width:10%">ผู้รับผิดชอบ</th>
                                                    <th rowspan="2" style="width:10%">ผู้ทวนสอบ</th>
                                                    <th rowspan="2" style="width:10%">หมายเหตุ</th>
                                                    <th rowspan="2"></th>
                                                </tr>
                                                <tr>
                                                    <!-- เดือน -->
                                                    <th style="width:5%">Jan</th>
                                                    <th style="width:5%">Feb</th>
                                                    <th style="width:5%">Mar</th>
                                                    <th style="width:5%">Apr</th>
                                                    <th style="width:5%">May</th>
                                                    <th style="width:5%">Jun</th>
                                                    <th style="width:5%">Jul</th>
                                                    <th style="width:5%">Aug</th>
                                                    <th style="width:5%">Sep</th>
                                                    <th style="width:5%">Oct</th>
                                                    <th style="width:5%">Nov</th>
                                                    <th style="width:5%">Dec</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tableBody"> </tbody>
                                        </table>
                                        </div>                                        
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
                <input type="hidden" name="iso_water_quality_plans_listno[]" class="row-number-hidden"/>
            </td>
            <td><input type="text" name="iso_water_quality_plans_location[]" class="form-control"/></td>
            <td><input type="text" name="iso_water_quality_plans_area[]" class="form-control"/></td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_jan[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_feb[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_mar[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_apr[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_may[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_jun[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_jul[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_aug[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_sep[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_oct[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_nov[]"
                    value="1">
                </div>
            </td>
            <td>
                <div class="form-check d-flex justify-content-center">
                    <input type="checkbox" 
                    class="form-check-input scale-checkbox" 
                    name="plan_dec[]"
                    value="1">
                </div>
            </td>
            <td><input type="text" name="iso_water_quality_plans_person[]" class="form-control"/></td>
            <td><input type="text" name="iso_water_quality_plans_review[]" class="form-control"/></td>
            <td><input type="text" name="iso_water_quality_plans_remark[]" class="form-control"/></td>
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