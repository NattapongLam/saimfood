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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>บัญชีรายชื่อเครื่องมือวัด</h5>
                                <div class="page-title-right">
                                    <h5 class="my-0 text-primary">
                                        <a href="{{route('clb-measuringlist.create')}}">
                                            เพิ่มข้อมูล
                                        </a>
                                    </h5>                  
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row"> 
                                    <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 text-center table-sm">
                                        <thead>
                                            <tr>
                                                <th>ลำดับ</th>
                                                <th>รูปภาพ</th>
                                                <th>หมายเลขเครื่องมือวัด</th>
                                                <th>ชื่อเครื่องมือวัด</th>
                                                <th>ยี่ห้อ</th>
                                                <th>รุ่น(Model)</th>
                                                <th>Serial No</th>
                                                <th>ฝ่าย/แผนกที่ใช้งาน/จุดประจำ</th>
                                                <th>ช่วงใช้งานจริง</th>
                                                <th>ความละเอียด</th>
                                                <th>เกณฑ์ยอมรับ</th>
                                                <th>เริ่มใช้งาน</th>                        
                                                <th>แก้ไข</th>
                                                <th>ยกเลิก</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                           @foreach ($hd as $item)
                                               <tr>
                                                    <td>{{$item->clb_measuring_lists_listno}}</td>
                                                    <td>
                                                         <img src="{{ asset($item->clb_measuring_lists_file1 ?? 'images/no-image.png') }}" alt="Measuring Image" class="rounded-circle avatar-xl">
                                                    </td>
                                                    <td>{{$item->clb_measuring_lists_code}}</td>
                                                    <td>{{$item->clb_measuring_lists_name}}</td>
                                                    <td>{{$item->clb_measuring_lists_brand}}</td>
                                                    <td>{{$item->clb_measuring_lists_model}}</td>
                                                    <td>{{$item->clb_measuring_lists_serialno}}</td>
                                                    <td>{{$item->clb_measuring_lists_department}}</td>
                                                    <td>{{$item->actualuseperiod}}</td>
                                                    <td>{{$item->resolution}}</td>
                                                    <td>{{$item->acceptancecriteria}}</td>
                                                    <td>{{$item->clb_measuring_lists_start}}</td>                                                   
                                                    <td>
                                                        <a href="{{ route('clb-measuringlist.edit', $item->clb_measuring_lists_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->clb_measuring_lists_id }}')"><i class="fas fa-trash"></i></a>    
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
        "order": [[0, "asc"]], // <-- เรียงวันที่ล่าสุดก่อน
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
            url: `{{ url('/confirmDelMasterlist') }}`,
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