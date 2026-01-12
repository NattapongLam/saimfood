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
                                        <tbody>
                                            @foreach ($clb as $key => $item)
                                                <tr>
                                                    <td>
                                                        {{$item->clb_measuring_lists_listno }}
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
                                                <tr>
                                                    <th colspan="12">การดำเนินการตามแผนเดือน</th>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        ม.ค.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_jan[{{ $key }}]" value="0">
                                                            <input type="checkbox"
                                                                class="form-check-input scale-checkbox"
                                                                name="plan_jan[{{ $key }}]"
                                                                value="{{$item->plan_jan}}"
                                                                {{ $item->plan_jan ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        ก.พ.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_feb[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_feb[{{ $key }}]"
                                                            value="1"
                                                             {{ $item->plan_feb ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        มี.ค.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_mar[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_mar[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_mar ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        เม.ย.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_apr[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_apr[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_apr ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        พ.ค.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_may[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_may[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_may ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        มิ.ย.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_jun[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_jun[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_jun ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        ก.ค.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_jul[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_jul[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_jul ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        ส.ค.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_aug[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_aug[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_aug ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        ก.ย.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_sep[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_sep[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_sep ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        ต.ค.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_oct[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_oct[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_oct ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        พ.ย.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_nov[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_nov[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_nov ? 'checked' : '' }}>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        ธ.ค.
                                                        <div class="form-check d-flex justify-content-center">
                                                            <input type="hidden" name="plan_dec[{{ $key }}]" value="0">
                                                            <input type="checkbox" 
                                                            class="form-check-input scale-checkbox" 
                                                            name="plan_dec[{{ $key }}]"
                                                            value="1"
                                                            {{ $item->plan_dec ? 'checked' : '' }}>
                                                        </div>
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
</script>
@endsection