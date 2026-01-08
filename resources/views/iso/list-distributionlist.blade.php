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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบควบคุมการแจกจ่ายเอกสาร</h5>
                                <div class="page-title-right">
                                    <h5 class="my-0 text-primary">
                                        <a href="{{route('iso-distributionlist.show',auth()->user()->username)}}">
                                           ตรวจสอบเอกสารแจกจ่าย
                                        </a>
                                    </h5>                  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row"> 
                                    <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 text-center table-sm">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>DAR No.</th>
                                                <th>หมายเลขเอกสาร</th>
                                                <th>ชื่อเอกสาร</th>
                                                <th>ฝ่าย/แผนก</th>
                                                <th>แก้ไขครั้งที่</th>
                                                <th>วันที่บังคับใช้</th>
                                                <th>ระยะเวลาการจัดเก็บ</th>
                                                <th>หมายเหตุ</th>
                                                <th>แจกจ่าย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hd as $item)
                                                <tr>
                                                    <td>{{$item->iso_master_lists_listno}}</td>
                                                    <td>{{$item->iso_master_lists_refdocu}}</td>
                                                    <td>
                                                        <a href="{{ asset($item->iso_master_lists_file1)}}" target="_blank" class="text-dark">
                                                            {{$item->iso_master_lists_docuno}}
                                                        </a>
                                                    </td>
                                                    <td>{{$item->iso_master_lists_name}}</td>
                                                    <td>{{$item->iso_master_lists_department}}</td>
                                                    <td>{{$item->iso_master_lists_rev}}</td>
                                                    <td>{{$item->iso_master_lists_date}}</td>
                                                    <td>{{$item->iso_master_lists_timeline}}</td>
                                                    <td>{{$item->iso_master_lists_remark}}</td>
                                                    <td>
                                                        <a href="{{ route('iso-distributionlist.edit', $item->iso_master_lists_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i></a>
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
        </div>
    </div>
</div>
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