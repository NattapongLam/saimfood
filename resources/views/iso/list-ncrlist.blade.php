@extends('layouts.main')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0"> <div class="card-header bg-white border-bottom border-light py-3"> <div class="row align-items-center">
                    <div class="col-12">
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
                                <i class="mdi mdi-bullseye-arrow me-2 text-danger"></i>ใบควบคุมใบ NCR (NCR Log Sheet)
                            </h5>
                            <div class="page-title-right">
                                <a href="{{route('iso-ncrlist.create')}}" class="btn btn-primary btn-sm px-3 rounded-pill shadow-sm">
                                    <i class="bx bx-plus me-1"></i>เพิ่มข้อมูล NCR
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0"> <div class="table-responsive"> 
                    <table id="DataTableList" class="table table-striped table-hover align-middle mb-0" style="width:100%">
                        <thead class="table-light text-secondary text-uppercase fs-7 text-center">
                            <tr>
                                <th style="width: 5%">ลำดับ</th>
                                <th style="width: 12%">สถานะ</th>
                                <th style="width: 10%">เลขที่ NCR</th>
                                <th style="width: 10%">วันที่ออก NCR</th>
                                <th style="width: 25%">ปัญหาที่พบ</th>
                                <th style="width: 10%">ผู้รับผิดชอบ</th>
                                <th style="width: 10%">วันที่ปิดเรื่อง</th>
                                <th style="width: 10%">หมายเหตุ</th>
                                <th style="width: 5%">การจัดการ</th>
                                <th style="width: 3%">ลบ</th>
                            </tr>
                        </thead>
                        <tbody class="text-secondary" style="font-size: 13.5px;">
                            @foreach ($hd as $key => $item)
                                <tr>
                                    <td class="text-center fw-medium text-dark">{{$key+1}}</td>
                                    <td class="text-center">
                                        @if ($item->status == 1)
                                            <span class="badge rounded-pill bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-20 px-2 py-1d5">ส่งคำร้องขอ</span> 
                                        @elseif($item->status == 2)
                                            <span class="badge rounded-pill bg-info bg-opacity-10 text-info border border-info border-opacity-20 px-2 py-1d5">ตอบกลับปัญหา</span> 
                                        @elseif($item->status == 3)
                                            <span class="badge rounded-pill bg-warning bg-opacity-10 text-warning border border-warning border-opacity-20 px-2 py-1d5">อนุมัติตอบกลับ</span> 
                                        @elseif($item->status == 4)
                                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-primary border border-primary border-opacity-20 px-2 py-1d5">ดำเนินการแก้ไข</span>
                                        @elseif($item->status == 5)
                                            <span class="badge rounded-pill text-white px-2 py-1d5" style="background-color: #6f42c1;">อนุมัติการแก้ไข</span>
                                        @elseif($item->status == 6)
                                            <span class="badge rounded-pill bg-success bg-opacity-10 text-success border border-success border-opacity-20 px-2 py-1d5"><i class="bx bx-check-circle me-1"></i>เรียบร้อย</span>
                                        @endif
                                    </td>
                                    <td class="text-center fw-bold text-dark">{{$item->iso_ncr_lists_docuno}}</td>
                                    <td class="text-center text-nowrap">{{$item->iso_ncr_lists_date}}</td>
                                    <td class="text-start text-wrap text-dark lh-base" style="max-width: 250px;">{{$item->iso_ncr_lists_problem}}</td>
                                    <td class="text-center">{{$item->iso_ncr_lists_person}}</td>
                                    <td class="text-center text-nowrap">{{$item->iso_ncr_lists_closedate ?? '-'}}</td>
                                    <td class="text-start text-muted" style="max-width: 150px;">{{$item->iso_ncr_lists_remark ?? '-'}}</td>
                                    <td class="text-center">
                                        <div class="d-inline-flex gap-1">
                                            @if (auth()->user()->username == "660223125" || auth()->user()->username == "admin")
                                                <a href="{{ route('iso-ncrlist.show', $item->iso_ncr_lists_id) }}" class="btn btn-sm btn-outline-danger btn-icon" title="แก้ไขข้อมูลหลัก"><i class="bx bx-edit"></i></a>
                                            @endif

                                            @if ($item->status == 1)
                                                <a href="{{ route('iso-ncrlist.edit', $item->iso_ncr_lists_id) }}" class="btn btn-warning btn-sm text-dark text-nowrap">การแก้ไข</a>
                                            @elseif($item->status == 2)
                                                <a href="{{ route('iso-ncrlist.edit', $item->iso_ncr_lists_id) }}" class="btn btn-info btn-sm text-dark text-nowrap">อนุมัติการแก้ไข</a>
                                            @elseif($item->status == 3)
                                                <a href="{{ route('iso-ncrlist.edit', $item->iso_ncr_lists_id) }}" class="btn btn-warning btn-sm text-dark text-nowrap">การดำเนินการ</a>
                                            @elseif($item->status == 4)
                                                <a href="{{ route('iso-ncrlist.edit', $item->iso_ncr_lists_id) }}" class="btn btn-danger btn-sm text-nowrap">เอกสารแนบปิด</a>
                                            @elseif($item->status == 5)
                                                <a href="{{ route('iso-ncrlist.edit', $item->iso_ncr_lists_id) }}" class="btn btn-primary btn-sm text-nowrap">ติดตามและปิด</a>
                                            @elseif($item->status == 6)
                                                <a href="{{ route('iso-ncrlist.edit', $item->iso_ncr_lists_id) }}" class="btn btn-success btn-sm text-nowrap">รายละเอียด</a>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-link link-danger btn-sm p-0" onclick="confirmDel('{{ $item->iso_ncr_lists_id }}')" title="ลบรายการ">
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
    /* CSS เพิ่มเติมเล็กน้อยเพื่อให้ตารางดูสวยงามพรีเมียมขึ้น */
    .table th { font-weight: 600 !important; padding: 12px 8px !important; }
    .table td { padding: 10px 8px !important; }
    .badge { font-weight: 500; font-size: 11.5px; }
    .py-1d5 { padding-top: 0.35rem !important; padding-bottom: 0.35rem !important; }
    .btn-icon { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; padding: 0; border-radius: 6px; }
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
            "zeroRecords": "ไม่พบข้อมูลใบ NCR",
            "info": "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูล",
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
        text: "คุณต้องการลบข้อมูลใบ NCR รายการนี้ใช่หรือไม่? เมื่อลบแล้วจะไม่สามารถกู้คืนได้",
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
                url: `{{ url('/confirmDelNcrlist') }}`,
                type: "POST",
                data: {
                    "_token": "{{ csrf_token() }}",
                    "refid": refid,               
                },           
                dataType: "json",
                success: function(data) {
                    if (data.status == true) {
                        Swal.fire({
                            title: 'ลบข้อมูลสำเร็จ',
                            text: 'ระบบได้ลบรายการนี้เรียบร้อยแล้ว',
                            icon: 'success'
                        }).then(function() {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'เกิดข้อผิดพลาด',
                            text: 'ไม่สามารถลบรายการได้ กรุณาลองใหม่อีกครั้ง',
                            icon: 'error'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'เกิดข้อผิดพลาด',
                        text: 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้',
                        icon: 'error'
                    });
                }
            });
        }
    });
}
</script>
@endsection