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
                                        แผนการส่งตรวจวิเคราะห์สินค้าสำเร็จรูป
                                    </h5>                              
                            </div>
                            <form class="custom-validation" action="{{ route('iso-producttestingplan.update',$list->iso_product_testing_plans_date) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ปี</label>
                                            <select class="form-control" name="iso_product_testing_plans_date">
                                            @for ($i = date('Y'); $i >= 2025; $i--)
                                                <option value="{{ $i }}" {{ old('iso_product_testing_plans_date', $list->iso_product_testing_plans_date ?? '') == $i ? 'selected' : '' }}>
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
                                        <table class="table table-bordered nowrap w-100 text-center">
                                            <thead>
                                                <tr>
                                                    <th rowspan="2" style="width:3%">ลำดับ</th>
                                                    <th rowspan="2" style="min-width:200px;">ชื่อสินค้า</th>
                                                    <th rowspan="2" style="min-width:160px;">รหัสสินค้า</th>
                                                    <th rowspan="2" style="min-width:180px;">กลุ่มผลิตภัณฑ์</th>
                                                    <th colspan="12">เดือน</th>
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
                                                                name="iso_product_testing_plans_listno[{{ $key }}]" 
                                                                value="{{ $loop->iteration }}">
                                                            <input type="hidden" 
                                                                name="iso_product_testing_plans_id[{{ $key }}]" 
                                                                value="{{ $item->iso_product_testing_plans_id }}">
                                                        </td>
                                                        <td style="min-width:200px;">
                                                            <input type="text" class="form-control"
                                                                name="iso_product_testing_plans_name[{{ $key }}]" 
                                                                value="{{ $item->iso_product_testing_plans_name }}">
                                                        </td>
                                                        <td style="min-width:160px;">
                                                            <input type="text" class="form-control"
                                                                name="iso_product_testing_plans_code[{{ $key }}]" 
                                                                value="{{ $item->iso_product_testing_plans_code }}">
                                                        </td>
                                                        <td style="min-width:180px;">
                                                            <input type="text" class="form-control"
                                                                name="iso_product_testing_plans_group[{{ $key }}]" 
                                                                value="{{ $item->iso_product_testing_plans_group }}">
                                                        </td>
                                                        <td style="min-width:100px;">
                                                            <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>

                                                                <input type="hidden" name="plans[{{ $key }}][plan_jan]" value="0">

                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox m-0"
                                                                    name="plans[{{ $key }}][plan_jan]"
                                                                    value="1"
                                                                    {{ $item->plan_jan == 1 ? 'checked' : '' }}>
                                                            </div>

                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>

                                                                <input type="hidden" name="plans[{{ $key }}][action_jan]" value="0">

                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox m-0"
                                                                    name="plans[{{ $key }}][action_jan]"
                                                                    value="1"
                                                                    {{ $item->action_jan == 1 ? 'checked' : '' }}>
                                                            </div>

                                                            <!-- FILE -->
                                                            @if ($item->file_jan)
                                                                <a href="{{ asset('storage/' . $item->file_jan) }}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="plans[{{ $key }}][file_jan]">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                              <!-- FILE -->
                                                            @if ($item->file_feb)
                                                                <a href="{{ asset('storage/' .$item->file_feb)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_feb[{{ $key }}]">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                              <!-- FILE -->
                                                            @if ($item->file_mar)
                                                                <a href="{{ asset('storage/' .$item->file_mar)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_mar[{{ $key }}]">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                             <!-- FILE -->
                                                            @if ($item->file_apr)
                                                                <a href="{{ asset('storage/' .$item->file_apr)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_apr[{{ $key }}]">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                              <!-- FILE -->
                                                            @if ($item->file_may)
                                                                <a href="{{ asset('storage/' .$item->file_may)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_may[{{ $key }}]">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                                 <!-- FILE -->
                                                            @if ($item->file_jun)
                                                                <a href="{{ asset('storage/' .$item->file_jun)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_jun[{{ $key }}]">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                             <!-- FILE -->
                                                            @if ($item->file_jul)
                                                                <a href="{{ asset('storage/' .$item->file_jul)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_jul[{{ $key }}]">
                                                                </div>
                                                            @endif
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                            <!-- FILE -->
                                                            @if ($item->file_aug)
                                                                <a href="{{ asset('storage/' .$item->file_aug)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_aug[{{ $key }}]">
                                                                </div>
                                                            @endif                   
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                         <!-- FILE -->
                                                            @if ($item->file_sep)
                                                                <a href="{{ asset('storage/' .$item->file_sep)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_sep[{{ $key }}]">
                                                                </div>
                                                            @endif   
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                          <!-- FILE -->
                                                            @if ($item->file_oct)
                                                                <a href="{{ asset('storage/' .$item->file_oct)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_oct[{{ $key }}]">
                                                                </div>
                                                            @endif                     
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                           <!-- FILE -->
                                                            @if ($item->file_nov)
                                                                <a href="{{ asset('storage/' .$item->file_nov)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_nov[{{ $key }}]">
                                                                </div>
                                                            @endif          
                                                        </td>
                                                        <td style="min-width:100px;">
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
                                                         <!-- FILE -->
                                                            @if ($item->file_dec)
                                                                <a href="{{ asset('storage/' .$item->file_dec)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_dec[{{ $key }}]">
                                                                </div>
                                                            @endif                       
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
                <input type="hidden" name="iso_product_testing_plans_listno[]" class="row-number-hidden"/>
                <input type="hidden" name="iso_product_testing_plans_id[]" value="0">
            </td>
            <td><input type="text" name="iso_product_testing_plans_name[]" class="form-control"/></td>
            <td><input type="text" name="iso_product_testing_plans_code[]" class="form-control"/></td>
            <td><input type="text" name="iso_product_testing_plans_group[]" class="form-control"/></td>
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