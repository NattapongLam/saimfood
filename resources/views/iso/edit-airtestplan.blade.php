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
                                         แผนตรวจหาแบคทีเรียในอากาศ (Test Kit Microbial Compact Dry TC)
                                    </h5>                              
                            </div>
                            <form class="custom-validation" action="{{ route('iso-airtestplan.update',$list->iso_airtest_plans_date) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ปี</label>
                                            <select class="form-control" name="iso_airtest_plans_date">
                                            @for ($i = date('Y'); $i >= 2025; $i--)
                                                <option value="{{ $i }}" {{ old('iso_airtest_plans_date', $list->iso_airtest_plans_date ?? '') == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
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
                                                    <th rowspan="2" style="width:3%">ลำดับ</th>
                                                    <th rowspan="2" style="width:10%">รายละเอียด</th>
                                                    <th rowspan="2" style="width:10%">ความถี่</th>
                                                    <th colspan="12">เดือน</th>
                                                    <th rowspan="2" style="width:10%">ผู้รับผิดชอบ</th>
                                                    <th rowspan="2" style="width:10%">ผู้ทวนสอบ</th>
                                                    <th rowspan="2" style="width:3%"></th>
                                                </tr>
                                                <tr>
                                                    <!-- เดือน -->
                                                    <th style="width:3%">Jan</th>
                                                    <th style="width:3%">Feb</th>
                                                    <th style="width:3%">Mar</th>
                                                    <th style="width:3%">Apr</th>
                                                    <th style="width:3%">May</th>
                                                    <th style="width:3%">Jun</th>
                                                    <th style="width:3%">Jul</th>
                                                    <th style="width:3%">Aug</th>
                                                    <th style="width:3%">Sep</th>
                                                    <th style="width:3%">Oct</th>
                                                    <th style="width:3%">Nov</th>
                                                    <th style="width:3%">Dec</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tableBody">
                                                @foreach ($hd as $item)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                            <input type="hidden" 
                                                            name="iso_airtest_plans_listno[]" 
                                                            value="{{ $loop->iteration }}">
                                                            <input type="hidden" 
                                                            name="iso_airtest_plans_id[]" 
                                                            value="{{ $item->iso_airtest_plans_id }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="iso_airtest_plans_remark[]" 
                                                                value="{{ $item->iso_airtest_plans_remark }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="iso_airtest_plans_frequency[]" 
                                                                value="{{ $item->iso_airtest_plans_frequency }}">
                                                        </td>
                                                         <td>
                                                            <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][jan]" 
                                                                value="1"
                                                                {{ $item->plan_jan ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][feb]" 
                                                                value="1"
                                                                {{ $item->plan_feb ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][mar]" 
                                                                value="1"
                                                                {{ $item->plan_mar ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][apr]" 
                                                                value="1"
                                                                {{ $item->plan_apr ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][may]" 
                                                                value="1"
                                                                {{ $item->plan_may ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][jun]" 
                                                                value="1"
                                                                {{ $item->plan_jun ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                             <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][jul]" 
                                                                value="1"
                                                                {{ $item->plan_jul ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][aug]" 
                                                                value="1"
                                                                {{ $item->plan_aug ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][sep]" 
                                                                value="1"
                                                                {{ $item->plan_sep ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                             <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][oct]" 
                                                                value="1"
                                                                {{ $item->plan_oct ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                             <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][nov]" 
                                                                value="1"
                                                                {{ $item->plan_nov ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                             <input type="checkbox" 
                                                                class="form-check-input"
                                                                name="plans[{{ $loop->index }}][dec]" 
                                                                value="1"
                                                                {{ $item->plan_dec ? 'checked' : '' }}>
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="iso_airtest_plans_person[]" 
                                                                value="{{ $item->iso_airtest_plans_person }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="iso_airtest_plans_review[]" 
                                                                value="{{ $item->iso_airtest_plans_review }}">
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
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
        const numberSpan = row.querySelector('.row-number');
        const numberHidden = row.querySelector('.row-number-hidden');

        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }

        if (numberHidden) {
            numberHidden.value = index + 1;
        }
    });
}
document.getElementById('addRowBtn').addEventListener('click', function () {
    const tbody = document.getElementById('tableBody');
    const index = tbody.querySelectorAll('tr').length;

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td>
            <span class="row-number"></span>
            <input type="hidden" name="iso_airtest_plans_listno[]" class="row-number-hidden"/>
            <input type="hidden" name="iso_airtest_plans_id[]" value="0">
        </td>

        <td><input type="text" name="iso_airtest_plans_remark[]" class="form-control"/></td>
        <td><input type="text" name="iso_airtest_plans_frequency[]" class="form-control"/></td>

        ${generateMonth('jan', index)}
        ${generateMonth('feb', index)}
        ${generateMonth('mar', index)}
        ${generateMonth('apr', index)}
        ${generateMonth('may', index)}
        ${generateMonth('jun', index)}
        ${generateMonth('jul', index)}
        ${generateMonth('aug', index)}
        ${generateMonth('sep', index)}
        ${generateMonth('oct', index)}
        ${generateMonth('nov', index)}
        ${generateMonth('dec', index)}

        <td><input type="text" name="iso_airtest_plans_person[]" class="form-control"/></td>
        <td><input type="text" name="iso_airtest_plans_review[]" class="form-control"/></td>
        <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
    `;

    tbody.appendChild(newRow);
    updateRowNumbers();
});

function generateMonth(month, index) {
    return `
        <td>
            <div class="form-check d-flex justify-content-center">
                <input type="hidden" name="plans[${index}][${month}]" value="0">
                <input type="checkbox" class="form-check-input"
                    name="plans[${index}][${month}]" value="1">
            </div>
        </td>
    `;
}
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers(); // อัปเดตลำดับหลังจากลบ
    }
});
</script>
@endsection