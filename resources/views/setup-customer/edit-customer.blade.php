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
                                <form class="custom-validation" action="{{ route('customers.update',$hd->customer_id) }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf   
                                @method('PUT')  
                                <div class="form-group">
                                                <label class="form-label">
                                                    Status
                                                </label>
                                                <div class="d-flex">
                                                    <div class="square-switch">
                                                         @if($hd->customer_flag == 1)
                                                        <input type="checkbox" id="square-switch1" switch="none" name="customer_flag" value="true" checked/>
                                                        @else
                                                        <input type="checkbox" id="square-switch1" switch="none" name="customer_flag" />
                                                        @endif
                                                        <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                                                    </div>
                                                </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">รหัสลูกค้า</label>
                                            <input class="form-control" name="customer_code" readonly value="{{$hd->customer_code}}">
                                        </div>                                       
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อลูกค้า</label>
                                            <input class="form-control" name="customer_name" required value="{{$hd->customer_name}}">
                                        </div>                                       
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ประเภทสาขา</label>
                                            <select class="form-select" name="branch_type" required>
                                                @if ($hd->branch_type == "สำนักงานใหญ่")
                                                    <option value="สำนักงานใหญ่">สำนักงานใหญ่</option>
                                                    <option value="สาขา">สาขา</option>
                                                @else
                                                    <option value="สาขา">สาขา</option>
                                                    <option value="สำนักงานใหญ่">สำนักงานใหญ่</option>
                                                @endif
                                               
                                            </select>
                                        </div>                                       
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">รหัสสาขา</label>
                                            <input class="form-control" name="branch_number" required value="{{$hd->branch_number}}">
                                        </div>                                       
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อสาขา</label>
                                            <input class="form-control" name="branch_name"  value="{{$hd->branch_name}}">
                                        </div>                                       
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">จังหวัด</label>
                                             <select class="select2 form-select" name="customer_province" required>
                                                <option value=""></option>
                                                @foreach ($prov as $item)
                                                    <option value="{{$item->province_code}}"   {{ $item->province_code == $province->province_code ? 'selected' : '' }}>
                                                        {{$item->province_name}}
                                                    </option>
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
                                            <input class="form-control" name="contact_person" required value="{{$hd->contact_person}}">
                                        </div>                                       
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">เบอร์โทร</label>
                                            <input class="form-control" name="contact_tel" required value="{{$hd->contact_tel}}">
                                        </div>                                       
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">พนักงานขาย</label>
                                            <select class="form-select" name="salecode">
                                                <option value="">กรุณาเลือก</option>
                                                @foreach ($sale as $item)
                                                    <option value="{{$item->personcode}}" {{ $item->personcode == $hd->salecode ? 'selected' : '' }}>
                                                        {{$item->personfullname}}
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
                                            <label class="form-label">ที่อยู่จัดส่ง</label>
                                            <textarea class="form-control" name="customer_address" required>{{$hd->customer_address}}</textarea>
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