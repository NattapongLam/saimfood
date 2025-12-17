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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งซ่อม</h5>
                                <div class="page-title-right">
                                    <h5 class="my-0 text-primary">
                                        <a href="{{route('machine-repair-docus.create')}}">
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
                                                <th>เครื่องจักร</th>
                                                <th>ประเภท</th>
                                                <th>ปัญหา</th>
                                                <th>ผู้แจ้งซ่อม</th>
                                                <th>ผู้ดำเนินการ</th>
                                                <th></th>
                                                <th></th>
                                                <th>จป.</th>
                                                <th>อนุมัติเบิก</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hd as $item)
                                                <tr>
                                                    <td>
                                                        @if ($item->machine_repair_status_id == 1 || $item->machine_repair_status_id == 9)
                                                            <span class="badge bg-warning">{{$item->machine_repair_status_name}}</span>                                                           
                                                        @elseif($item->machine_repair_status_id == 7 || $item->machine_repair_status_id == 8)
                                                            <span class="badge bg-danger">{{$item->machine_repair_status_name}}</span>   
                                                        @elseif($item->machine_repair_status_id == 6)
                                                            <span class="badge bg-success">{{$item->machine_repair_status_name}}</span>  
                                                        @else
                                                            <span class="badge bg-secondary">{{$item->machine_repair_status_name}}</span>
                                                        @endif                                                      
                                                    </td>
                                                    <td>
                                                        @php
                                                            $start = \Carbon\Carbon::parse($item->accepting_datetime);
                                                            $end   = \Carbon\Carbon::parse($item->repairer_datetime);
                                                            $diff = $start->diff($end);

                                                            $days = $diff->d;
                                                            $hours = $diff->h;
                                                            $minutes = $diff->i;

                                                            $result = '';

                                                            if($days > 0){
                                                                $result .= $days . ' วัน ';
                                                            }

                                                            if($hours > 0){
                                                                $result .= $hours . ' ชั่วโมง ';
                                                            }

                                                            if($minutes > 0){
                                                                $result .= $minutes . ' นาที';
                                                            }

                                                            $result = trim($result);
                                                        @endphp
                                                        <strong>
                                                            วันที่แจ้งซ่อม : {{\Carbon\Carbon::parse($item->machine_repair_dochd_date)->format('d/m/Y')}}<br>
                                                            วันที่รับงาน : {{\Carbon\Carbon::parse($item->accepting_datetime)->format('d/m/Y H:i')}}<br>
                                                            วันที่ซ่อมเสร็จ: {{\Carbon\Carbon::parse($item->repairer_datetime)->format('d/m/Y H:i')}}
                                                        </strong>                                                        
                                                        
                                                    </td>
                                                    <td>
                                                        {{$item->machine_repair_dochd_docuno}}<br>
                                                         <strong>ระยะเวลาซ่อม: {{ $result }}</strong> 
                                                    </td>
                                                    <td>
                                                        <img src="{{ asset($item->machine_pic1 ?? 'images/no-image.png') }}" alt="Machine Image" class="rounded-circle avatar-xl"><br>
                                                        {{$item->machine_code}}/{{$item->machine_name}}
                                                    </td>
                                                    <td>
                                                        @if ($item->machine_repair_dochd_type == "ด่วน")
                                                            <span class="badge badge-soft-danger">งาน :  {{$item->machine_repair_dochd_type}}</span>
                                                        @else
                                                            <span class="badge badge-soft-primary">งาน :  {{$item->machine_repair_dochd_type}}</span>
                                                        @endif
                                                       
                                                        @if ($item->repairer_type)
                                                            @if ($item->repairer_type == "หยุดเครื่อง")
                                                                <br><span class="badge badge-soft-danger">สถานะ : {{$item->repairer_type}}</span>
                                                            @else
                                                                <br><span class="badge badge-soft-primary">สถานะ : {{$item->repairer_type}}</span>
                                                            @endif

                                                        @endif
                                                        @if ($item->repairer_problem)
                                                            @if ($item->repairer_problem == "ควรซื้อใหม่")
                                                                <br><span class="badge badge-soft-danger">เพิ่มเติม : {{$item->repairer_problem}}</span>
                                                            @else
                                                                <br><span class="badge badge-soft-primary">เพิ่มเติม :{{$item->repairer_problem}}</span>
                                                            @endif
                                                        
                                                        @endif

                                                    </td>
                                                    <td>
                                                        {{$item->machine_repair_dochd_case}}<br>
                                                        ชิ้นส่วน : {{$item->machine_repair_dochd_part}}<br>
                                                        (ที่ตั้ง : {{$item->machine_repair_dochd_location}})
                                                    </td>
                                                    <td>      
                                                        {{$item->person_at}}                                                
                                                    </td>
                                                    <td>  
                                                        @if ($item->accepting_at)
                                                            ผู้รับงานซ่อม : {{$item->accepting_at}}  
                                                        @endif    
                                                        @if ($item->repairer_at)
                                                            <br>ผู้ซ่อม : {{$item->repairer_at}}   
                                                        @endif
                                                                                                    
                                                    </td>
                                                    <td>
                                                        @if($item->machine_repair_status_id == 6)
                                                            <a href="{{ route('machine-repair-docus.edit', $item->machine_repair_dochd_id) }}"class="btn btn-primary btn-sm">รายละเอียด</a>
                                                        @elseif ($item->machine_repair_status_id == 1 || $item->machine_repair_status_id == 9)
                                                            <a href="{{ route('machine-repair-docus.edit', $item->machine_repair_dochd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> รับงานซ่อม</a>
                                                        @elseif ($item->machine_repair_status_id == 2)
                                                            @if (auth()->user()->username == "444444444")
                                                                <a href="{{ route('machine-repair-docus.edit', $item->machine_repair_dochd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> อนุมัติซ่อม</a>                                                               
                                                            @endif                                                           
                                                        @elseif ($item->machine_repair_status_id == 3)
                                                            <a href="{{ route('machine-repair-docus.edit', $item->machine_repair_dochd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> บันทึกผลการซ่อม</a>
                                                        @elseif ($item->machine_repair_status_id == 4)
                                                            <a href="{{ route('machine-repair-docus.edit', $item->machine_repair_dochd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> ตรวจสอบงานซ่อม</a>
                                                        @elseif ($item->machine_repair_status_id == 5)
                                                            <a href="{{ route('machine-repair-docus.edit', $item->machine_repair_dochd_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> ปิดงานซ่อม</a>                                                      
                                                        @endif                                                      
                                                    </td>
                                                    <td>
                                                        @if ($item->machine_repair_status_id == 1)
                                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->machine_repair_dochd_id }}')"><i class="fas fa-trash"></i></a>           
                                                        @endif                                                      
                                                    </td>
                                                    <td>
                                                        @if($item->safety_at)
                                                            {{{$item->safety_type}}}<br>
                                                            ความเห็น : {{$item->safety_note}}
                                                        @else
                                                            @if ($item->machine_repair_status_id <> 7 || $item->machine_repair_status_id <> 8)
                                                                <a href="{{ route('machine-repair-docus.show', $item->machine_repair_dochd_id) }}"class="btn btn-secondary btn-sm">บันทึก</a> 
                                                            @endif   
                                                        @endif  
                                                    </td>
                                                    <td>
                                                        @if ($item->machine_repair_status_id == 6)
                                                            <a href="{{url('/machine-repair-close/'. $item->machine_repair_dochd_id)}}"class="btn btn-info btn-sm">บันทึก</a> 
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
            url: `{{ url('/confirmDelMachineRepairHd') }}`,
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