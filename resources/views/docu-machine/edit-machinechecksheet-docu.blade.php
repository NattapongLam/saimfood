@extends('layouts.main')
@section('content')
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">

<style>
    /* ✅ ป้องกัน checkbox ซ้อนคอลัมน์ */
    #detailTable td,
    #detailTable th {
        background-color: #fff !important;
        position: relative;
        z-index: 1;
    }

    #detailTable td:nth-child(2) {
        z-index: 3; /* คอลัมน์ "รายละเอียด" */
    }

    #detailTable td input[type="checkbox"] {
        position: relative;
        z-index: 10;
        transform: scale(1.2);
    }

    .dataTables_scrollBody {
        overflow-x: auto !important;
        background: white;
        z-index: 1;
    }

    .dataTables_wrapper {
        overflow-x: auto;
        position: relative;
    }

    table.dataTable td {
        vertical-align: middle;
        overflow: visible;
    }

    th, td {
        white-space: nowrap;
    }
    #detailTable th, #detailTable td {
    white-space: nowrap;
    vertical-align: middle;
    }

    @media (max-width: 768px) {
        #detailTable {
            font-size: 12px;
        }
    }
</style>

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
                            <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ตรวจเช็คประจำวัน</h5>
                        </div>
                        <div class="card-body">
                            <form class="custom-validation" action="{{ route('machine-checksheet-docus.update', $hd->machine_checksheet_docu_hd_id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <h5>ประจำเดือน : {{ \Carbon\Carbon::parse($hd->machine_checksheet_docu_hd_date)->format('M-y') }}</h5><br>
                                            <img src="{{ asset($hd->machine_pic1 ?? 'images/no-image.png') }}" alt="Machine Image" class="rounded-circle avatar-xl"><br>
                                            <h5>{{ $hd->machine_code }} / {{ $hd->machine_name }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <textarea class="form-control" name="machine_checksheet_docu_hd_note">{{ $hd->machine_checksheet_docu_hd_note }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <br>

 <div class="row">
    <div class="table-responsive">
        <table class="table table-bordered table-sm nowrap text-center w-100" id="detailTable">
            <thead class="thead-light">
                <tr>
                    <th style="min-width: 200px;">รายละเอียด</th>
                    @for ($i = 1; $i <= 31; $i++)
                        <th style="min-width: 50px;" class="text-center">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach($hd->details as $index => $item)
                    <tr>
                        <td style="min-width: 200px;" class="text-start">
                             {{ $index + 1 }} . {{ $item->machine_checksheet_dt_remark }}
                             <input type="hidden" name="machine_checksheet_docu_dt_id[{{ $index }}]" value="{{ $item->machine_checksheet_docu_dt_id }}">
                        </td>
                        @for ($i = 1; $i <= 31; $i++)
                            @php
                                $field = 'check_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                            @endphp
                            <td  style="min-width: 50px;">
                                <input type="checkbox" name="check_{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}[{{ $index }}]" value="1" {{ $item->$field ? 'checked' : '' }}>
                            </td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
       <hr>
                                <h5 class="text-center"><strong>ผู้ตรวจสอบ</strong></h5>
                           <div class="row">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm nowrap text-center w-100" style="table-layout: fixed;">
                                        <tbody>
                                            @foreach($hd->employees as $index => $item)
                                                <tr>
                                                    @for ($i = 1; $i <= 31; $i++)
                                                        @php
                                                            $empField = 'emp_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                                        @endphp
                                                        <td style="width: calc(100% / 4);">
                                                            วันที่ : {{ str_pad($i, 2, '0', STR_PAD_LEFT) }} <br>
                                                            <input type="hidden" name="machine_checksheet_docu_emp_id" value="{{$item->machine_checksheet_docu_emp_id}}">
                                                            <select class="form-control select2" name="emp_day[{{ $i }}]">
                                                                <option value="">กรุณาเลือก</option>
                                                                @foreach ($emp as $emps)
                                                                    <option value="{{ $emps->personcode }}" 
                                                                        {{ $emps->personcode == $item->$empField ? 'selected' : '' }}>
                                                                        {{ $emps->personfullname }} ({{ $emps->position }})
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        @if ($i % 4 == 0 && $i < 31)
                                                            </tr><tr>
                                                        @endif
                                                    @endfor
                                                </tr>
                                            @endforeach                                          
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                                <br>

                                <div class="form-group">
                                    <div class="d-flex flex-wrap gap-2 justify-content">
                                        <button type="submit" class="btn btn-primary waves-effect waves-light">บันทึก</button>
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
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

<script>
$(document).ready(function () {
    $('#detailTable').DataTable({
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        ordering: false,
        searching: false,
        info: false,
        autoWidth: false, // ปิด auto width เพื่อป้องกันความกว้างผิดพลาด       
        columnDefs: [
            { targets: 0, className: 'text-start align-middle' },
            { targets: "_all", className: 'align-middle' }
        ]
        // ❌ ไม่ใช้ fixedColumns เพราะมีปัญหากับ checkbox ซ้อน
    });
});
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "กรุณาเลือก",
        allowClear: true
    });
});
</script>
@endsection
