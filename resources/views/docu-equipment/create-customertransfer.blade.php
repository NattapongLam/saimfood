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
                            <form class="custom-validation" action="{{ route('customer-transfer.store') }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf 
                            <div class="row">                              
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ลูกค้า</label>
                                        <select class="select2 form-select" name="customer_id" id="customer_id" required>
                                            <option value=""></option>
                                            @foreach ($cust as $item)
                                                <option value="{{$item->customer_id}}" 
                                                        data-fullname="{{ $item->customer_name }}" 
                                                        data-address="{{ $item->customer_address }}"
                                                        data-contact="{{ $item->contact_person }}"
                                                        data-tel="{{ $item->contact_tel }}">
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
                                        <input class="form-control" name="contact_person" id="contact_person" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            เบอร์โทร
                                        </label>
                                        <input class="form-control" name="contact_tel" id="contact_tel" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="form-group">
                                    <label class="form-label">ที่อยู่จัดส่ง</label>
                                    <textarea class="form-control" name="customer_address" id="customer_address" required></textarea>
                                    <input class="form-control" name="customer_fullname" id="customer_fullname" type="hidden" required>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">อุปกรณ์</label>
                                        <select class="form-select" name="equipment_transfer_dt_id" id="equipment_transfer_dt_id">
                                            <option value="">กรุณาเลือก</option>
                                            @foreach ($equipments as $item)
                                                <option value="{{$item->equipment_transfer_dt_id}}">{{$item->equipment_code}} {{$item->equipment_name}} ({{$item->customer_fullname}} {{$item->customer_address}})</option>
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
                                        <textarea class="form-control" name="person_remark" id="person_remark" required></textarea>
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