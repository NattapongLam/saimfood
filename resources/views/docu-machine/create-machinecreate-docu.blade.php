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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบสร้างงาน</h5>
                            </div>    
                            <div class="card-body">
                            <form class="custom-validation" action="{{ route('machine-create-docus.store') }}" method="POST" enctype="multipart/form-data" validate>
                             @csrf   
                                <div class="row"> 
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="machine_repair_dochd_date" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ประเภท</label>
                                            <select class="form-select" name="machine_repair_dochd_type" required>
                                                <option value="ปกติ">ปกติ</option>
                                                <option value="ด่วน">ด่วน</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่องาน</label>
                                            <input class="form-control" type="text" name="machine_code" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ที่ตั้ง</label>
                                            <input class="form-control" type="type" name="machine_repair_dochd_location" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="form-label">วันที่ต้องการเสร็จ</label>
                                        <input class="form-control" type="date" name="machine_repair_dochd_duedate" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">รายละเอียด</label>
                                        <textarea class="form-control" name="machine_repair_dochd_case" required></textarea>
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
</div>
@endsection
@section('script')
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
</script>
@endsection