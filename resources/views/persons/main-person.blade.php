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
                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ผู้ใช้งาน</h5>
                <div class="page-title-right">
                    <h5 class="my-0 text-primary">
                        <a href="{{route('persons.create')}}">
                            เพิ่มผู้ใช้งาน
                        </a>
                    </h5>                  
                </div>
                </div>
                </div>
                 </div>       
            </div>
            <div class="card">          
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive" style="overflow-x:auto;">
                            <table id="DataTableList" class="table table-bordered dt-responsive table-sm" style="width:100%">
                            <thead>
                                <tr>
                                    <th>สถานะ</th>
                                    <th>รหัสพนักงาน</th>
                                    <th>ชื่อ - นามสกุล</th>         
                                    <th>ชื่อผู้ใช้งาน</th>                             
                                    <th>กำหนดสิทธิ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>
                                            @if ($item->status)
                                                <span class="badge bg-success">ใช้งาน</span>
                                            @else
                                                <span class="badge bg-danger">ไม่ใช้งาน</span>
                                            @endif                                                          
                                        </td>
                                        <td>{{$item->employee_code}}</td>
                                        <td>{{$item->employee_fullname}}</td>
                                        <td>{{$item->username}}</td>
                                        <td>
                                            <a href="{{route('permissions.edit',$item->id)}}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-user"></i>
                                            </a> 
                                        </td>
                                        <td>
                                            <a href="{{ route('persons.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
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
        "pageLength": 50, // แสดง 50 รายการต่อหน้า
        "order": [[1, "asc"]], // เรียงวันที่ล่าสุดก่อน
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