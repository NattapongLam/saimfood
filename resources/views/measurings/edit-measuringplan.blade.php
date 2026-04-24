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
input[type="file"] {
    color: transparent;
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
                                                        <input type="hidden" name="clb_measuring_plans_id[{{ $key }}]" value="{{$item->clb_measuring_plans_id}}">
                                                        <input type="hidden" name="clb_measuring_lists_id[{{ $key }}]" value="{{$item->clb_measuring_lists_id}}">
                                                        <input type="hidden" name="clb_measuring_lists_listno[{{ $key }}]" value="{{$item->clb_measuring_lists_listno}}">
                                                    </td>
                                                    <td>
                                                        {{$item->clb_measuring_lists_code}}
                                                        <input type="hidden" name="clb_measuring_lists_code[{{ $key }}]" value="{{$item->clb_measuring_lists_code}}">
                                                    </td>
                                                    <td>
                                                        {{$item->clb_measuring_lists_name}}
                                                        <input type="hidden" name="clb_measuring_lists_name[{{ $key }}]" value="{{$item->clb_measuring_lists_name}}">
                                                    </td>
                                                    <td>
                                                        {{$item->clb_measuring_lists_department}}
                                                        <input type="hidden" name="clb_measuring_lists_department[{{ $key }}]" value="{{$item->clb_measuring_lists_department}}">
                                                    </td>
                                                    <td colspan="2">
                                                        <input class="form-control form-control-sm input-auto"
                                                        oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" 
                                                        name="clb_measuring_lists_frequency[{{ $key }}]"
                                                        value="{{$item->clb_measuring_lists_frequency}}">
                                                    </td>
                                                    <td>
                                                        {{$item->actualuseperiod}}
                                                        <input type="hidden" name="actualuseperiod[{{ $key }}]" value="{{$item->actualuseperiod}}">
                                                    </td>
                                                    <td>
                                                        {{$item->acceptancecriteria}}
                                                        <input type="hidden" name="acceptancecriteria[{{ $key }}]" value="{{$item->acceptancecriteria}}">
                                                    </td>                                                  
                                                    <td>
                                                        <input class="form-control form-control-sm input-auto"
                                                        oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" 
                                                        name="clb_measuring_lists_inside[{{ $key }}]"
                                                        value="{{$item->clb_measuring_lists_inside}}">
                                                    </td>
                                                    <td>
                                                        <input class="form-control form-control-sm input-auto"
                                                        oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" 
                                                        name="clb_measuring_lists_external[{{ $key }}]"
                                                        value="{{$item->clb_measuring_lists_external}}">
                                                    </td>
                                                    <td colspan="2">
                                                        <input class="form-control form-control-sm input-auto"
                                                        oninput="this.style.height='auto';this.style.height=this.scrollHeight+'px'" 
                                                        name="clb_measuring_lists_remark[{{ $key }}]"
                                                        value="{{$item->clb_measuring_lists_remark}}">
                                                    </td>
                                                </tr>
                                                <tr style="background-color:aliceblue">
                                                    <th colspan="12">การดำเนินการตามแผนเดือน</th>
                                                </tr>
                                                <tr>
                                                   <td style="min-width:100px; max-width:100px;">
                                                            <div class="text-center fw-bold mb-1">ม.ค.</div>
                                                            <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_jan"
                                                                {{ $item->plan_jan ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_jan"
                                                                {{ $item->action_jan ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_jan)
                                                                <a href="{{ asset('storage/' .$item->file_jan)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_jan">
                                                                </div>
                                                            @endif                                                          
                                                    </td>
                                                    <td style="min-width:100px; max-width:100px;">
                                                            <div class="text-center fw-bold mb-1">ก.พ.</div>
                                                             <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_feb"
                                                                {{ $item->plan_feb ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_feb"
                                                                {{ $item->action_feb ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_feb)
                                                                <a href="{{ asset('storage/' .$item->file_feb)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_feb">
                                                                </div>
                                                            @endif
                                                    </td>
                                                    <td style="min-width:100px; max-width:100px;">
                                                            <div class="text-center fw-bold mb-1">มี.ค.</div>
                                                             <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_mar"
                                                                {{ $item->plan_mar ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_mar"
                                                                {{ $item->action_mar ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_mar)
                                                                <a href="{{ asset('storage/' .$item->file_mar)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_mar">
                                                                </div>
                                                            @endif
                                                    </td>
                                                  <td style="min-width:100px; max-width:100px;">
                                                            <div class="text-center fw-bold mb-1">เม.ย.</div>
                                                              <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_apr"
                                                                {{ $item->plan_apr ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_apr"
                                                                {{ $item->action_apr ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_apr)
                                                                <a href="{{ asset('storage/' .$item->file_apr)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_apr">
                                                                </div>
                                                            @endif
                                                    </td>
                                                    <td style="min-width:100px; max-width:100px;">
                                                            <div class="text-center fw-bold mb-1">พ.ค.</div>
                                                               <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_may"
                                                                {{ $item->plan_may ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_may"
                                                                {{ $item->action_may ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_may)
                                                                <a href="{{ asset('storage/' .$item->file_may)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_may">
                                                                </div>
                                                            @endif
                                                    </td>
                                                     <td style="min-width:100px; max-width:100px;">
                                                            <div class="text-center fw-bold mb-1">มิ.ย.</div>
                                                                <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_jun"
                                                                {{ $item->plan_jun ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_jun"
                                                                {{ $item->action_jun ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_jun)
                                                                <a href="{{ asset('storage/' .$item->file_jun)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_jun">
                                                                </div>
                                                            @endif
                                                    </td>
                                                   <td style="min-width:100px; max-width:100px;">
                                                        <div class="text-center fw-bold mb-1">ก.ค.</div>
                                                              <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_jul"
                                                                {{ $item->plan_jul ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_jul"
                                                                {{ $item->action_jul ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_jul)
                                                                <a href="{{ asset('storage/' .$item->file_jul)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_jul">
                                                                </div>
                                                            @endif   
                                                    </td>
                                                    <td style="min-width:100px; max-width:100px;">
                                                        <div class="text-center fw-bold mb-1">ส.ค.</div>    
                                                         <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_aug"
                                                                {{ $item->plan_aug ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_aug"
                                                                {{ $item->action_aug ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_aug)
                                                                <a href="{{ asset('storage/' .$item->file_aug)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_aug">
                                                                </div>
                                                            @endif                                                     
                                                    </td>
                                                    <td style="min-width:100px; max-width:100px;">
                                                        <div class="text-center fw-bold mb-1">ก.ย.</div>   
                                                        <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_sep"
                                                                {{ $item->plan_sep ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_sep"
                                                                {{ $item->action_sep ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_sep)
                                                                <a href="{{ asset('storage/' .$item->file_sep)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_sep">
                                                                </div>
                                                            @endif                  
                                                    </td>
                                                    <td style="min-width:100px; max-width:100px;">
                                                        <div class="text-center fw-bold mb-1">ต.ค.</div>  
                                                         <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_oct"
                                                                {{ $item->plan_oct ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_oct"
                                                                {{ $item->action_oct ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_oct)
                                                                <a href="{{ asset('storage/' .$item->file_oct)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_oct">
                                                                </div>
                                                            @endif                                                                            
                                                    </td>
                                                    <td style="min-width:100px; max-width:100px;">
                                                        <div class="text-center fw-bold mb-1">พ.ย.</div> 
                                                        <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_nov"
                                                                {{ $item->plan_nov ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_nov"
                                                                {{ $item->action_nov ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_nov)
                                                                <a href="{{ asset('storage/' .$item->file_nov)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_nov">
                                                                </div>
                                                            @endif                                                                                     
                                                    </td>
                                                    <td style="min-width:100px; max-width:100px;">
                                                        <div class="text-center fw-bold mb-1">ธ.ค.</div>   
                                                        <!-- PLAN -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 mb-1 rounded plan-box">
                                                                <span class="small fw-bold text-primary">PLAN</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="plan_dec"
                                                                {{ $item->plan_dec ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- ACTION -->
                                                            <div class="d-flex align-items-center justify-content-between px-2 py-1 rounded action-box">
                                                                <span class="small fw-bold text-success">ACTION</span>
                                                                <input type="checkbox"
                                                                class="auto-save"
                                                                data-id="{{ $item->clb_measuring_plans_id }}"
                                                                data-field="action_dec"
                                                                {{ $item->action_dec ? 'checked' : '' }}>
                                                            </div>
                                                            <!-- FILE -->
                                                            @if ($item->file_dec)
                                                                <a href="{{ asset('storage/' .$item->file_dec)}}" target="_blank" class="text-dark">
                                                                    <i class="fa fa-file-alt"> ไฟล์แนบ</i>
                                                                </a>
                                                            @else
                                                                <div class="file-box text-center">
                                                                    <input type="file"
                                                                    class="auto-upload"
                                                                    data-id="{{ $item->clb_measuring_plans_id }}"
                                                                    data-field="file_dec">
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
$(document).on('change', '.auto-save', function () {

    $.ajax({
        url: '/clb-measuringplan/auto-update',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: $(this).data('id'),
            field: $(this).data('field'),
            value: $(this).is(':checked') ? 1 : 0
        },
        success: function (res) {
            console.log('RESPONSE:', res);

            if (res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'บันทึกสำเร็จ',
                    timer: 800,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: res.msg ?? 'ไม่สำเร็จ'
                });
            }
        },
        error: function (xhr) {
            console.error('AJAX ERROR:', xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Server error',
                text: xhr.responseText
            });
        }
    });

});
$(document).on('change', '.auto-upload', function () {

    let el = $(this);
    let file = this.files[0];

    if (!file) return;

    let formData = new FormData();

    formData.append('_token', '{{ csrf_token() }}');
    formData.append('id', el.data('id'));
    formData.append('field', el.data('field'));
    formData.append('file', file);

    $.ajax({
        url: "{{ url('/clb-measuringplan/auto-update') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {

            console.log(res);

            if (res.status) {
                Swal.fire({
                    icon: 'success',
                    title: 'อัปโหลดสำเร็จ',
                    timer: 800,
                    showConfirmButton: false
                });

            } else {
                Swal.fire({
                    icon: 'error',
                    title: res.msg ?? 'อัปโหลดไม่สำเร็จ'
                });
            }
        },
        error: function (xhr) {
            console.log(xhr.responseText);

            Swal.fire({
                icon: 'error',
                title: 'Upload error'
            });
        }
    });
});
</script>
@endsection