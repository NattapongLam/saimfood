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
                            <form class="custom-validation" action="{{ route('customer-transfer.update',$hd->customer_transfer_docu_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf 
                            @method('PUT') 
                            <div class="row">                              
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">ลูกค้า</label>
                                        <select class="select2 form-select" name="customer_id" id="customer_id" disabled>
                                            <option value=""></option>
                                            @foreach ($cust as $item)
                                                <option value="{{$item->customer_id}}" 
                                                        data-fullname="{{ $item->customer_name }}" 
                                                        data-address="{{ $item->customer_address }}"
                                                        data-contact="{{ $item->contact_person }}"
                                                        data-tel="{{ $item->contact_tel }}"
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
                                    <textarea class="form-control" name="customer_address" id="customer_address" required>{{$hd->customer_address}}</textarea>
                                    <input class="form-control" name="customer_fullname" id="customer_fullname" type="hidden" value="{{$hd->customer_fullname}}" readonly>
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
                                                <option value="{{$item->equipment_transfer_dt_id}}" {{ $item->equipment_transfer_dt_id == $hd->equipment_transfer_dt_id ? 'selected' : '' }}>
                                                    {{$item->equipment_code}} {{$item->equipment_name}} ({{$item->customer_fullname}} {{$item->customer_address}})
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
                                        <textarea class="form-control" name="person_remark" id="person_remark" readonly>{{$hd->person_remark}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">สถานะ</label>
                                        <select class="form-select" name="customer_transfer_status_id" id="customer_transfer_status_id" disabled >
                                            @foreach ($sta as $item)
                                                <option value="{{$item->customer_transfer_status_id}}" {{ $item->customer_transfer_status_id == $hd->customer_transfer_status_id ? 'selected' : '' }}>
                                                    {{$item->customer_transfer_status_name}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุ(อนุมัติ)</label>
                                        <input class="form-control" name="approved_remark" id="approved_remark" value="{{$hd->approved_remark}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                @if($ck)
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เลขที่ใบโอนย้ายล่าสุด</label>
                                            <input class="form-control" name="equipment_transfer_hd_docuno" id="equipment_transfer_hd_docuno" value="{{$ck->equipment_transfer_hd_docuno}}" readonly>
                                            <input class="form-control" name="equipment_transfer_hd_id" id="equipment_transfer_hd_id" value="{{$ck->equipment_transfer_hd_id}}" type="hidden" readonly>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ (ใบโอนย้าย)</label>
                                            <input class="form-control" name="equipment_transfer_hd_remark" id="equipment_transfer_hd_remark" value="{{$ck->equipment_transfer_hd_remark}}" readonly>
                                        </div>
                                    </div>
                                   <div class="col-12">
                                        <div class="card ">
                                            <div class="card-body img-resize">
                                                <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid receive_img" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">รูปภาพ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="receive_img" onchange="prevFile(this,'receive_img')" accept="image/*">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label">หมายเหตุ</label>
                                        <textarea class="form-control" name="receive_remark" id="receive_remark"></textarea>
                                    </div>    
                                </div>
                                @else
                                    <center><h5><strong>ไม่พบเอกสารโอนย้ายของเดิม</strong></h5></center>
                                @endif
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
function prevFile(input, elm) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
            $('.' + elm).attr('src', e.target.result);
                    file = input.files[0];
                }

                reader.readAsDataURL(input.files[0]);
            }
}
</script>
@endsection