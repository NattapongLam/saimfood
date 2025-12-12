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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบรับอะไหล่</h5>
                                <div class="page-title-right">
                                    <h5 class="my-0 text-primary">
                                        <a href="{{route('machine-issue-docus.create')}}">
                                            เพิ่มข้อมูล
                                        </a>
                                    </h5>                  
                                </div>
                            </div>
                            <form method="GET" class="form-horizontal">
                            @csrf
                                <div class="row">                              
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="date" class="form-control" name="datestart" value="{{$datestart}}">
                                            </div>                                          
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="date" class="form-control" name="dateend" value="{{$dateend}}">
                                            </div>                                          
                                        </div>
                                        <div class="col-3">
                                             <div class="form-group">
                                                <button class="btn btn-info w-lg">
                                                    <i class="fas fa-search"></i> ค้นหา
                                                </button>
                                             </div>                                          
                                        </div>                                
                                </div>
                            </form>
                            <div class="card-body">
                                <div class="row"> 
                                    <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 text-center table-sm">
                                        <thead>
                                            <tr>
                                                <th>สถานะ</th>
                                                <th>วันที่</th>
                                                <th>เลขที่</th>
                                                <th>ผู้จำหน่าย</th>
                                                <th>ผู้ดำเนินการ</th>
                                                <th>ผู้อนุมัติ</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hd as $item)
                                                <tr>
                                                    <td>
                                                       {{$item->machine_issuestock_statuses_name}}                                     
                                                    </td>
                                                    <td>{{$item->machine_issuestock_hd_date}}</td>
                                                    <td>{{$item->machine_issuestock_hd_docuno}}</td>
                                                    <td>                                                     
                                                        {{$item->machine_issuestock_hd_vendor}}
                                                    </td>
                                                    <td>{{$item->person_at}}</td>
                                                    <td>
                                                        @if ($item->approved_at == null)
                                                            <a href="{{ route('machine-issue-docus.show', $item->machine_issuestock_hd_id) }}"class="btn btn-primary btn-sm"><i class="bx bx-edit-alt"></i> อนุมัติ</a>
                                                        @else
                                                            {{$item->approved_at}}
                                                        @endif
                                                        
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('machine-issue-docus.edit', $item->machine_issuestock_hd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> แก้ไข</a>
                                                    </td>
                                                    <td>
                                                         <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->machine_issuestock_hd_id }}')"><i class="fas fa-trash"></i></a>                                                                
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
confirmDel = (refid) =>{
Swal.fire({
    title: 'คุณแน่ใจหรือไม่ !',
    text: `คุณต้องการลบรายการนี้หรือไม่ ?`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'ยืนยัน',
    cancelButtonText: 'ยกเลิก',
    confirmButtonClass: 'btn btn-success',
    cancelButtonClass: 'btn btn-danger',
    buttonsStyling: false         
}).then(function(result) {
    if (result.value) {
        $.ajax({
            url: `{{ url('/confirmDelMachineIssueStock') }}`,
            type: "POST",
            data: {
                "_token": "{{ csrf_token() }}",
                "refid": refid,               
            },           
            dataType: "json",
            success: function(data) {
                // console.log(data);
                if (data.status == true) {
                    Swal.fire({
                        title: 'สำเร็จ',
                        text: 'ยกเลิกรายการเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกรายการไม่สำเร็จ',
                        icon: 'error'
                    });
                }
               
            },
            error: function(data) {
                Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ยกเลิกรายการไม่สำเร็จ',
                        icon: 'error'
                    });            }
        });

    } else if ( // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel) {
        Swal.fire({
            title: 'ยกเลิก',
            text: 'โปรดตรวจสอบข้อมูลอีกครั้งเพื่อความถูกต้อง :)',
            icon: 'error'
        });
    }
});
}
</script>
@endsection