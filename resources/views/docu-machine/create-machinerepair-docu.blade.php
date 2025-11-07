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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งซ่อม</h5>
                            </div>    
                            <div class="card-body">
                            <form class="custom-validation" action="{{ route('machine-repair-docus.store') }}" method="POST" enctype="multipart/form-data" validate>
                             @csrf   
                                <div class="row"> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่</label>
                                            <input class="form-control" type="date" name="machine_repair_dochd_date" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ประเภท</label>
                                            <select class="form-select" name="machine_repair_dochd_type" required>
                                                <option value="ปกติ">ปกติ</option>
                                                <option value="ด่วน">ด่วน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">กลุ่มเครื่องจักร</label>
                                            <select class="form-select" id="machinegroup_id">
                                               <option value="">กรุณาเลือก</option>
                                               @foreach ($machinegroup as $item)
                                                  <option value="{{$item->machinegroup_id}}">{{$item->machinegroup_name}}</option> 
                                               @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">เครื่องจักร</label>
                                            <select class="select2 form-select" name="machine_code" id="machine_code" required>
                                                <option value="">กรุณาเลือก</option>
                                            </select>
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
                                        <div class="form-group">
                                            <label class="form-label">วันที่ต้องการเสร็จ</label>
                                            <input class="form-control" type="date" name="machine_repair_dochd_duedate" value="{{ date('Y-m-d') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชิ้นส่วน</label>
                                            <input class="form-control" type="type" name="machine_repair_dochd_part">
                                        </div>
                                    </div>
                                </div>                             
                                <br>
                                <div class="row">
                                    <div class="form-group">
                                        <label class="form-label">ปัญหา</label>
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
                            <br>
                            <div class="row">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                <div class="page-title-right">
                                        <h6 class="my-0">F-QP-MN-001-04:Rev02:11/06/2024</h6>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5><strong>งานแจ้งซ่อมค้าง</strong></h5>
                <div class="row">
                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th>สถานะ</th>
                                <th>วันที่</th>
                                <th>เลขที่</th>
                                <th>ประเภท</th>
                                <th>ปัญหา</th>
                                <th>ผู้แจ้งซ่อม</th>               
                            </tr>
                        </thead>
                        <tbody id="history_table_body"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>   
</div>
@endsection
@section('script')
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "เลือกเครื่องจักร",
        allowClear: true,
        width: '100%'
    });
});
$(document).ready(function() {
    $('#machine_code').change(function() {
        var machineCode = $(this).val();
        if (machineCode !== '') {
            $.ajax({
                url: '{{ route("machine.history") }}', // เส้นทาง API
                method: 'GET',
                data: { machine_code: machineCode },
                success: function(response) {
                    let rows = '';
                    if (response.length > 0) {
                        response.forEach(function(item) {
                            rows += `
                                <tr>
                                    <td>${item.status}</td>
                                    <td>${item.date}</td>
                                    <td>${item.doc_no}</td>
                                    <td>${item.type}</td>
                                    <td>${item.problem}</td>
                                    <td>${item.reporter}</td>
                                </tr>`;
                        });
                    } else {
                        rows = `<tr><td colspan="6" class="text-center">ไม่พบข้อมูล</td></tr>`;
                    }
                    $('#history_table_body').html(rows);
                }
            });
        } else {
            $('#history_table_body').html('');
        }
    });
});
$(document).ready(function () {
    $('#machinegroup_id').on('change', function () {
        let groupId = $(this).val();

        $('#machine_code').empty().append('<option value="">กำลังโหลด...</option>');

        if (groupId) {
            $.getJSON(`/get-machines/${groupId}`, function (data) {
                $('#machine_code').empty().append('<option value="">กรุณาเลือก</option>');
                $.each(data, function (index, item) {
                    $('#machine_code').append(
                        `<option value="${item.machine_code}">${item.machine_code} / ${item.machine_name}</option>`
                    );
                });
            });
        } else {
            $('#machine_code').empty().append('<option value="">กรุณาเลือก</option>');
        }
    });

    // init select2
    $('.select2').select2();
});
</script>
@endsection