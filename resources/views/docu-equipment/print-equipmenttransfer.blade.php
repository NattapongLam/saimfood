@extends('layouts.main')
@section('content')
<div class="print-container">

    {{-- ชุดที่ 1: สำหรับลูกค้า --}}
    <div class="print-sheet">
        @include('docu-equipment._print-content', ['hd' => $hd, 'label' => 'สำหรับลูกค้า'])
    </div>

    {{-- ชุดที่ 2: สำหรับบริษัท --}}
    <div class="print-sheet">
        @include('docu-equipment._print-content', ['hd' => $hd, 'label' => 'สำหรับบริษัท'])
    </div>

</div>

{{-- ปุ่มพิมพ์ --}}
<div class="d-print-none mt-3 text-end">
    <a href="javascript:window.print()" class="btn btn-success"><i class="fa fa-print"></i> พิมพ์เอกสาร</a>
</div>
{{-- <div class="row">
    <div class="col-lg-12">
        <div class="card">
                                    <div class="card-body">
                                        <div class="invoice-title">
                                            <h4 class="float-end font-size-16">
                                                เลขที่ : {{$hd->equipment_transfer_hd_docuno}}<br>
                                                วันที่ : {{ \Carbon\Carbon::parse($hd->equipment_transfer_hd_date)->translatedFormat('j F Y') }}<hr>
                                                <div class="text-center" style="text-align: center; padding-top: 5px;">
                                                    <div style="display: inline-block;">
                                                        {!! QrCode::encoding('UTF-8')->size(150)->generate(url('customer-transfer/'.$hd->equipment_transfer_hd_docuno)) !!}                                                      
                                                    </div>
                                                     <p style="margin-top: 10px; font-size: 18px; font-weight: bold;">
                                                        สแกนแจ้งซ่อม
                                                     </p>
                                                </div>
                                            </h4>
                                            <div class="mb-4">
                                                <img src="{{ asset('images/logo_saim.jpg') }}" alt="logo" height="80"/><br>
                                                <h5><strong>เอกสารโอนย้ายอุปกรณ์</strong></h5>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-6 mt-3">
                                                <address>
                                                    <strong>ลูกค้า : {{$hd->customer_fullname}}</strong><br>
                                                    {{$hd->customer_address}}<br>
                                                    ผู้ติดต่อ : {{$hd->contact_person}} เบอร์ : {{$hd->contact_tel}}
                                                </address>
                                            </div>                                            
                                        </div>
                                         <div class="row">
                                            <div class="col-sm-6 mt-3">
                                                หมายเหตุ : {{$hd->equipment_transfer_hd_remark}}
                                            </div>
                                         </div>
                                        <div class="py-2 mt-3">
                                            <h3 class="font-size-15 fw-bold">รายการ</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 70px;">#</th>
                                                        <th>อุปกรณ์</th>
                                                        <th>เพิ่มเติม</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                  @foreach ($hd->details->where('equipment_transfer_dt_flag', true) as $key => $item)
                                                      <tr>
                                                        <td>{{$item->equipment_transfer_dt_listno}}</td>
                                                        <td>
                                                            รหัส : {{$item->equipment_code}}<br>
                                                            ชื่อ : {{$item->equipment_name}}<br>
                                                            Serial : {{$item->serial_number}}
                                                        </td>
                                                        <td>{{$item->equipment_transfer_dt_remark}}</td>
                                                      </tr>
                                                  @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4 mt-3 text-center">
                                                ......................................................... <hr>
                                                วันที่ ..................................... <br>
                                                <strong>ผู้จัดส่ง</strong>
                                            </div>
                                            <div class="col-sm-4 mt-3 text-center">
                                                ......................................................... <hr>
                                                วันที่ ..................................... <br>
                                                <strong>ผู้ตรวจสอบ</strong>
                                            </div>
                                            <div class="col-sm-4 mt-3 text-center">
                                                ......................................................... <hr>
                                                วันที่ ..................................... <br>
                                                <strong>ผู้รับสินค้า</strong>
                                            </div>
                                        </div>
                                        <div class="d-print-none">
                                            <div class="float-end">
                                                <a href="javascript:window.print()" class="btn btn-success waves-effect waves-light me-1"><i class="fa fa-print"></i></a>
                                            </div>
                                        </div>
                                    </div>
        </div>
    </div>
</div> --}}
@endsection
@section('script')
<style>
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

    .print-container {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }

    .print-sheet {
        width: 48%;
        border: 1px solid #ccc;
        padding: 10px;
        box-sizing: border-box;
        page-break-inside: avoid;
    }

    .a5-page {
        font-size: 10pt;
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