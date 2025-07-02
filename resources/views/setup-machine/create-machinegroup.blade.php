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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>กลุ่มเครื่องจักรและอุปกรณ์</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">  
                                    <form class="custom-validation" action="{{ route('machine-groups.store') }}" method="POST" enctype="multipart/form-data" validate>
                                    @csrf                                    
                                    <div class="col-12">      
                                            <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        รหัสกลุ่มเครื่องจักรและอุปกรณ์
                                                    </label>
                                                <input class="form-control" type="text" name="machinegroup_code" required 
                                                oninvalid="this.setCustomValidity('กรุณากรอกรหัสกลุ่มเครื่องจักร')" 
                                                oninput="this.setCustomValidity('')">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="form-label">
                                                        ชื่อกลุ่มเครื่องจักรและอุปกรณ์
                                                    </label>
                                                    <input class="form-control" type="text" name="machinegroup_name" required 
                                                    oninvalid="this.setCustomValidity('กรุณากรอกชื่อกลุ่มเครื่องจักร')" 
                                                    oninput="this.setCustomValidity('')">
                                                </div>
                                            </div> 
                                            </div>                                                                                                                 
                                            <br>
                                            <div class="form-group">
                                                <div class="d-flex flex-wrap gap-2 justify-content">
                                                    <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                                        บันทึก
                                                    </button>
                                                </div>
                                            </div>                                                                                   
                                    </div> 
                                    </form>
                                    <hr>                                              
                                    <div class="col-12">
                                         <table id="DataTableList" class="table table-bordered dt-responsive  nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>สถานะ</th>
                                                    <th>รหัสกลุ่มเครื่องจักรและอุปกรณ์</th>
                                                    <th>ชื่อกลุ่มเครื่องจักรและอุปกรณ์</th>
                                                    <th></th>
                                                </tr>
                                            </thead>       
                                            <tbody>
                                                @foreach ($machinegroup as $item)
                                                    <tr>
                                                        <td>
                                                            @if ($item->machinegroup_flag)
                                                                <span class="badge bg-success">ใช้งาน</span>
                                                            @else
                                                                <span class="badge bg-danger">ไม่ใช้งาน</span>
                                                            @endif                                                          
                                                        </td>
                                                        <td>{{$item->machinegroup_code}}</td>
                                                        <td>{{$item->machinegroup_name}}</td>
                                                        <td>
                                                            <a href="{{ route('machine-groups.edit', $item->machinegroup_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> แก้ไข</a>
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