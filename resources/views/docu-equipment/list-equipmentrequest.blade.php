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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบร้องขออุปกรณ์</h5>
                                <div class="page-title-right">  
                                    <h5 class="my-0 text-primary">
                                        <a href="{{route('equipment-request.create')}}">
                                            เพิ่มข้อมูล
                                        </a>
                                    </h5>                                                  
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 text-center table-sm">
                                    <thead>
                                        <tr>
                                            <th>สถานะ</th>
                                            <th>เลขที่</th>
                                            <th>ลูกค้า</th>
                                            <th>วันที่ต้องการส่ง</th>
                                            <th>จำนวนเครื่อง</th>
                                            <th>รายละเอียด</th>
                                            <th>ผู้ร้องขอ</th>
                                            <th>ผู้อนุมัติ</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       @foreach ($hd as $item)
                                           <tr>
                                                <td>
                                                    @if ($item->equipment_request_status_id == 1 || $item->equipment_request_status_id == 5)
                                                        <span class="badge bg-warning">{{$item->equipment_request_status_name}}</span>
                                                    @elseif($item->equipment_request_status_id == 2 || $item->equipment_request_status_id == 4)
                                                        <span class="badge bg-danger">{{$item->equipment_request_status_name}}</span>
                                                    @elseif($item->equipment_request_status_id == 3)
                                                        <span class="badge bg-primary">{{$item->equipment_request_status_name}}</span>
                                                    @elseif($item->equipment_request_status_id == 6)
                                                        <span class="badge bg-success">{{$item->equipment_request_status_name}}</span>
                                                    @endif                                                  
                                                </td>
                                                <td>{{$item->equipment_request_docu_docuno}}</td>
                                                <td>{{$item->customer_fullname}}</td>
                                                <td>{{$item->equipment_request_docu_duedate}}</td>
                                                <td>{{$item->equipment_request_doc_qty}}</td>
                                                <td>{{$item->equipment_request_docu_remark}}</td>
                                                <td>{{$item->person_at}}</td>
                                                <td>{{$item->approved_at}}</td>
                                                <td>
                                                    @if ($item->equipment_request_status_id == 1 || $item->equipment_request_status_id == 5)
                                                        <a href="{{ route('equipment-request.edit', $item->equipment_request_docu_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> แก้ไข</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->equipment_request_status_id == 1)
                                                        <a href="{{ route('equipment-request.show', $item->equipment_request_docu_id) }}"class="btn btn-primary btn-sm"><i class="bx bx-edit-alt"></i> อนุมัติ</a>
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