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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบมาตรฐานของเครื่องจักร</h5>
                            <div class="page-title-right">
                                <h5 class="my-0 text-primary">
                                    <a href="{{route('machines.create')}}">
                                        เพิ่มข้อมูล
                                    </a>
                                </h5>                  
                            </div>
                            </div>
        <div class="card">
            <div class="card-body">
                <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                    <thead>
                        <tr>
                            <th>สถานะ</th>
                            <th>Qr Code</th>
                            <th>รูปภาพ</th>
                            <th>รหัสเครื่องจักรและอุปกรณ์</th>
                            <th>ชื่อเครื่องจักรและอุปกรณ์</th>
                            <th>วันที่ซื้อ/ผลิต</th>
                            <th>กลุ่มเครื่องจักรและอุปกรณ์</th>
                            <th>Serial Number</th>
                            <th>วันที่หมดประกัน</th>
                            <th>วันที่ซ่อมล่าสุด</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($machine as $item)
                        <tr>
                            <td>
                                @if ($item->machine_flag)
                                    <span class="badge bg-success">ใช้งาน</span>
                                @else
                                    <span class="badge bg-danger">ไม่ใช้งาน</span>
                                @endif                                                          
                            </td>
                            <td>
                                <div style="display: inline-block;">
                                            {!! QrCode::encoding('UTF-8')->size(100)->generate(url('machine-qrcode/'.$item->machine_code)) !!}   
                                </div>
                            </td>
                            <td>
                                <img src="{{ asset($item->machine_pic1 ?? 'images/no-image.png') }}" alt="Machine Image" class="rounded-circle avatar-xl">
                            </td>
                            <td>{{$item->machine_code}}</td>
                            <td>{{$item->machine_name}}</td>                          
                            <td>{{$item->machine_date}}</td>
                            <td>{{$item->machinegroup_name}}</td>
                            <td>{{$item->serial_number}}</td>
                            <td>{{$item->insurance_date}}</td>
                            <td>{{$item->last_repair}}</td>
                            <td>
                                <a href="{{ route('machines.edit', $item->machine_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> แก้ไข</a>
                            </td>
                        </tr>                          
                        @endforeach
                    </tbody>
                </table>               
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
        "order": [[4, "desc"]], // <-- เรียงวันที่ล่าสุดก่อน
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