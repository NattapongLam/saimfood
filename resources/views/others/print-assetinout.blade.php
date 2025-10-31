@extends('layouts.main')
@section('content')

<!-- 🔹 ปุ่มพิมพ์ (เห็นเฉพาะหน้าเว็บ) -->
<div class="text-center mb-3">
    <button class="btn btn-primary no-print" onclick="window.print()">🖨️ พิมพ์ใบนำทรัพย์สิน</button>
</div>

<!-- 🔹 หน้ากระดาษ A4 แนวนอน แบ่งซ้าย–ขวาเป็น A5 -->
<div class="print-page">
    <!-- ฝั่งซ้าย = ต้นฉบับ -->
    <div class="a5-page left">
        @include('others.assetinout-content', ['hd' => $hd, 'dt' => $dt])
    </div>

    <!-- ฝั่งขวา = สำเนา -->
    <div class="a5-page right">
        @include('others.assetinout-content', ['hd' => $hd, 'dt' => $dt])
        <div class="copy-label">สำเนา (Copy)</div>
    </div>
</div>

@endsection

@section('style')
<style>
/* ------------------------------------------------------
   แสดงผลหน้าเว็บ (ก่อนพิมพ์)
------------------------------------------------------ */
.print-page {
    display: flex;
    flex-direction: row;
    width: 100%;
    margin: 0 auto;
}
.a5-page {
    width: 50%;
    padding: 10px;
    box-sizing: border-box;
    border: 1px solid #ddd;
    position: relative;
}
.a5-page.left {
    border-right: 1px dashed #aaa;
}
.copy-label {
    display: none; /* ซ่อนก่อนพิมพ์ */
}

/* ------------------------------------------------------
   ส่วนสั่งพิมพ์จริง
------------------------------------------------------ */
@media print {
    @page {
        size: A4 landscape;
        margin: 0;
    }

    body {
        margin: 0;
        font-family: "TH Sarabun New", sans-serif;
        font-size: 14pt;
        -webkit-print-color-adjust: exact;
    }

   /* ซ่อนทุก element ที่มี class no-print */
    .no-print {
        display: none !important;
        visibility: hidden !important;
    }

    /* หรือซ่อนปุ่มโดยตรง */
    button.no-print {
        display: none !important;
        visibility: hidden !important;
    }
    
    /* ขนาดพิมพ์ A4 แนวนอน */
    .print-page {
        display: flex;
        flex-direction: row;
        width: 297mm;
        height: 210mm;
        margin: 0;
        padding: 0;
    }

    .a5-page {
        width: 148.5mm; /* ครึ่ง A4 */
        height: 210mm;
        padding: 10mm;
        box-sizing: border-box;
        overflow: hidden;
        position: relative;
        page-break-inside: avoid;
        border: none;
    }

    .a5-page.left {
        border-right: 0.4mm dashed #000;
    }

    /* แสดงข้อความ Copy เฉพาะฝั่งขวา */
    .a5-page.right .copy-label {
        display: block;
        position: absolute;
        bottom: 10mm;
        right: 10mm;
        font-size: 10pt;
        color: #555;
    }
}
</style>
@endsection
