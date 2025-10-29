@extends('layouts.main')
@section('content')
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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>รายงาน</h5>
                            </div>
                            <form method="GET" class="form-horizontal">
                            @csrf
                                <div class="row">                              
                                        <div class="col-3">
                                            <div class="form-group d-flex align-items-center gap-2">
                                                <label for="datestart" class="mb-0">วัน :</label>
                                                <input type="date" class="form-control" id="datestart" name="datestart" value="{{ request('datestart', $datestart->format('Y-m-d')) }}" style="max-width: 200px;">
                                            </div>                                         
                                                                                    </div>
                                        <div class="col-3">
                                            <div class="form-group d-flex align-items-center gap-2">
                                                <label for="dateend" class="mb-0">ถึง :</label>
                                                <input type="date" class="form-control" name="dateend" id="dateend" value="{{ request('dateend', $dateend->format('Y-m-d')) }}" style="max-width: 200px;">
                                            </div>                                         
                                        </div>
                                        <div class="col-3">
                                             <div class="form-group">
                                                <button class="btn btn-info w-lg">
                                                    <i class="fas fa-search"> ค้นหา</i>
                                                </button>
                                             </div>                                          
                                        </div>                                
                                </div>
                            </form>
                        </div>
                </div>
            </div>
            <div class="card-body">
                <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                    <thead>
                        <tr>
                            <th>ลูกค้า</th>
                            <th>พนักงานขาย</th>
                            <th>จำนวนเครื่อง</th>
                            <th>มูลค่าอุปกรณ์</th>
                            <th>มูลค่าการซ่อม</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($hd1 as $item)
                            <tr>
                                <td>
                                    <a href="#" 
                                        class="customer-detail"
                                        data-customer="{{ $item->customer_code }}"
                                        data-bs-toggle="modal"
                                        data-bs-target="#customerModal">
                                    {{$item->customer_code}}
                                    </a>
                                    /{{$item->customer_name}} ({{$item->customer_zone}})
                                </td>
                                <td>
                                    {{$item->personfullname}}
                                </td>
                                <td>{{$item->total_qty}}</td>
                                <td>{{number_format($item->total_cost,2)}}</td>
                                <td>{{number_format($item->repair_cost,2)}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card mt-3">
                    <div class="card-header bg-primary text-white">
                        <h6 class="mb-0">มูลค่าตามลูกค้า (บาท)</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="equipmentChart" height="120"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Popup -->
<div class="modal fade" id="customerModal" tabindex="-1" aria-labelledby="customerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="customerModalLabel">รายละเอียด</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-sm">
          <thead>
            <tr>
                <th>วันที่</th>
                <th>เลขที่</th>
                <th>สถานะ</th>
                <th>อุปกรณ์</th>
                <th>มูลค่าอุปกรณ์</th>
                <th>มูลค่าการซ่อม</th>
            </tr>
          </thead>
          <tbody id="modal-detail-body">
            <!-- รายการจะถูกใส่ตรงนี้ -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $('#DataTableList').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "order": [[0, "desc"]], // <-- เรียงวันที่ล่าสุดก่อน
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูล",
            "search": "ค้นหา:",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        },
        "columnDefs": [
            { "className": "text-center", "targets": "_all" }
        ]
    });
});
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.customer-detail').forEach(el => {
        el.addEventListener('click', function () {
            let code = this.dataset.customer;
            let details = @json($detail); // ดึงข้อมูล detail จาก controller

            // ✅ ตรวจสอบว่ามี tbody ก่อน set innerHTML
            let body = document.querySelector('#modal-detail-body');
            if (!body) {
                console.error('❌ ไม่พบ element #modal-detail-body');
                return;
            }

            let rows = details
                .filter(x => x.customer_code == code)
                .map(x => `<tr>
                    <td>${x.equipment_transfer_hd_date}</td>
                    <td>${x.equipment_transfer_hd_docuno}</td>
                    <td>${x.equipment_transfer_status_name}</td>
                    <td>${x.equipment_name} (${x.equipment_code})</td>
                    <td>${Number(x.equipment_cost).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                    <td>${Number(x.repair_cost).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                </tr>`)
                .join('');

            body.innerHTML = rows;
        });
    });
});
document.addEventListener("DOMContentLoaded", function () {

    // 🔹 ดึงข้อมูลจาก Laravel ส่งมาผ่าน Blade
    const chartData = @json($hd1);

    // 🔹 สร้าง labels (ชื่อบริษัท)
    const labels = chartData.map(x => `${x.customer_code} - ${x.customer_name}`);

    // 🔹 สร้าง data แยกเป็น 2 ชุด
    const totalCostData = chartData.map(x => x.total_cost);
    const repairCostData = chartData.map(x => x.repair_cost);

    // 🔹 สร้างกราฟ Bar Chart
    const ctx = document.getElementById('equipmentChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'อุปกรณ์ (บาท)',
                    data: totalCostData,
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                },
                {
                    label: 'ค่าซ่อม (บาท)',
                    data: repairCostData,
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 0
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'มูลค่า (บาท)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: (ctx) =>
                            `${ctx.dataset.label}: ${ctx.parsed.y.toLocaleString('th-TH', { minimumFractionDigits: 2 })} บาท`
                    }
                }
            }
        }
    });
});
</script>
@endsection