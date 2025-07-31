@extends('layouts.main')
@section('content')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" />
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
                                <form class="custom-validation" action="{{ route('machine-checksheet-docus.store') }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf      
                                <div class="row"> 
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                วันที่
                                            </label>
                                            <input type="date" class="form-control" id="dateInput" name="machine_checksheet_docu_hd_date" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">
                                                เครื่องจักร
                                            </label>
                                            <select class="select2 form-select" id="machineSelect" required>
                                                <option value="">กรุณาเลือก</option>
                                                @foreach ($mc as $item)
                                                    <option value="{{ $item->machine_checksheet_hd_id }}" data-machine_code="{{ $item->machine_code }}">
                                                        {{ $item->machine_code }} / {{ $item->machine_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                           <input type="hidden"  name="machine_code" id="machineCodeInput" value="">
                                        </div>
                                    </div>
                                    <br>
                                    <div class="col-12">
                                         <div class="form-group">
                                            <label class="form-label">
                                               หมายเหตุ
                                            </label>
                                            <textarea class="form-control" name="machine_checksheet_docu_hd_note"></textarea>
                                         </div>
                                    </div>                        
                                </div>
                                <br>
                                <div class="row">
                                  <div class="table-responsive">
                                    <table class="table table-bordered table-sm nowrap text-center w-100" id="detailTable">
                                        <thead class="thead-light">
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รายละเอียด</th>
                                                        @for ($i = 1; $i <= 31; $i++)
                                                            <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                                                        @endfor
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                        </table>
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
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script>
$(document).ready(function () {
    $('.select2').select2({ placeholder: "เลือกเครื่องจักร", allowClear: true, width: '100%' });

    let table = $('#detailTable').DataTable({
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        ordering: false,
        searching: false,
        info: false,
        autoWidth: false, // ปิด
        columns: [
            { title: "#" },
            { title: "รายละเอียด", className: 'text-start align-middle'  },
            ...Array.from({ length: 31 }, (_, i) => ({ title: String(i + 1).padStart(2, '0') }))
        ]
    });

    $('#machineSelect').on('change', function () {
        const machineCode = $(this).find('option:selected').data('machine_code') || '';
        $('#machineCodeInput').val(machineCode);
        const id = $(this).val();
        if (id) {
            $.ajax({
                url: `/get-machine-checkdetails/${id}`,
                type: 'GET',
                success: function (data) {
                    table.clear().draw();
                    data.forEach((item, index) => {
                        const row = [
                            `${index + 1}
                            <input type="hidden" name="machine_checksheet_dt_id[]" value="${item.machine_checksheet_dt_id}">
                            <input type="hidden" name="machine_checksheet_dt_listno[]" value="${index + 1}">`,
                            `${item.detail}
                            <input type="hidden" name="machine_checksheet_dt_remark[]" value="${item.detail}">`
                        ];

                        for (let i = 1; i <= 31; i++) {
                            const day = String(i).padStart(2, '0');
                            row.push(`<input class="form-check-input" type="checkbox" name="check_${day}[]">`);
                        }

                        table.row.add(row).draw(false);
                    });
                },
                error: function () {
                    alert('ไม่สามารถโหลดข้อมูลได้');
                }
            });
        } else {
            table.clear().draw();
        }
    });
});
const dateInput = document.getElementById('dateInput');

    // เมื่อผู้ใช้เปลี่ยนค่า
    dateInput.addEventListener('change', function () {
        const date = new Date(this.value);
        if (!isNaN(date)) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const newValue = `${year}-${month}-01`;
            this.value = newValue;
        }
    });

    // ตั้งค่าเริ่มต้นเป็นวันที่ 1 ของเดือนปัจจุบัน
    window.addEventListener('DOMContentLoaded', () => {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        dateInput.value = `${year}-${month}-01`;
    });
</script>
@endsection