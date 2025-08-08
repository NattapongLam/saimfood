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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบขอย้ายอุปกรณ์ลูกค้า</h5>
                                <div class="page-title-right">  
                                    <h5 class="my-0 text-primary">
                                        <a href="{{route('customer-transfer.create')}}">
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
                                            <th>ลูกค้า</th>
                                            <th>ที่อยู่</th>
                                            <th>ผู้ติดต่อ</th>
                                            <th>อุปกรณ์</th>
                                            <th></th>
                                        </tr>                                    
                                    </thead>
                                    <tbody>
                                        @foreach ($hd as $item)
                                            <tr>
                                                <td>{{$item->customer_transfer_status_name}}</td>
                                                <td>{{$item->customer_fullname}}</td>
                                                <td>{{$item->customer_address}}</td>
                                                <td>{{$item->contact_person}} {{$item->contact_tel}}</td>
                                                <td>{{$item->equipment_code}} {{$item->equipment_name}} ({{$item->req_customer_fullname}})</td>
                                                <td>
                                                    @if ($item->customer_transfer_status_id == 1)
                                                        <a href="{{ route('customer-transfer.edit', $item->customer_transfer_docu_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> อัพเดท</a>
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