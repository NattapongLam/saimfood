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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งซ่อมลูกค้า</h5>
                                <div class="page-title-right">                                                    
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
                                            <th>ที่อยู่</th>
                                            <th>ผู้ติดต่อ</th>
                                            <th>อุปกรณ์</th>
                                            <th>อาการ</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($case as $item)
                                            <tr>
                                                <td>{{$item->customer_repair_status_name}}</td>
                                                <td>
                                                    {{$item->customer_repair_docu_docuno}}<br>
                                                   {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d/m/Y H:i') : '-' }}
                                                </td>
                                                <td>{{$item->customer_fullname}}</td>
                                                <td>{{$item->customer_address}}</td>
                                                <td>{{$item->contact_person}}<br>{{$item->contact_tel}}</td>
                                                <td>{{$item->equipment_code}}<br>{{$item->equipment_name}}</td>
                                                <td>{{$item->customer_repair_docu_case}}</td>
                                                <td>
                                                     <a href="{{ route('equipment-repair.edit', $item->customer_repair_docu_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> อัพเดท</a>
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