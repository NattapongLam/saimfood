@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            
            <div class="card-header bg-white border-bottom border-light py-3">
                @if(Session::has('error'))
                    <div class="alert alert-danger alert-block shadow-sm">
                        <strong>{{ Session::get('error') }}</strong>
                    </div>
                @endif
                @if(Session::has('success'))
                    <div class="alert alert-success alert-block shadow-sm">
                        <strong>{{ Session::get('success') }}</strong>
                    </div>
                @endif 

                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h5 class="my-0 text-primary fw-semibold">
                        <i class="mdi mdi-bullseye-arrow me-2 text-danger"></i>ใบแจ้งดำเนินการแก้ไข (Corrective Action Request : CAR)
                    </h5>
                    <div class="page-title-right">
                        <a href="{{route('iso-carlist.create')}}" class="btn btn-primary btn-sm px-3 rounded-pill shadow-sm">
                            <i class="bx bx-plus me-1"></i>เพิ่มข้อมูล CAR
                        </a>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive"> 
                    <table id="DataTableList" class="table table-bordered table-striped table-hover align-middle mb-0" style="width:100%">
                        <thead class="table-light text-secondary text-center align-middle fs-7">
                            <tr>
                                <th rowspan="2" style="width: 4%">ลำดับ</th> 
                                <th rowspan="2" style="width: 10%">เลขที่ใบ CAR</th> 
                                <th rowspan="2" style="width: 9%">วันที่ออก CAR</th> 
                                <th colspan="2" class="bg-primary bg-opacity-10 text-primary fw-bold" style="width: 16%">ผู้ดำเนินการ</th>
                                <th colspan="2" class="bg-info bg-opacity-10 text-info fw-bold" style="width: 16%">ครั้งที่ 1</th>
                                <th colspan="2" class="bg-warning bg-opacity-10 text-dark fw-bold" style="width: 16%">ครั้งที่ 2</th>
                                <th rowspan="2" style="width: 9%">วันที่ปิด CAR</th>
                                <th rowspan="2" style="width: 10%">หมายเหตุ</th>
                                <th rowspan="2" style="width: 8%">สถานะ</th>
                                <th rowspan="2" style="width: 12%">การจัดการ</th>
                                <th rowspan="2" style="width: 4%">ลบ</th> 
                            </tr>
                            <tr>
                                <th class="bg-primary bg-opacity-10 text-primary">ผู้แก้ไข</th>
                                <th class="bg-primary bg-opacity-10 text-primary">ผู้ติดตาม</th>
                                <th class="bg-info bg-opacity-10 text-info">กำหนดเสร็จ</th>
                                <th class="bg-info bg-opacity-10 text-info">วันที่ติดตาม</th>
                                <th class="bg-warning bg-opacity-10 text-dark">กำหนดเสร็จ</th>
                                <th class="bg-warning bg-opacity-10 text-dark">วันที่ติดตาม</th>
                            </tr>
                        </thead>
                        <tbody class="text-secondary text-center" style="font-size: 13px;">
                            @foreach ($hd as $key => $item)
                                <tr>
                                    <td class="fw-medium text-dark">{{$key + 1}}</td>
                                    <td class="fw-bold text-dark text-nowrap">{{$item->iso_car_lists_docuno}}</td>
                                    <td class="text-nowrap">{{$item->iso_car_lists_date}}</td>
                                    <td class="text-dark">{{$item->iso_car_lists_person}}</td>
                                    <td>-</td>
                                    <td class="text-nowrap text-danger fw-medium">{{$item->cause_duedate ?? '-'}}</td>
                                    <td class="text-nowrap">{{$item->measuresone_correction_date ?? '-'}}</td>
                                    <td class="text-nowrap text-danger fw-medium">{{$item->measuresone_date ?? '-'}}</td>
                                    <td class="text-nowrap">{{$item->measurestwo_correction_date ?? '-'}}</td>
                                    <td class="text-nowrap fw-bold text-success">{{$item->car_management_date ?? '-'}}</td>
                                    <td class="text-start text-muted text-wrap" style="max-width: 140px;">{{$item->car_remark ?? '-'}}</td>
                                    <td>
                                        @if ($item->status == 1)
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20 px-2 py-1">ส่งคำร้องขอ</span> 
                                        @elseif($item->status == 2)
                                            <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info border-opacity-20 px-2 py-1">ตอบกลับปัญหา</span> 
                                        @elseif($item->status == 3)
                                            <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-2 py-1">ติดตามการแก้ไข</span> 
                                        @elseif($item->status == 4)
                                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-2 py-1">อนุมัติการแก้ไข</span>
                                        @elseif($item->status == 5)
                                            <span class="badge rounded-pill text-white px-2 py-1" style="background-color: #6f42c1;">ติดตามผล</span>
                                        @elseif($item->status == 6)
                                            <span class="badge rounded-pill text-white px-2 py-1" style="background-color: #fd7e14;">ตรวจสอบผล</span>
                                        @elseif($item->status == 7)
                                            <span class="badge rounded-pill text-white px-2 py-1" style="background-color: #20c997;">อนุมัติผล</span>
                                        @elseif($item->status == 8)
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2 py-1"><i class="bx bx-check-circle me-1"></i>เรียบร้อย</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-inline-flex gap-1">
                                            @if (auth()->user()->username == "660223125" || auth()->user()->username == "admin" || auth()->user()->username == "670304216")
                                                <a href="{{ route('iso-carlist.show', $item->iso_car_lists_id) }}" class="btn btn-sm btn-outline-danger btn-icon" title="แก้ไขข้อมูลพื้นฐาน"><i class="bx bx-edit"></i></a>
                                            @endif

                                            @if ($item->status == 1)
                                                <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}" class="btn btn-warning btn-sm text-dark px-2 text-nowrap">วิเคราะห์</a>
                                            @elseif($item->status == 2)
                                                <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}" class="btn btn-primary btn-sm px-2 text-nowrap">ติดตามวิเคราะห์</a>
                                            @elseif($item->status == 3)
                                                <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}" class="btn btn-info btn-sm text-dark px-2 text-nowrap">ฝ่ายบริหาร</a>
                                            @elseif($item->status == 4)
                                                <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}" class="btn btn-warning btn-sm text-dark px-2 text-nowrap">ติดตามผล</a>
                                            @elseif($item->status == 5)
                                                <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}" class="btn btn-primary btn-sm px-2 text-nowrap">ทบทวนติดตาม</a>
                                            @elseif($item->status == 6)
                                                <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}" class="btn btn-info btn-sm text-dark px-2 text-nowrap">ฝ่ายบริหาร</a>
                                            @elseif($item->status == 7)
                                                <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}" class="btn btn-warning btn-sm text-dark px-2 text-nowrap">สรุปผล</a>
                                            @elseif($item->status == 8)
                                                <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}" class="btn btn-success btn-sm px-2 text-nowrap">รายละเอียด</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-link link-danger btn-sm p-0" onclick="confirmDel('{{ $item->iso_car_lists_id }}')" title="ลบรายการ">
                                            <i class="fas fa-trash-alt fs-6"></i>
                                        </button>    
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .table th { font-weight: 600 !important; padding: 10px 6px !important; font-size: 13px; }
    .table td { padding: 8px 6px !important; }
    .badge { font-weight: 500; font-size: 11px; }
    .btn-icon { width: 28px; height: 28px; display: inline-flex; align-items: center; justify-content: center; padding: 0; border-radius: 4px; }
    .fs-7 { font-size: 12.5px !important; }
</style>
@endsection

@section('script')
<script>
$(document).ready(function() {
    $('#DataTableList').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 50, 
        "order": [[0, "asc"]], 
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
            "zeroRecords": "ไม่พบข้อมูลใบ CAR",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูลในระบบ",
            "search": "ค้นหาด่วน:",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "<i class='bx bx-chevron-right'></i>",
                "previous": "<i class='bx bx-chevron-left'></i>"
            }
        }
    });
});

confirmDel = (refid) => {
    Swal.fire({
        title: 'ยืนยันการลบข้อมูล?',
        text: "คุณต้องการลบข้อมูลใบ CAR รายการนี้ใช่หรือไม่? เมื่อลบแล้วข้อมูลจะหายไปจากระบบ",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'ใช่, ฉันต้องการลบ',
        cancelButtonText: 'ยกเลิก',
        customClass: {
            confirmButton: 'btn btn-danger me-2 px-3',
            cancelButton: 'btn btn-light px-3'
        },
        buttonsStyling: false         
    }).then(function(result) {
        if (result.value) {
            $.ajax({
                url: `{{ url('/confirmDelCarlist') }}`,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "refid": refid,               
                },           
                dataType: "json",
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            title: 'ลบสำเร็จ',
                            text: 'ระบบทำการลบใบ CAR เรียบร้อยแล้ว',
                            icon: 'success'
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'ไม่สำเร็จ',
                            text: 'ลบรายการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง',
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถเชื่อมต่อฐานข้อมูลได้',
                        icon: 'error'
                    });
                }
            });
        }
    });
}
</script>
@endsection