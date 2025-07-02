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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ตั้งค่าตรวจเช็คตามแผน</h5>
                             <div class="page-title-right">
                            <h5 class="my-0 text-primary">
                                <a href="{{route('machine-planings.create')}}">
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
                                                <th>รูปภาพ</th>
                                                <th>เครื่องจักร</th>
                                                <th>หมายเหตุ</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hd as $item)
                                               <tr>
                                                    <td>
                                                        @if ($item->machine_planing_hd_flag)
                                                            <span class="badge bg-success">ใช้งาน</span>
                                                        @else
                                                            <span class="badge bg-danger">ไม่ใช้งาน</span>
                                                        @endif             
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset($item->machine_pic1 ?? 'images/no-image.png') }}" alt="Machine Image" class="rounded-circle avatar-xl">
                                                    </td>
                                                    <td>
                                                        {{$item->machine_code}}/{{$item->machine_name}}
                                                    </td>
                                                    <td>
                                                        {{$item->machine_planing_hd_note}}
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('machine-planings.edit', $item->machine_planing_hd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> แก้ไข</a>                                                      
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->machine_planing_hd_id }}')"><i class="fas fa-trash"></i></a>   
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
            url: `{{ url('/confirmDelMachinePlaningHd') }}`,
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