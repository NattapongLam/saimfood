<div style="height:100%; display:flex; flex-direction:column; justify-content:space-between;">
    <div>
        <h4 class="text-center text-primary mb-2">ใบนำทรัพย์สินออกนอกบริษัท</h4>
        <div style="font-size:13pt;">
            <div class="row">
                <div class="col-6">
                    <p><strong>วันที่:</strong> {{\Carbon\Carbon::parse($hd->assetinout_hd_date)->translatedFormat('d/m/Y')}}</p>
                </div>
                <div class="col-6">
                    <p><strong>เลขที่:</strong> {{ $hd->assetinout_hd_docuno }}</p>
                </div>                
            </div>
            <div class="row">
                <div class="col-12">
                    <p><strong>คู่ค้า:</strong> {{ $hd->assetinout_hd_vendor }}</p>
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><strong>ผู้ติดต่อ:</strong> {{ $hd->assetinout_hd_contact }}</p>
                </div>
                <div class="col-6">
                    <p><strong>เบอร์โทร:</strong> {{ $hd->assetinout_hd_tel }}</p>
                </div>
            </div>
            <div class="row">              
                <div class="col-12">
                    <p><strong>หมายเหตุ:</strong> {{ $hd->assetinout_hd_note }}</p>
                </div>
            </div>
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
    <div class="row">
        <div class="col-4">
            <div class="text-center mt-4">
                <p>......................................... <br> ผู้จ่าย</p>
                <p>............................... <br> วันที่</p>
            </div>
        </div>
        <div class="col-4">
            <div class="text-center mt-4">
                <p>.......................................... <br> ผู้รับ</p>
                <p>............................... <br> วันที่</p>
            </div>
        </div>
        <div class="col-4">
            <div class="text-center mt-4">
                <p>........................................... <br> รปภ</p>
                <p>............................... <br> วันที่</p>
            </div>
        </div>
    </div>
</div>
