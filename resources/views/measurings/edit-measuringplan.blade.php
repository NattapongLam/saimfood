@extends('layouts.main')
@section('content')
<style>
.input-auto{
    min-height: 38px;
    resize: vertical;
}
.scale-checkbox{
    transform: scale(1.3);
    cursor: pointer;
}
.table-month th,
.table-month td{
    min-width: 45px;
}
.plan-box{
    background: #eef4ff;
    border: 1px solid #cfe2ff;
}
.action-box{
    background: #eaffea;
    border: 1px solid #b7f5b7;
}
/* PLAN = น้ำเงิน */
.chk-plan{
    accent-color: #0d6efd; /* bootstrap primary */
}

/* ACTION = เขียว */
.chk-action{
    accent-color: #198754; /* bootstrap success */
}
.chk-plan:checked{
    box-shadow: 0 0 0 2px rgba(13,110,253,0.25);
}

.chk-action:checked{
    box-shadow: 0 0 0 2px rgba(25,135,84,0.25);
}
</style>
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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>แผนการสอบเทียบเครื่องมือวัด</h5>
                            </div>
                            <form class="custom-validation" action="{{ route('clb-measuringplan.update',$year) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ปี</label>
                                            <select class="form-control" name="clb_measuring_lists_date">
                                            @for ($i = date('Y'); $i >= 2025; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered text-center table-month">
                                        <thead>
                                                <tr>
                                                    <th rowspan="2">ลำดับ</th>
                                                    <th rowspan="2">รหัสเครื่องมือวัด</th>
                                                    <th rowspan="2">ชื่อเครื่องมือวัด</th>
                                                    <th rowspan="2">ฝ่าย/แผนกที่รับผิดชอบ</th>
                                                    <th rowspan="2" colspan="2">ความถี่ในการสอบเทียบ</th>
                                                    <th rowspan="2">ช่วงในการใช้งาน</th>
                                                    <th rowspan="2">เกณฑ์การยอมรับ</th>

                                                    {{-- <th colspan="12">การดำเนินการตามแผนเดือน</th> --}}
                                                    <th colspan="2">สอบเทียบสถาบัน</th>

                                                    <th rowspan="2" colspan="2">หมายเหตุ</th>
                                                </tr>
                                                <tr>
                                                    {{-- <!-- เดือน -->
                                                    <th style="width:5%">ม.ค.</th>
                                                    <th style="width:5%">ก.พ.</th>
                                                    <th style="width:5%">มี.ค.</th>
                                                    <th style="width:5%">เม.ย.</th>
                                                    <th style="width:5%">พ.ค.</th>
                                                    <th style="width:5%">มิ.ย.</th>
                                                    <th style="width:5%">ก.ค.</th>
                                                    <th style="width:5%">ส.ค.</th>
                                                    <th style="width:5%">ก.ย.</th>
                                                    <th style="width:5%">ต.ค.</th>
                                                    <th style="width:5%">พ.ย.</th>
                                                    <th style="width:5%">ธ.ค.</th> --}}

                                                    <!-- สอบเทียบ -->
                                                    <th>ภายใน</th>
                                                    <th>ภายนอก</th>
                                                </tr>
                                            </thead>
                                        <tbody style="color: black">
                                            @foreach ($clb as $key => $item)
                                                <tr style="background-color:beige">
                                                    <td>
                                                        {{$item->clb_measuring_lists_listno }}
                                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->clb_measuring_plans_id }}')"><i class="fas fa-trash"></i></a>    
                                                        <input type="hidden" name="clb_measuring_plans_id[]" value="{{$item->clb_measuring_plans_id}}">
                                                        <input type="hidden" name="clb_measuring_lists_id[]" value="{{$item->clb_measuring_lists_id}}">
                                                        <input type="hidden" name="clb_measuring_lists_listno[]" value="{{$item->clb_measuring_lists_listno}}">
                                                    </td>
                                                    <td>
                                                        {{$item->clb_measuring_lists_code}}
                                                        <input type="hidden" name="clb_measuring_lists_code[]" value="{{$item->clb_measuring_lists_code}}">
                                                    </td>
                                                    <td>
                                                        {{$item->clb_measuring_lists_name}}
                                                        <input type="hidden" name="clb_measuring_lists_name[]" value="{{$item->clb_measuring_lists_name}}">
                                                    </td>
                                                    <td>
                                                        {{$item->clb_measuring_lists_department}}
                                                        <input type="hidden" name="clb_measuring_lists_department[]" value="{{$item->clb_measuring_lists_department}}">
                                                    </td>
                                                    <td colspan="2">
                                                        <input class="form-control form-control-sm input-auto"
                                                        oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" 
                                                        name="clb_measuring_lists_frequency[]"
                                                        value="{{$item->clb_measuring_lists_frequency}}">
                                                    </td>
                                                    <td>
                                                        {{$item->actualuseperiod}}
                                                        <input type="hidden" name="actualuseperiod[]" value="{{$item->actualuseperiod}}">
                                                    </td>
                                                    <td>
                                                        {{$item->acceptancecriteria}}
                                                        <input type="hidden" name="acceptancecriteria[]" value="{{$item->acceptancecriteria}}">
                                                    </td>                                                  
                                                    <td>
                                                        <input class="form-control form-control-sm input-auto"
                                                        oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" 
                                                        name="clb_measuring_lists_inside[]"
                                                        value="{{$item->clb_measuring_lists_inside}}">
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-control-sm input-auto"
                                                        oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" 
                                                        name="clb_measuring_lists_external[]"
                                                        value="{{$item->clb_measuring_lists_external}}">
                                                    </td>
                                                    <td colspan="2">
                                                        <input class="form-control form-control-sm input-auto"
                                                        oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" 
                                                        name="clb_measuring_lists_remark[]"
                                                        value="{{$item->clb_measuring_lists_remark}}">
                                                    </td>
                                                </tr>
                                                <tr style="background-color:aliceblue">
                                                    <th colspan="12">การดำเนินการตามแผนเดือน</th>
                                                </tr>
                                                <tr>
                                                    <td style="min-width:100px;">
                                                            <div class="text-center fw-bold mb-1">ม.ค.</div>
                                                            <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="hidden" name="plan_jan[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-plan m-0"
                                                                    name="plan_jan[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->plan_jan == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="hidden" name="action_jan[{{ $key }}]" value="0">
                                                                <input type="checkbox"
                                                                    class="form-check-input scale-checkbox chk-action m-0"
                                                                    name="action_jan[{{ $key }}]"
                                                                    value="1"
                                                                    {{ $item->action_jan == 1 ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_jan)
                                                                <a href="{{ asset($item->file_jan)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                        class="form-control form-control-sm"
                                                                        name="file_jan[{{ $key }}]">
                                                                </div>
                                                            @endif
                                                           
                                                    </td>
                                                    <td style="min-width:100px;">
                                                            <div class="text-center fw-bold mb-1">ก.พ.</div>
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
                                                                <a href="{{ asset($item->file_feb)}}" target="_blank" class="text-dark">
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
                                                            <div class="text-center fw-bold mb-1">มี.ค.</div>
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
                                                                <a href="{{ asset($item->file_mar)}}" target="_blank" class="text-dark">
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
                                                            <div class="text-center fw-bold mb-1">เม.ย.</div>
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
                                                                <a href="{{ asset($item->file_apr)}}" target="_blank" class="text-dark">
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
                                                            <div class="text-center fw-bold mb-1">พ.ค.</div>
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
                                                                <a href="{{ asset($item->file_may)}}" target="_blank" class="text-dark">
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
                                                            <div class="text-center fw-bold mb-1">มิ.ย.</div>
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
                                                                <a href="{{ asset($item->file_jun)}}" target="_blank" class="text-dark">
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
                                                    <td>
                                                        <div class="text-center fw-bold mb-1">ก.ค.</div>
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
                                                                <a href="{{ asset($item->file_jul)}}" target="_blank" class="text-dark">
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
                                                    <td>
                                                        <div class="text-center fw-bold mb-1">ส.ค.</div>
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
                                                                <a href="{{ asset($item->file_aug)}}" target="_blank" class="text-dark">
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
                                                    <td>
                                                        <div class="text-center fw-bold mb-1">ก.ย.</div>
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
                                                                <a href="{{ asset($item->file_sep)}}" target="_blank" class="text-dark">
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
                                                    <td>
                                                        <div class="text-center fw-bold mb-1">ต.ค.</div>
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
                                                                <a href="{{ asset($item->file_oct)}}" target="_blank" class="text-dark">
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
                                                    <td>
                                                         <div class="text-center fw-bold mb-1">พ.ย.</div>
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
                                                                <a href="{{ asset($item->file_nov)}}" target="_blank" class="text-dark">
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
                                                    <td>
                                                          <div class="text-center fw-bold mb-1">ธ.ค.</div>
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
                                                                <a href="{{ asset($item->file_dec)}}" target="_blank" class="text-dark">
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
            url: `{{ url('/confirmDelMeasuringPlan') }}`,
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