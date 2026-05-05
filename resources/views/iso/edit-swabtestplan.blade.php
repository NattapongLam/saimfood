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
                            {{-- <form class="custom-validation" action="{{ route('iso-swabtestplan.update',$list->iso_swabtest_plans_date) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT') --}}
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_jan"
                                                                    name="plan_jan[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_jan == 1 ? 'checked' : '' }}>
                                                            </div>

                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>

                                                                <input type="hidden" name="action_jan[{{ $key }}]" value="0">

                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_jan"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_feb"
                                                                    name="plan_feb[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_feb == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_feb[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_feb"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_mar"
                                                                    name="plan_mar[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_mar == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_mar[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_mar"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_apr"
                                                                    name="plan_apr[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_apr == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_apr[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_apr"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_may"
                                                                    name="plan_may[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_may == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_may[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_may"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_jun"
                                                                    name="plan_jun[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_jun == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_jun[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_jun"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_jul"
                                                                    name="plan_jul[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_jul == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_jul[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_jul"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_aug"
                                                                    name="plan_aug[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_aug == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_aug[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_aug"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_sep"
                                                                    name="plan_sep[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_sep == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_sep[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_sep"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_oct"
                                                                    name="plan_oct[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_oct == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_oct[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_oct"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_nov"
                                                                    name="plan_nov[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_nov == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_nov[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_nov"
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
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="plan_dec"
                                                                    name="plan_dec[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_dec == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_dec[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox auto-save"
                                                                    data-id="{{ $item->iso_swabtest_plans_id }}"
                                                                    data-field="action_dec"
                                                                    name="action_dec[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_dec == 1 ? 'checked' : '' }}>
                                                        </div>
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                            name="iso_swabtest_plans_person[]"
                                                            data-id="{{ $item->iso_swabtest_plans_id }}"
                                                            data-field="iso_swabtest_plans_person"
                                                            class="form-control auto-save"
                                                            value="{{ $item->iso_swabtest_plans_person }}" />
                                                        </td>
                                                        <td>
                                                            <input type="text"
                                                            name="iso_swabtest_plans_review[]"
                                                            data-id="{{ $item->iso_swabtest_plans_id }}"
                                                            data-field="iso_swabtest_plans_review"
                                                            class="form-control auto-save"
                                                            value="{{ $item->iso_swabtest_plans_review }}" />
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
                            {{-- <br>
                                <div class="form-group">
                                    <div class="d-flex flex-wrap gap-2 justify-content">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                            บันทึก
                                        </button>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {

    // =========================
    // 🔐 CSRF SETUP (สำคัญมาก)
    // =========================
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // =========================
    // ⏱ debounce per element
    // =========================
    const debounceMap = new Map();

    function debounce(el, callback, delay = 700) {
        const key = el.get(0);

        if (debounceMap.has(key)) {
            clearTimeout(debounceMap.get(key));
        }

        const timer = setTimeout(callback, delay);
        debounceMap.set(key, timer);
    }

    // =========================
    // 🧠 AUTO SAVE FUNCTION
    // =========================
    function autoSave(el) {

        let field = el.data('field');
        let id = el.data('id');

        if (!field || !id) {
            console.warn('Missing data-field or data-id');
            return;
        }

        let value = el.attr('type') === 'checkbox'
            ? (el.is(':checked') ? 1 : 0)
            : el.val();

        // 🔥 loading state (optional)
        el.addClass('saving');

        $.ajax({
            url: '/iso-swabtestplan/auto-update',
            type: 'POST',
            data: { id, field, value },

            success: function (res) {
                el.removeClass('saving');

                if (!res.status) {
                    console.error('Save fail:', res.msg);
                } else {
                    console.log('saved:', field);
                }
            },

            error: function (xhr) {
                el.removeClass('saving');

                console.error('ERROR:', xhr.responseText);
            }
        });
    }

    // =========================
    // 🟢 INPUT (TEXT) → debounce
    // =========================
    $(document).on('input', '.auto-save', function () {

        let el = $(this);

        if (el.attr('type') === 'checkbox') return;

        debounce(el, () => autoSave(el), 800);
    });

    // =========================
    // 🔵 CHECKBOX → instant save
    // =========================
    $(document).on('change', '.auto-save[type="checkbox"]', function () {
        autoSave($(this));
    });

    // =========================
    // 🟡 BLUR (กันกรณีพิมพ์แล้วออก)
    // =========================
    $(document).on('blur', '.auto-save', function () {

        let el = $(this);

        if (el.attr('type') === 'checkbox') return;

        autoSave(el);
    });

});
</script>
<style>
.saving {
    background-color: #fff3cd !important;
}
</style>
@endsection