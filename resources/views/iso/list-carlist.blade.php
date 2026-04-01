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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งดำเนินการแก้ไข (Corrective Action Request : CAR)</h5>
                                <div class="page-title-right">
                                    <h5 class="my-0 text-primary">
                                        <a href="{{route('iso-carlist.create')}}">
                                            เพิ่มข้อมูล
                                        </a>
                                    </h5>                  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row"> 
                                    <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 text-center table-sm">
                                        <thead>
                                            <tr>
                                                <th>CAR NO</th> 
                                                <th>รายละเอียดที่เกิดปัญหา</th> 
                                                <th>ผิดข้อกำหนดระบบมาตรฐานที่</th> 
                                                <th>ผู้ออกใบแจ้งดำเนินการแก้ไข</th> 
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hd as $item)
                                                <tr>
                                                    <td>
                                                        {{$item->iso_car_lists_docuno}}<br>
                                                        ({{$item->type_name}})
                                                    </td>
                                                    <td>{{$item->iso_car_lists_problem}}</td>
                                                    <td>{{$item->iso_car_lists_requirement}}</td>
                                                    <td>
                                                        {{$item->iso_car_lists_person}}<br>
                                                        {{$item->iso_car_lists_date}}
                                                    </td>
                                                    <td>
                                                        @if ($item->status == 1)
                                                            <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt">วิเคราะห์</i></a>
                                                        @elseif($item->status == 2)
                                                            <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}"class="btn btn-primary btn-sm"><i class="bx bx-edit-alt">ติดตามวิเคราะห์</i></a>
                                                        @elseif($item->status == 3)
                                                            <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}"class="btn btn-info btn-sm"><i class="bx bx-edit-alt">ตัวแทนฝ่ายบริหาร</i></a>
                                                        @elseif($item->status == 4)
                                                            <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt">ติดตามผล</i></a>
                                                        @elseif($item->status == 5)
                                                            <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}"class="btn btn-primary btn-sm"><i class="bx bx-edit-alt">ทบทวนติดตามผล</i></a>
                                                        @elseif($item->status == 6)
                                                            <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}"class="btn btn-info btn-sm"><i class="bx bx-edit-alt">ตัวแทนฝ่ายบริหาร</i></a>
                                                        @elseif($item->status == 7)
                                                            <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt">สรุปผล</i></a>
                                                        @elseif($item->status == 8)
                                                            <a href="{{ route('iso-carlist.edit', $item->iso_car_lists_id) }}"class="btn btn-success btn-sm"><i class="bx bx-edit-alt">รายละเอียด</i></a>
                                                        @endif
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