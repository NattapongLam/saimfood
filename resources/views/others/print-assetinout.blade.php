@extends('layouts.main')
@section('content')

<!-- 🔹 หน้ากระดาษ A4 แนวนอน แบ่งซ้าย–ขวาเป็น A5 -->
<div class="print-page">
    <!-- ฝั่งซ้าย = ต้นฉบับ -->
    <div class="a5-page left">
        @include('others.assetinout-content', ['hd' => $hd, 'dt' => $dt])
        <div class="copy-label">ต้นฉบับ (Original)</div>
    </div>

    <!-- ฝั่งขวา = สำเนา -->
    <div class="a5-page right">
        @include('others.assetinout-content', ['hd' => $hd, 'dt' => $dt])
        <div class="copy-label">สำเนา (Copy)</div>
    </div>
</div>

{{-- ปุ่มพิมพ์ --}}
<div class="d-print-none mt-3 text-end">
    <a href="javascript:window.print()" class="btn btn-success"><i class="fa fa-print"></i> พิมพ์เอกสาร</a>
</div>

@endsection

@section('script')
<style>
/* ✅ โครงสร้างหลักให้แสดงซ้าย-ขวา */
.print-page {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    gap: 10px;
    width: 100%;
}

/* ✅ ตั้งค่าแต่ละหน้าให้ขนาดเท่า A5 (ครึ่ง A4 แนวนอน) */
.a5-page {
    width: 49%;
    border: 1px solid #999;
    padding: 10px;
    box-sizing: border-box;
    font-size: 11pt;
    position: relative;
}

/* ✅ ป้ายกำกับ ต้นฉบับ / สำเนา */
.copy-label {
    position: absolute;
    bottom: 5px;
    right: 10px;
    font-size: 9pt;
    font-weight: bold;
    color: #555;
}

/* ✅ โหมดพิมพ์ */
@media print {
    @page {
        size: A4 landscape;
        margin: 10mm;
    }

    body {
        margin: 0;
        padding: 0;
    }

    .d-print-none {
        display: none !important;
    }

    .print-page {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        page-break-inside: avoid;
    }

    .a5-page {
        width: 49%;
        border: 1px solid #ccc;
        padding: 10px;
        box-sizing: border-box;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 10pt;
    }

    th, td {
        border: 1px solid #999;
        padding: 4px;
    }
}
</style>
@endsection
