@extends('layouts.main')

@section('content')

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<style>
/* DataTable สำหรับกรอกข้อมูล */
.table td, .table th {
    white-space: nowrap;
    vertical-align: middle;
}
.table td input[type="checkbox"] {
    transform: scale(1.2);
}

/* Print A4 */
@media print {
    body * { visibility: hidden; }
    #printArea, #printArea * { visibility: visible; }
    #printArea { position: absolute; left: 0; top: 0; width: 100%; padding: 10mm; }

    table { border-collapse: collapse; width: 100% !important; table-layout: fixed; }
    th, td { border: 1px solid #000 !important; padding: 5px; font-size: 6px; word-wrap: break-word; white-space: normal; }
    .avatar-xl { width: 80px; height: 80px; }

    .no-print { display: none; }
    tr { page-break-inside: avoid; }
    table { page-break-after: auto; }
    @page { size: A4 landscape; margin: 10mm; }
}
</style>

<!-- ปุ่ม Print -->
<div class="row mb-3">
    <div class="col-12">
        <button class="btn btn-primary no-print" onclick="printChecksheet()">ปริ้นตรวจเช็ค</button>
    </div>
</div>

<!-- DataTable สำหรับกรอกข้อมูล -->
<div class="row no-print">
    <div class="col-12">
        <div class="card mb-3">
            <div class="card-header bg-transparent border-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h5>ประจำเดือน : {{ \Carbon\Carbon::parse($hd->machine_checksheet_docu_hd_date)->format('M-Y') }}</h5><br>
                            <img src="{{ asset($hd->machine_pic1 ?? 'images/no-image.png') }}" class="rounded-circle avatar-xl"><br>
                            <h5>{{ $hd->machine_code }} / {{ $hd->machine_name }}</h5>
                        </div>
                        <div class="col-6">
                            <label class="form-label">หมายเหตุ</label>
                            <textarea class="form-control">{{ $hd->machine_checksheet_docu_hd_note }}</textarea>
                        </div>
                    </div>

                    <br>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm nowrap text-center w-100" id="detailTable">
                            <thead>
                                <tr>
                                    <th>รายละเอียด</th>
                                    @for ($i = 1; $i <= 31; $i++)
                                        <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($hd->details as $index => $item)
                                    <tr>
                                        <td class="text-start">{{ $index + 1 }}. {{ $item->machine_checksheet_dt_remark }}</td>
                                        @for ($i = 1; $i <= 31; $i++)
                                            @php $field = 'check_' . str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                                            <td>
                                                <input type="checkbox" {{ $item->$field ? 'checked' : '' }}>
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Area -->
<div id="printArea" style="display:none;">
    <div class="text-center mb-3">
        <h4>ตรวจเช็คประจำวัน</h4>
        <p>ประจำเดือน : {{ \Carbon\Carbon::parse($hd->machine_checksheet_docu_hd_date)->format('M-Y') }}</p>
        <p>{{ $hd->machine_code }} / {{ $hd->machine_name }}</p>
        <img src="{{ asset($hd->machine_pic1 ?? 'images/no-image.png') }}" class="rounded-circle avatar-xl mb-2"><br>
        <p>หมายเหตุ: {{ $hd->machine_checksheet_docu_hd_note }}</p>
    </div>

    <table class="table table-bordered table-sm text-center">
        <thead>
            <tr>
                <th style="width: 55%">รายละเอียด</th>
                @for ($i = 1; $i <= 31; $i++)
                    <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>
            @foreach($hd->details as $index => $item)
                <tr>
                    <td class="text-start">{{ $index + 1 }}. {{ $item->machine_checksheet_dt_remark }}</td>
                    @for ($i = 1; $i <= 31; $i++)
                        @php $field = 'check_' . str_pad($i, 2, '0', STR_PAD_LEFT); @endphp
                        <td>{{ $item->$field ? '✔' : '' }}</td>
                    @endfor
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#detailTable').DataTable({
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        ordering: false,
        searching: false,
        info: false,
        autoWidth: false,
        columnDefs: [
            { targets: 0, className: 'text-start align-middle' },
            { targets: "_all", className: 'align-middle' }
        ]
    });
});

function printChecksheet() {
    let printContent = document.getElementById('printArea');
    printContent.style.display = 'block';
    window.print();
    printContent.style.display = 'none';
}
</script>
@endsection
