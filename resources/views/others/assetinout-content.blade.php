<div style="height:100%; display:flex; flex-direction:column; justify-content:space-between;">
    <div>
        <h4 class="text-center text-primary mb-2">ใบนำทรัพย์สินออกนอกบริษัท</h4>
        <div style="font-size:13pt;">
            <p><strong>วันที่:</strong> {{ $hd->assetinout_hd_date }}</p>
            <p><strong>เลขที่:</strong> {{ $hd->assetinout_hd_docuno }}</p>
            <p><strong>คู่ค้า:</strong> {{ $hd->assetinout_hd_vendor }}</p>
            <p><strong>ผู้ติดต่อ:</strong> {{ $hd->assetinout_hd_contact }}</p>
            <p><strong>เบอร์โทร:</strong> {{ $hd->assetinout_hd_tel }}</p>
            <p><strong>หมายเหตุ:</strong> {{ $hd->assetinout_hd_note }}</p>
        </div>

        <table class="table table-sm table-bordered text-center align-middle" style="font-size:12pt;">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>รายละเอียด</th>
                    <th>จำนวน</th>
                    <th>หมายเหตุ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dt as $item)
                <tr>
                    <td>{{ $item->assetinout_dt_listno }}</td>
                    <td>{{ $item->assetinout_dt_name }}</td>
                    <td>{{ $item->assetinout_dt_qty }}</td>
                    <td>{{ $item->assetinout_dt_note }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="text-center mt-4">
        <p>............................................................... <br> ผู้อนุมัติ</p>
    </div>
</div>
