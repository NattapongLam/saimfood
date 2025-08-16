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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ลูกค้า</h5>
                             <div class="page-title-right">                  
                        </div>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('customers.store') }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf 
                                <div class="row"> 
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">รหัสลูกค้า</label>
                                            <input class="form-control" name="customer_code" required>
                                        </div>                                       
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อลูกค้า</label>
                                            <input class="form-control" name="customer_name" required>
                                        </div>                                       
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ประเภทสาขา</label>
                                            <select class="form-select" name="branch_type" required>
                                                <option value="สำนักงานใหญ่">สำนักงานใหญ่</option>
                                                <option value="สาขา">สาขา</option>
                                            </select>
                                        </div>                                       
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">รหัสสาขา</label>
                                            <input class="form-control" name="branch_number" required>
                                        </div>                                       
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อสาขา</label>
                                            <input class="form-control" name="branch_name">
                                        </div>                                       
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">จังหวัด</label>
                                             <select class="select2 form-select" name="customer_province" required>
                                                <option value=""></option>
                                                @foreach ($prov as $item)
                                                    <option value="{{$item->province_code}}">{{$item->province_name}}</option>
                                                @endforeach
                                             </select>
                                        </div>                                       
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ติดต่อ</label>
                                            <input class="form-control" name="contact_person" required>
                                        </div>                                       
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">เบอร์โทร</label>
                                            <input class="form-control" name="contact_tel" required>
                                        </div>                                       
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">พนักงานขาย</label>
                                            <select class="form-select" name="salecode">
                                                <option value="">กรุณาเลือก</option>
                                                @foreach ($sale as $item)
                                                    <option value="{{$item->personcode}}">{{$item->personfullname}}</option>
                                                @endforeach
                                            </select>
                                        </div>                                       
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ที่อยู่จัดส่ง</label>
                                            <textarea class="form-control" name="customer_address" required></textarea>
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
</div>
@endsection
@section('script')
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "เลือกจังหวัด",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection