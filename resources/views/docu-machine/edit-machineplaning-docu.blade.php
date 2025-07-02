@extends('layouts.main')
@section('content')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>แผนการซ่อมบำรุง</h5>
                             <div class="page-title-right">                                             
                        </div>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('machine-planing-docus.update',$dt->machine_planingdocu_dt_id) }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf 
                                @method('PUT')     
                                <div class="row"> 
                                   <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="machine_planingdocu_dt_date" value="{{$dt->machine_planingdocu_dt_date}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">รหัสเครื่องจักร</label>
                                            <select class="select2 form-select" name="machine_code">
                                                <option value="{{$dt->machine_code}}">กรุณาเลือก</option>
                                                @foreach ($mc as $item)
                                                    <option value="{{$item->machine_code}}" {{ $item->machine_code == $dt->machine_code ? 'selected' : '' }}>
                                                        {{$item->machine_code}} / {{$item->machine_name}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>                      
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="machine_planingdocu_dt_note" value="{{$dt->machine_planingdocu_dt_note}}">
                                        </div>
                                    </div>
                                </div>
                                <br>
                                 <div class="row">
                                    <table  class="table table-bordered dt-responsive  nowrap w-100 text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>รายละเอียด</th>
                                                <th>เช็ค</th>
                                                <th>หมายเหตุ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($plandt as $key => $item)
                                                <tr>
                                                    <td>
                                                        {{$item->machine_planing_dt_listno}}
                                                        <input type="hidden" name="machine_planing_dt_id[]" value="{{$item->machine_planing_dt_id}}">
                                                        <input type="hidden" name="machine_planing_dt_listno[]" value="{{$item->machine_planing_dt_listno}}">
                                                        <input type="hidden" name="machine_planing_dt_remark[]" value="{{$item->machine_planing_dt_remark}}">
                                                    </td>
                                                    <td>{{$item->machine_planing_dt_remark}}</td>
                                                    <td>
                                                       <input class="form-check-input" type="checkbox" name="machine_planing_sub_action[{{ $key }}]" value="1" checked>
                                                    </td>
                                                    <td>
                                                        <input class="form-control" type="text" name="machine_planing_sub_note[]">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                 </div>
                                <hr>
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
</div>
@endsection
@section('script')
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "เลือกเครื่องจักร",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection