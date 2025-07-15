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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบโอนย้ายอุปกรณ์ลูกค้า</h5>
                            <div class="page-title-right">                  
                            </div>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('equipment-transfer.store') }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf 
                                <div class="row"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="equipment_transfer_hd_date" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <label class="form-label">ลูกค้า</label>
                                            <select class="select2 form-select" name="customer_id" id="customer_id" required>
                                                <option value=""></option>
                                                @foreach ($cust as $item)
                                                    <option value="{{$item->customer_id}}" 
                                                        data-fullname="{{ $item->customer_name }}" 
                                                        data-address="{{ $item->customer_address }}"
                                                        data-contact="{{ $item->contact_person }}"
                                                        data-tel="{{ $item->contact_tel }}"
                                                    >
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
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุ</label>
                                        <textarea class="form-control" name="equipment_transfer_hd_remark"></textarea>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <table id="DataTableList" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>เลือก</th>
                                                <th>เครื่อง</th>
                                                <th>วันที่หมดประกัน</th>
                                                <th>เพิ่มเติม</th>                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($equi as $index => $item)
                                            <tr>
                                                <td>
                                                    <input type="checkbox" class="form-check-input equipment-checkbox" data-index="{{ $index }}">
                                                    
                                                    {{-- ซ่อนข้อมูลไว้ แต่เพิ่ม class เพื่อใช้เปิด/ปิดการ disable --}}
                                                    <input type="hidden" value="{{ $item->equipment_id }}" name="equipment_id[{{ $index }}]" disabled>
                                                    <input type="hidden" value="{{ $item->equipment_code }}" name="equipment_code[{{ $index }}]" disabled>
                                                    <input type="hidden" value="{{ $item->equipment_name }}" name="equipment_name[{{ $index }}]" disabled>
                                                    <input type="hidden" value="{{ $item->serial_number }}" name="serial_number[{{ $index }}]" disabled>
                                                </td>
                                                <td>
                                                    <img src="{{ asset($item->equipment_pic1 ?? 'images/no-image.png') }}" class="rounded-circle avatar-xl"><br>
                                                    {{ $item->equipment_code }} {{ $item->equipment_name }} <br>
                                                    {{ $item->serial_number }}
                                                </td>
                                                <td>
                                                    {{ $item->insurance_date }}
                                                </td>
                                                <td>
                                                    <input class="form-control" name="equipment_transfer_dt_remark[{{ $index }}]" disabled>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
$(document).ready(function() {
    $('#DataTableList').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "order": [[1, "desc"]], // <-- เรียงวันที่ล่าสุดก่อน
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูล",
            "search": "ค้นหา:",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        },
        "columnDefs": [
            { "className": "text-center", "targets": "_all" }
        ]
    });
});
$(document).ready(function () {
    $('.equipment-checkbox').on('change', function () {
        var index = $(this).data('index');
        var row = $(this).closest('tr');
        // toggle enable/disable input fields in the same row
        row.find('input[name^="equipment_"]').prop('disabled', !this.checked);
    });
});
</script>
@endsection