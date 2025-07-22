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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบร้องขออุปกรณ์</h5>
                                <div class="page-title-right">                                                                                      
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="custom-validation" 
                                action="{{ route('equipment-request.approved', $hd->equipment_request_docu_id) }}" 
                                method="POST" 
                                enctype="multipart/form-data">
                                @csrf    
                                @method('PUT')                          
                            <div class="row">                              
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ลูกค้า</label>
                                        <select class="select2 form-select" name="customer_id" id="customer_id" readonly>
                                            <option value=""></option>
                                            @foreach ($cust as $item)
                                                <option value="{{$item->customer_id}}" 
                                                    {{ $item->customer_id == $hd->customer_id ? 'selected' : '' }}>
                                                    {{$item->customer_code}} / {{$item->customer_name}} จังหวัด : {{$item->customer_province}} สาขา : {{$item->branch_number}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>                               
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            ผู้ติดต่อ
                                        </label>
                                        <input class="form-control" name="contact_person" id="contact_person" value="{{$hd->contact_person}}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            เบอร์โทร
                                        </label>
                                        <input class="form-control" name="contact_tel" id="contact_tel" value="{{$hd->contact_tel}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">ที่อยู่จัดส่ง</label>
                                    <textarea class="form-control" name="customer_address" id="customer_address" readonly>{{$hd->customer_address}}</textarea>
                                    <input class="form-control" name="customer_fullname" id="customer_fullname" value="{{$hd->customer_fullname}}" type="hidden" readonly>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">วันที่ต้องการให้ส่ง</label>
                                        <input class="form-control" type="date" name="equipment_request_docu_duedate" value="{{ $hd->equipment_request_docu_duedate }}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">จำนวนเครื่อง</label>
                                        <input class="form-control" type="number" name="equipment_request_doc_qty" value="{{ $hd->equipment_request_doc_qty }}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">รายละเอียด</label>
                                    <textarea class="form-control" name="equipment_request_docu_remark" readonly rows="5">{{ $hd->equipment_request_docu_remark }}</textarea>
                                </div>
                            </div>
                            <br>
                            <h5>รายละเอียดอนุมัติ</h5>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">สถานะ</label>
                                        <select class="form-select" name="equipment_request_status_id" required>
                                            @foreach ($sta as $item)
                                                <option value="{{$item->equipment_request_status_id}}">{{$item->equipment_request_status_name}}</option>
                                            @endforeach                                           
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุ</label>
                                        <textarea class="form-control" name="approved_remark"></textarea>
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
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "เลือกลูกค้า",
        allowClear: true,
        width: '100%'
    });
});
$(document).ready(function () {
    $('#customer_id').on('change', function () {
        var selected = $(this).find('option:selected');
        $('#customer_fullname').val(selected.data('fullname') || '');
        $('#customer_address').val(selected.data('address') || '');
        $('#contact_person').val(selected.data('contact') || '');
        $('#contact_tel').val(selected.data('tel') || '');
    });
});
</script>
@endsection