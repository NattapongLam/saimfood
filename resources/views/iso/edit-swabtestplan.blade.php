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
                                          แผนการ Swab Test (Coliform bacteria)                
                                    </h5>                              
                            </div>
                            <form class="custom-validation" action="{{ route('iso-swabtestplan.update',$list->iso_swabtest_plans_date) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ปี</label>
                                            <select class="form-control" name="iso_swabtest_plans_date">
                                            @for ($i = date('Y'); $i >= 2025; $i--)
                                                <option value="{{ $i }}"
                                                    {{ old('iso_swabtest_plans_date', $list->iso_swabtest_plans_date ?? '') == $i ? 'selected' : '' }}>
                                                    {{ $i }}
                                                </option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3"> 
                                    {{-- <div class="col-12" style="text-align: right;">
                                        <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                                    </div>
                                    <hr> --}}
                                    <div class="col-12">
                                        <div class="table-responsive">
                                        <table class="table table-bordered nowrap w-100 text-center table-sm">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="width:5%">ลำดับ</th>
                                                    <th rowspan="2" style="min-width:250px;">พื้นที่</th>
                                                    <th rowspan="2" style="min-width:150px;">รายการ</th>
                                                    <th rowspan="2" style="min-width:80px;">จำนวน</th>
                                                    <th rowspan="2" style="min-width:120px;">ความถี่</th>
                                                    <th colspan="12">เดือน</th>
                                                    <th rowspan="2" style="min-width:200px;">ผู้รับผิดชอบ</th>
                                                    <th rowspan="2" style="min-width:200px;">ผู้ทวนสอบ</th>
                                                    <th rowspan="2">บันทึก</th>
                                                </tr>
                                                <tr>
                                                    <!-- เดือน -->
                                                    <th style="min-width:100px;">Jan</th>
                                                    <th style="min-width:100px;">Feb</th>
                                                    <th style="min-width:100px;">Mar</th>
                                                    <th style="min-width:100px;">Apr</th>
                                                    <th style="min-width:100px;">May</th>
                                                    <th style="min-width:100px;">Jun</th>
                                                    <th style="min-width:100px;">Jul</th>
                                                    <th style="min-width:100px;">Aug</th>
                                                    <th style="min-width:100px;">Sep</th>
                                                    <th style="min-width:100px;">Oct</th>
                                                    <th style="min-width:100px;">Nov</th>
                                                    <th style="min-width:100px;">Dec</th>

                                                </tr>
                                            </thead>
                                            <tbody id="tableBody"> 
                                                @foreach ($hd as $key => $item)
                                                    <tr>
                                                        <td>
                                                            {{ $loop->iteration }}
                                                            <input type="hidden" 
                                                                name="iso_swabtest_plans_listno[]" 
                                                                value="{{ $loop->iteration }}">
                                                            <input type="hidden" 
                                                                name="iso_swabtest_plans_id[]" 
                                                                value="{{ $item->iso_swabtest_plans_id }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="iso_swabtest_plans_area[]" 
                                                                value="{{ $item->iso_swabtest_plans_area }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="iso_swabtest_plans_list[]" 
                                                                value="{{ $item->iso_swabtest_plans_list }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="iso_swabtest_plans_qty[]" 
                                                                value="{{ $item->iso_swabtest_plans_qty }}">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control"
                                                                name="iso_swabtest_plans_frequency[]" 
                                                                value="{{ $item->iso_swabtest_plans_frequency }}">
                                                        </td>
                                                        <td>
                                                           <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>

                                                                <input type="hidden" name="plan_jan[{{ $key }}]" value="0">

                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox m-0"
                                                                    name="plan_jan[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_jan == 1 ? 'checked' : '' }}>
                                                            </div>

                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>

                                                                <input type="hidden" name="action_jan[{{ $key }}]" value="0">

                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox m-0"
                                                                    name="action_jan[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_jan == 1 ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_feb[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_feb[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_feb == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_feb[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_feb[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_feb == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_mar[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_mar[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_mar == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_mar[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_mar[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_mar == 1 ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td>
                                                             <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_apr[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_apr[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_apr == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_apr[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_apr[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_apr == 1 ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_may[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_may[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_may == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_may[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_may[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_may == 1 ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_jun[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_jun[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_jun == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_jun[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_jun[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_jun == 1 ? 'checked' : '' }}>
                                                            </div>
                                                        </td>
                                                        <td>
                                                           <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_jul[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_jul[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_jul == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_jul[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_jul[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_jul == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        </td>
                                                        <td>
                                                             <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_aug[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_aug[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_aug == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_aug[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_aug[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_aug == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        </td>
                                                        <td>
                                                            <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_sep[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_sep[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_sep == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_sep[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_sep[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_sep == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        </td>
                                                        <td>
                                                             <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_oct[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_oct[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_oct == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_oct[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_oct[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_oct == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        </td>
                                                        <td>
                                                              <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_nov[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_nov[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_nov == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_nov[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_nov[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_nov == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        </td>
                                                        <td>
                                                                <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_dec[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_dec[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_dec == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_dec[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_dec[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_dec == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="iso_swabtest_plans_person[]" class="form-control" value="{{$item->iso_swabtest_plans_person}}"/>
                                                        </td>
                                                        <td>
                                                            <input type="text" name="iso_swabtest_plans_review[]" class="form-control" value="{{$item->iso_swabtest_plans_review}}"/>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('iso-swabtestplan.show', $item->iso_swabtest_plans_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i></a>
                                                        </td>
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

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td>
                <span class="row-number"></span>
                <input type="hidden" name="iso_swabtest_plans_listno[]" class="row-number-hidden"/>
                <input type="hidden" name="iso_swabtest_plans_id[]" value="0">
            </td>
            <td><input type="text" name="iso_swabtest_plans_area[]" class="form-control"/></td>
            <td><input type="text" name="iso_swabtest_plans_list[]" class="form-control"/></td>       
            <td><input type="text" name="iso_swabtest_plans_qty[]" class="form-control"/></td>    
            <td><input type="text" name="iso_swabtest_plans_frequency[]" class="form-control"/></td>  
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
            <td><input type="text" name="iso_swabtest_plans_person[]" class="form-control"/></td>
            <td><input type="text" name="iso_swabtest_plans_review[]" class="form-control"/></td>
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