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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบโอนย้ายอุปกรณ์ลูกค้า</h5>
                             <div class="page-title-right">
                            <h5 class="my-0 text-primary">
                                <a href="{{route('equipment-transfer.create')}}">
                                    เพิ่มข้อมูล
                                </a>
                            </h5>                  
                        </div>
                            </div>
                            <div class="card-body">
                                <div class="row"> 
                                    <table id="DataTableList" class="table table-bordered dt-responsive  nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>สถานะ</th>
                                                <th>วันที่</th>
                                                <th>เลขที่</th>
                                                <th>วันที่ต้องการส่ง</th>
                                                <th>ลูกค้า</th>
                                                <th>ผู้ติดต่อ</th>
                                                <th>ผู้บันทึก</th>
                                                <th>หมายเหตุ</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hd as $item)
                                                <tr>
                                                    <td>
                                                        @if ($item->equipment_transfer_status_id == 1)
                                                            <span class="badge bg-warning">{{$item->equipment_transfer_status_name}}</span>
                                                        @elseif($item->equipment_transfer_status_id == 3)
                                                            <span class="badge bg-danger">{{$item->equipment_transfer_status_name}}</span>
                                                        @elseif($item->equipment_transfer_status_id == 2)
                                                            <span class="badge bg-success">{{$item->equipment_transfer_status_name}}</span>
                                                        @elseif($item->equipment_transfer_status_id == 6)
                                                            <span class="badge bg-primary">{{$item->equipment_transfer_status_name}}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{$item->equipment_transfer_hd_date}}</td>
                                                    <td>
                                                        {{$item->equipment_transfer_hd_docuno}}<br>
                                                        (อ้างอิง : {{$item->equipment_request_docu_docuno}})
                                                    </td>
                                                    <td>{{$item->equipment_request_docu_duedate}}</td>
                                                    <td>{{$item->customer_fullname}}</td>
                                                    <td>{{$item->contact_person}} {{$item->contact_tel}}</td>
                                                    <td>{{$item->person_at}}</td>
                                                    <td>{{$item->equipment_transfer_hd_remark}}</td>
                                                    <td>
                                                        @if ($item->equipment_transfer_status_id == 1)
                                                            <a href="{{ route('equipment-transfer.edit', $item->equipment_transfer_hd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> อัพเดท</a>
                                                        @elseif ($item->equipment_transfer_status_id == 2)
                                                           <a href="{{ route('equipment-transfer.edit', $item->equipment_transfer_hd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> รับเครื่องกลับ</a>
                                                        @endif    
                                                        <br>
                                                        @if ($item->recheck_file)
                                                            <a href="{{ asset($item->recheck_file) }}" target="_blank" class="text-dark"><i class="bx bx-file-blank"></i></a>
                                                        @endif                                                   
                                                    </td>
                                                    <td>
                                                        @if ($item->equipment_transfer_status_id <> 3)
                                                            <a href="{{ route('equipment-transfer.show', $item->equipment_transfer_hd_id) }}"class="btn btn-info btn-sm"><i class="bx bx-task"></i> เอกสาร</a>
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
        "order": [[2, "desc"]], // <-- เรียงวันที่ล่าสุดก่อน
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