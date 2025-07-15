<div class="a5-page">
    <div class="text-end small mb-2">{{ $label }}</div>
    <div class="invoice-title">
        <h6 class="float-end font-size-14">
            เลขที่ : {{$hd->equipment_transfer_hd_docuno}}<br>
            วันที่ : {{ \Carbon\Carbon::parse($hd->equipment_transfer_hd_date)->translatedFormat('j F Y') }}<hr>
            <div class="text-center" style="text-align: center; padding-top: 5px;">
                <div style="display: inline-block;">
                    {!! QrCode::encoding('UTF-8')->size(110)->generate(url('customer-transfer/'.$hd->equipment_transfer_hd_docuno)) !!}                                                      
                </div>
                <p style="margin-top: 10px; font-size: 14px; font-weight: bold;">
                    สแกนแจ้งซ่อม
                </p>
            </div>
        </h6>
        <div class="mb-4">
            <img src="{{ asset('images/logo_saim.jpg') }}" alt="logo" height="60"/><br>
            <h6><strong>เอกสารโอนย้ายอุปกรณ์</strong></h6>
        </div>
    </div>
    <p><strong>ลูกค้า :</strong> {{ $hd->customer_fullname }}</p>
    <p><strong>ที่อยู่จัดส่ง :</strong> {{ $hd->customer_address }}</p>
    <p><strong>ผู้ติดต่อ :</strong> {{ $hd->contact_person }} โทร: {{ $hd->contact_tel }}</p>
    <p><strong>หมายเหตุ :</strong> {{ $hd->equipment_transfer_hd_remark }}</p>

     <table class="table table-sm table-nowrap">
        <thead>
            <tr>
                <th style="width: 70px;" class="text-center">#</th>
                <th class="text-center">อุปกรณ์</th>
                <th class="text-center">เพิ่มเติม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hd->details->where('equipment_transfer_dt_flag', true) as $item)
                <tr>
                    <td class="text-center">{{ $item->equipment_transfer_dt_listno }}</td>
                    <td>
                        รหัส: {{ $item->equipment_code }}  ชื่อ: {{ $item->equipment_name }}  Serial: {{ $item->serial_number }}
                    </td>
                    <td>{{ $item->equipment_transfer_dt_remark }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4 row text-center">
        <div class="col-4">
            ..........................................<br>
            วันที่ .............................<br>
            <strong>ผู้จัดส่ง</strong>
        </div>
        <div class="col-4">
            ..........................................<br>
            วันที่ .............................<br>
            <strong>ผู้ตรวจสอบ</strong>
        </div>
        <div class="col-4">
            ..........................................<br>
            วันที่ .............................<br>
            <strong>ผู้รับสินค้า</strong>
        </div>
    </div>
</div>