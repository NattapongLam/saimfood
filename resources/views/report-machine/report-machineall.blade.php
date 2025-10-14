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
        </div>
        <div class="row">
            <div class="col-md-3">
                <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted fw-medium">งานสร้าง</h5>
                                                        <h5 class="mb-0">{{$hd1}} ครั้ง/{{number_format($cost1)}} บาท</h5>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <a href="{{url('/report-machine-createall')}}" target="_blank">
                                                            <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                                <span class="avatar-title">
                                                                    <i class="bx bx-copy-alt font-size-24"></i>
                                                                </span>
                                                            </div>
                                                        </a>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                </div>
            </div>           
            <div class="col-md-3">
                  <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted fw-medium">งานซ่อม</h5>
                                                        <h5 class="mb-0">{{$hd2}} ครั้ง/{{number_format($cost2)}} บาท</h5>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <a href="{{url('/report-machine-repairall')}}" target="_blank">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-copy-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                </div>
            </div>
            <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted fw-medium">ด่วน</h5>
                                                        <h5 class="mb-0">{{$hd3}} ครั้ง/{{number_format($cost3)}} บาท</h5>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <a href="{{url('/report-machine-urgentall')}}" target="_blank">
                                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            </div>   
             <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted fw-medium">ปกติ</h5>
                                                        <h5 class="mb-0">{{$hd4}} ครั้ง/{{number_format($cost4)}} บาท</h5>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <a href="{{url('/report-machine-normalall')}}" target="_blank">
                                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            </div>                 
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">การให้บริการ</h4>

                                        <div class="text-center">
                                            <div class="mb-4">
                                                <i class="bx bx-map-pin text-primary display-4"></i>
                                            </div>
                                            <h3>{{$hd5}}</h3>
                                            <p>ทั้งหมด</p>
                                        </div>

                                        <div class="table-responsive mt-4">
                                            <table class="table align-middle table-nowrap">
                                                <tbody>
                                                   <tr data-bs-toggle="modal" data-bs-target="#pendingModal1" style="cursor: pointer;">
                                                        <td style="width: 30%">
                                                            <p class="mb-0">งานรอดำเนินการ</p>
                                                        </td>
                                                        <td style="width: 25%">
                                                            <h5 class="mb-0">{{$hd6}}</h5>
                                                        </td>
                                                    </tr>
                                                    <tr data-bs-toggle="modal" data-bs-target="#pendingModal2" style="cursor: pointer;">
                                                        <td>
                                                            <p class="mb-0">กำลังดำเนินการ</p>
                                                        </td>
                                                        <td>
                                                            <h5 class="mb-0">{{$hd7}}</h5>
                                                        </td>                                                      
                                                    </tr>
                                                    <tr data-bs-toggle="modal" data-bs-target="#pendingModal3" style="cursor: pointer;">
                                                        <td>
                                                            <p class="mb-0">ปิดงานเรียบร้อย</p>
                                                        </td>
                                                        <td>
                                                            <h5 class="mb-0">{{$hd8}}</h5>
                                                        </td>                                                      
                                                    </tr>
                                                     <tr>
                                                        <td>
                                                            <p class="mb-0">ยกเลิกงาน</p>
                                                        </td>
                                                        <td>
                                                            <h5 class="mb-0">{{$hd9}}</h5>
                                                        </td>                                                      
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                </div> 
                <div class="col-md-8">
                    <div class="card">
                            <div class="card-body">
                                 <h4 class="card-title mb-4">งบประมาณที่ใช้</h4>
                                        <div class="row text-center">
                                            <div class="col-4">
                                            </div>
                                            <div class="col-4">
                                                <h5 class="mb-0">฿ {{ number_format($totalCost, 2) }}</h5>
                                                <p class="text-muted text-truncate">ทั้งหมด</p>
                                            </div>
                                            <div class="col-4">                                              
                                            </div>
                                        </div>       
                                        <canvas id="bar-mtn" style="height: 300px; max-height: 300px; width: 100%;"></canvas>
                            </div>
                    </div>              
                </div>
        </div>
        <div class="row">
              <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">เครื่องจักร</h4>
                            <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 text-center table-sm">
                                <thead>
                                    <tr>
                                        <th>เครื่องจักร</th>
                                        <th>การแจ้งซ่อม (ครั้ง)</th>
                                        <th>หยุดเครื่อง (นาที)</th>
                                        <th>ค่าใช้จ่าย (บาท)</th>
                                        <th>ซ่อมด่วน (ครั้ง)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mc as $item)
                                        <tr>
                                            <td>
                                                <img src="{{ asset($item->pic1 ?? 'images/no-image.png') }}" alt="Machine Image" class="rounded-circle avatar-xl"><br>
                                                {{$item->code}}/{{$item->name}}
                                            </td>
                                            <td>{{ number_format($item->mc_qty, 0) }}</td>
                                            <td>{{ number_format($item->mc_time, 2) }}</td>
                                            <td>{{ number_format($item->mc_cost, 2) }}</td>
                                            <td>{{ number_format($item->qty_urgent, 0) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
              </div>
        </div>
        <div class="row">
             <div class="col-md-6">
                    <div class="card">
                            <div class="card-body">
                                 <h4 class="card-title mb-4">กลุ่มเครื่องจักร</h4>
                                 <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>กลุ่ม</th>
                                            <th>ค่าใช้จ่าย</th>
                                            <th>%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($gpCost as $groupName => $totalCost)
                                        @php
                                            $percent = $totalSum > 0 ? ($totalCost / $totalSum) * 100 : 0;
                                        @endphp
                                        <tr>
                                            <td>{{ $groupName }}</td>
                                            <td>{{ number_format($totalCost, 2) }}</td>
                                            <td style="min-width: 100px;">
                                                <div class="progress bg-light rounded" style="height: 20px;">
                                                    <div class="progress-bar bg-success" role="progressbar" 
                                                        style="width: {{ $percent }}%; font-weight: 500; font-size: 1rem; color: white; display: flex; align-items: center; justify-content: center;" 
                                                        aria-valuenow="{{ $percent }}" 
                                                        aria-valuemin="0" 
                                                        aria-valuemax="100">
                                                        {{ number_format($percent, 2) }}%
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                 </table>
                            </div>
                    </div>
             </div>
             <div class="col-md-6">
                    <div class="card">
                            <div class="card-body">
                                 <h4 class="card-title mb-4">พนักงานซ่อม</h4>
                                 <table class="table table-bordered text-center">
                                    <thead>
                                        <tr>
                                            <th>ชื่อ - นามสกุล</th>
                                            <th>งานปกติ</th>
                                            <th>งานด่วน</th>
                                            <th>รวม</th>
                                        </tr>
                                    </thead>
                                    <tbody>   
                                        @foreach ($empQty as $item)
                                            <tr>
                                                <td>{{ $item->code}}</td>
                                                <td>{{ number_format($item->qty_normal, 0) }}</td>
                                                <td>{{ number_format($item->qty_urgent, 0) }}</td>
                                                <td>{{ number_format($item->qty_total, 0) }}</td>
                                            </tr>
                                        @endforeach                              
                                    </tbody>
                                 </table>
                            </div>
                    </div>
             </div>
        </div>
<!-- Popup Modal -->
<div class="modal fade" id="pendingModal1" tabindex="-1" aria-labelledby="pendingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg: ขนาดใหญ่ -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pendingModalLabel">รายละเอียดงานรอดำเนินการ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>ผู้แจ้ง</th>
                    <th>เครื่อง</th>
                    <th>ประเภท</th>
                    <th>อาการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingJobs1 as $job)
                    <tr>
                        <td>{{ $job->machine_repair_dochd_date }}</td>
                        <td>{{ $job->machine_repair_dochd_docuno }}</td>
                        <td>{{ $job->person_at }}</td>
                        <td>{{ $job->machine_code }}</td>
                        <td>{{ $job->machine_repair_dochd_type }}</td>
                        <td>{{ $job->machine_repair_dochd_case }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
<!-- Popup Modal -->
<div class="modal fade" id="pendingModal2" tabindex="-1" aria-labelledby="pendingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg: ขนาดใหญ่ -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pendingModalLabel">รายละเอียดงานรอดำเนินการ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>ผู้แจ้ง</th>
                    <th>เครื่อง</th>
                    <th>ประเภท</th>
                    <th>อาการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingJobs2 as $job)
                    <tr>
                        <td>{{ $job->machine_repair_dochd_date }}</td>
                        <td>{{ $job->machine_repair_dochd_docuno }}</td>
                        <td>{{ $job->person_at }}</td>
                        <td>{{ $job->machine_code }}</td>
                        <td>{{ $job->machine_repair_dochd_type }}</td>
                        <td>{{ $job->machine_repair_dochd_case }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
<!-- Popup Modal -->
<div class="modal fade" id="pendingModal3" tabindex="-1" aria-labelledby="pendingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg: ขนาดใหญ่ -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pendingModalLabel">รายละเอียดงานรอดำเนินการ</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="ปิด"></button>
      </div>
      <div class="modal-body">
        <table class="table">
            <thead>
                <tr>
                    <th>วันที่</th>
                    <th>เลขที่</th>
                    <th>ผู้แจ้ง</th>
                    <th>เครื่อง</th>
                    <th>ประเภท</th>
                    <th>อาการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pendingJobs3 as $job)
                    <tr>
                        <td>{{ $job->machine_repair_dochd_date }}</td>
                        <td>{{ $job->machine_repair_dochd_docuno }}</td>
                        <td>{{ $job->person_at }}</td>
                        <td>{{ $job->machine_code }}</td>
                        <td>{{ $job->machine_repair_dochd_type }}</td>
                        <td>{{ $job->machine_repair_dochd_case }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
      </div>
    </div>
  </div>
</div>
</div>
</div>
@php
    $costArray = $cost->toArray();
@endphp
@endsection
@section('script')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('bar-mtn').getContext('2d');

    const labels = {!! json_encode(array_keys($costArray)) !!};
    const data = {!! json_encode(array_values($costArray)) !!};
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'ค่าใช้จ่ายรวม (บาท)',
                data: data,
                backgroundColor: 'rgba(40, 167, 69, 0.8)',
                borderColor: 'rgb(40, 167, 69)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            legend: { display: false },
            tooltips: {
                callbacks: {
                    label: function(tooltipItem) {
                        return '฿ ' + tooltipItem.yLabel;
                    }
                }
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        callback: function(value) {
                            return '฿ ' + value;
                        }
                    }
                }]
            }
        }
    });
});
$(document).ready(function() {
    $('#DataTableList').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "order": [[1, "desc"]], // <-- เรียงวันที่ล่าสุดก่อน
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
</script>
@endsection