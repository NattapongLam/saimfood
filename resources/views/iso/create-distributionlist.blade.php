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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบควบคุมการแจกจ่ายเอกสาร</h5>
                                    @if ($hd->iso_master_lists_file1)
                                      <a href="{{ asset($hd->iso_master_lists_file1) }}" target="_blank"><i class="bx bxs-file"></i></a>   
                                    @endif
                            </div>
                            <form class="custom-validation" action="{{ route('iso-distributionlist.store') }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="form-label">หมายเลขเอกสาร</label>
                                            <input class="form-control" name="iso_master_lists_docuno" value="{{$hd->iso_master_lists_docuno}}" readonly>
                                            <input type="hidden" name="iso_master_lists_id" value="{{$hd->iso_master_lists_id}}">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อเอกสาร</label>
                                            <input class="form-control" name="iso_master_lists_name" value="{{$hd->iso_master_lists_name}}" readonly>
                                        </div>
                                    </div>  
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="form-label">ฝ่าย/แผนกถือครองเอกสาร</label>
                                            <input class="form-control" name="iso_master_lists_department" value="{{$hd->iso_master_lists_department}}" readonly>
                                        </div>
                                    </div>  
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="form-label">แก้ไขครั้งที่</label>
                                            <input class="form-control" name="iso_master_lists_rev" value="{{$hd->iso_master_lists_rev}}" readonly>
                                        </div>
                                    </div> 
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ประเภท</label>
                                            <select class="form-control" name="ms_documenttype_name">
                                                <option value="">กรุณาเลือก</option>
                                                @foreach ($sta as $item)
                                                   <option value="{{$item->ms_documenttype_name}}">{{$item->ms_documenttype_name}}</option> 
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">วันที่แจกจ่าย</label>
                                            <input class="form-control" type="date" name="iso_distribution_lists_date">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ผู้รับเรื่อง</label>
                                            <select class="form-control select2" name="iso_distribution_lists_empcode">
                                                <option value="">กรุณาเลือก</option>
                                                @foreach ($emp as $item)
                                                        <option value="">กรุณาเลือก</option>
                                                        <option value="{{ $item->personcode }}">
                                                            {{ $item->personfullname }} ({{ $item->position }})
                                                        </option>
                                                @endforeach
                                            </select>
                                        </div>
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
                            </form>
                        </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <h5>รายการการดำเนินการ</h5>
                <div class="row">
                    <div class="col-12">
                        <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 text-center table-sm">
                            <thead>
                                <tr>
                                    <th>สถานะ</th>
                                    <th>ประเภท</th>
                                    <th>วันที่แจกจ่าย</th>
                                    <th>ผู้รับเรื่อง</th>
                                    <th>รับทราบ</th>
                                    <th>ยกเลิก</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $item)
                                    <tr>
                                        <td>
                                            @if ($item->iso_distribution_lists_status == "N")
                                                <span class="badge-soft-warning">รอดำเนินการ</span>
                                            @else
                                                <span class="badge-soft-success">ดำเนินการเรียบร้อย</span>
                                            @endif
                                        </td>
                                        <td>{{$item->ms_documenttype_name}}</td>
                                        <td>{{$item->iso_distribution_lists_date}}</td>
                                        <td>{{$item->iso_distribution_lists_person}}</td>
                                        <td>
                                            @if($item->iso_distribution_lists_status == "N")
                                                @if ($item->iso_distribution_lists_empcode == auth()->user()->username)
                                                    <a href="javascript:void(0)" class="btn btn-primary btn-sm" onclick="confirmApproved('{{ $item->iso_distribution_lists_id }}')"><i class="bx bx-edit-alt"></i></a>   
                                                @endif
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->iso_distribution_lists_status == "N")
                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->iso_distribution_lists_id }}')"><i class="fas fa-trash"></i></a>    
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
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('.select2').select2({
        placeholder: "กรุณาเลือก",
        allowClear: true
    });
});
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
            url: `{{ url('/confirmDelDistributionlist') }}`,
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
confirmApproved = (refid) =>{
Swal.fire({
    title: 'คุณแน่ใจหรือไม่ !',
    text: `คุณต้องการรับเรื่องรายการนี้หรือไม่ ?`,
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
            url: `{{ url('/approvedDistributionlist') }}`,
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
                        text: 'รับเรื่องรายการเรียบร้อยแล้ว',
                        icon: 'success'
                    }).then(function() {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'รับเรื่องรายการไม่สำเร็จ',
                        icon: 'error'
                    });
                }
               
            },
            error: function(data) {
                Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'รับเรื่องรายการไม่สำเร็จ',
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