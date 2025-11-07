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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>พนักงานทั้งหมด</h5>
                            </div>
                            <div class="card-body">
                                <div class="row"> 
                                     <table id="DataTableList" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>รหัสพนักงาน</th>
                                                <th>ชื่อ - นามสกุล</th>
                                                <th>แผนก</th>
                                                <th>ตำแหน่ง</th>
                                                <th>บริษัท</th>
                                                <th>สมุดสุขภาพ</th>
                                            </tr>
                                        </thead>
                                        <tbody> 
                                            @foreach ($emp as $item)
                                                <tr>
                                                    <td>{{$item->personcode}}</td>
                                                    <td>{{$item->personfullname}}</td>
                                                    <td>{{$item->department}}</td>
                                                    <td>{{$item->position}}</td>
                                                    <td>{{$item->company}}</td>
                                                    <td>
                                                        <a href="{{route('employees.show',$item->personcode)}}"
                                                        class="btn btn-sm btn-info">
                                                        <i class="fas fa-user"></i>
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