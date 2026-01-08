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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>บัญชีรายชื่อเครื่องมือวัด</h5>
                            </div>
                            <form class="custom-validation" action="{{ route('clb-measuringlist.update',$hd->clb_measuring_lists_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ลำดับ</label>
                                            <input class="form-control" type="number" name="clb_measuring_lists_listno" value="{{$hd->clb_measuring_lists_listno}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">หมายเลขเครื่องมือวัด</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_code" value="{{$hd->clb_measuring_lists_code}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อเครื่องมือวัด</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_name" value="{{$hd->clb_measuring_lists_name}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ยี่ห้อ</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_brand" value="{{$hd->clb_measuring_lists_brand}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">รุ่น(Model)</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_model" value="{{$hd->clb_measuring_lists_model}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">Serial No</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_serialno" value="{{$hd->clb_measuring_lists_serialno}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ฝ่าย/แผนกที่ใช้งาน/จุดประจำ</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_department" value="{{$hd->clb_measuring_lists_department}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ช่วงใช้งานจริง</label>
                                            <input class="form-control" type="text" name="actualuseperiod" value="{{$hd->actualuseperiod}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ความละเอียด</label>
                                            <input class="form-control" type="text" name="resolution" value="{{$hd->resolution}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เกณฑ์ยอมรับ</label>
                                            <input class="form-control" type="text" name="acceptancecriteria" value="{{$hd->acceptancecriteria}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เริ่มใช้งาน</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_start" value="{{$hd->clb_measuring_lists_start}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">หมายเลขเอกสารคู่มือ</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_note"  value="{{$hd->clb_measuring_lists_note}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="clb_measuring_lists_remark" value="{{$hd->clb_measuring_lists_remark}}">
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
</script>
@endsection