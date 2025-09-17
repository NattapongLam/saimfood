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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ใบร้องขอ</label>
                                            <select class="select2 form-select" name="equipment_request_docu_id" id="equipment_request_docu_id" required>
                                                <option value=""></option>
                                                @foreach ($docu as $item)
                                                    <option value="{{$item->equipment_request_docu_id}}"
                                                    data-fullname="{{ $item->customer_fullname }}" 
                                                    data-address="{{ $item->customer_address }}"
                                                    data-contact="{{ $item->contact_person }}"
                                                    data-tel="{{ $item->contact_tel }}"
                                                    data-cust="{{ $item->customer_id }}"
                                                    data-duedate="{{ $item->equipment_request_docu_duedate }}"
                                                    data-remark="{{ $item->equipment_request_docu_remark }}"
                                                    data-note="{{ $item->approved_remark }}"
                                                    >
                                                    เลขที่ : {{$item->equipment_request_docu_docuno}} ลูกค้า : {{$item->customer_fullname}} ผู้ร้อง : {{$item->person_at}} ผู้อนุมัติ : {{$item->approved_at}} จำนวนเครื่อง : {{$item->equipment_request_doc_qty}}
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
                                            <label class="form-label">รายละเอียด</label>
                                            <textarea class="form-control" name="equipment_request_docu_remark" id="equipment_request_docu_remark" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหนุอนุมัติ</label>
                                            <textarea class="form-control" name="approved_remark" id="approved_remark" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="equipment_transfer_hd_date" value="{{ date('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">วันที่ต้องการจัดส่ง</label>
                                            <input class="form-control" type="date" name="equipment_request_docu_duedate" id="equipment_request_docu_duedate" required>
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
                                        <input class="form-control" name="customer_id" id="customer_id" type="hidden" required>
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
                                    <h5>อุปกรณ์พร้อมใช้</h5>
                                    {{-- <input type="text" id="equipmentSearch" class="form-control mb-2" placeholder="ค้นหา..."> --}}
                                    <table id="equipmentTable" class="table table-bordered dt-responsive  nowrap w-100 text-center">
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
        placeholder: "เลือกใบร้องขอ",
        allowClear: true,
        width: '100%'
    });
});
$(document).ready(function () {
    $('#equipment_request_docu_id').on('change', function () {
        var selected = $(this).find('option:selected');
        $('#customer_fullname').val(selected.data('fullname') || '');
        $('#customer_address').val(selected.data('address') || '');
        $('#contact_person').val(selected.data('contact') || '');
        $('#contact_tel').val(selected.data('tel') || '');
        $('#customer_id').val(selected.data('cust') || '');
        $('#equipment_request_docu_duedate').val(selected.data('duedate') || '');
        $('#equipment_request_docu_remark').val(selected.data('remark') || '');
        $('#approved_remark').val(selected.data('note') || '');
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
$(document).ready(function () {
    var table = $('#equipmentTable').DataTable({
        "paging": false,   // ไม่ต้องแบ่งหน้า
        "info": false,     // ซ่อนข้อความ "Showing x of y"
    });

    // ใช้ input ของเราเอง
    // $('#equipmentSearch').on('keyup', function () {
    //     table.search(this.value).draw();
    // });
});
</script>
@endsection