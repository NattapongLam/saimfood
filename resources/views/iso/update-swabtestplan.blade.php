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
                            <form class="custom-validation" action="{{ route('iso-swabtestplan.update',$hd->iso_swabtest_plans_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">วันที่รายงานผล</label>
                                            <input class="form-control" type="date" name="" value="{{ old('iso_dar_lists_date', date('Y-m-d')) }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">แผนก</label>
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">จุดปฏิบัติงาน/จุดประจำ</label>
                                            <input class="form-control" type="text" name="" value="{{$hd->iso_swabtest_plans_area}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อพนักงาน/ชื่อเครื่องจักร-อุปกรณ์</label>
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">จุดที่ Swab Test</label>
                                            <select class="form-control">
                                                <option value="">กรุณาเลือก</option>
                                                <option value="มือ">มือ</option>
                                                <option value="ชุดยูนิฟอร์ม">ชุดยูนิฟอร์ม</option>
                                                <option value="หมวก">หมวก</option>
                                                <option value="เครื่องจักร/อุปกรณ์">เครื่องจักร/อุปกรณ์</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">รายละเอียดการ Swab Test</label>
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">สีสารละลายที่ปรากฎ</label>
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">สรุปผล</label>
                                            <select class="form-control">
                                                <option value="">กรุณาเลือก</option>
                                                <option value="ผ่าน">ผ่าน</option>
                                                <option value="ไม่ผ่าน">ไม่ผ่าน</option>
                                            </select>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ตรวจสอบ</label>
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ทวนสอบ</label>
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้รับทราบ</label>
                                            <input class="form-control" type="text" name="">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="">
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