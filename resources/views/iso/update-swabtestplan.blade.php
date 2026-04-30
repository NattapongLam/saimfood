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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>
                                          แผนการ Swab Test (Coliform bacteria)                
                                    </h5>                              
                            </div>
                            <form action="{{ route('iso-swabtestplan.storeRecord', $hd->iso_swabtest_plans_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">วันที่รายงานผล</label>
                                            <input class="form-control" type="date" name="iso_swabtest_records_date" value="{{ old('iso_dar_lists_date', date('Y-m-d')) }}" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ฝ่าย/แผนก</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_department" required>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">จุดปฏิบัติงาน/จุดประจำ</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_area" value="{{$hd->iso_swabtest_plans_area}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อพนักงาน/ชื่อเครื่องจักร-อุปกรณ์</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_name">
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">จุดที่ Swab Test</label>
                                            <select class="form-control" name="iso_swabtest_records_test" required>
                                                <option value="">กรุณาเลือก</option>
                                                <option value="มือ">มือ</option>
                                                <option value="ชุดยูนิฟอร์ม">ชุดยูนิฟอร์ม</option>
                                                <option value="หมวก">หมวก</option>
                                                <option value="เครื่องจักร/อุปกรณ์">เครื่องจักร/อุปกรณ์</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">รายละเอียดการ Swab Test</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_remark">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">สีสารละลายที่ปรากฎ</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_observed">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผลการ Swab Test</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_result">
                                        </div>
                                    </div>                                   
                                </div> 
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">สรุปผล</label>
                                            <select class="form-control" name="iso_swabtest_records_status" required>
                                                <option value="">กรุณาเลือก</option>
                                                <option value="ผ่าน">ผ่าน</option>
                                                <option value="ไม่ผ่าน">ไม่ผ่าน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ตรวจสอบ</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_review">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ทวนสอบ</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_recheck">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้รับทราบ</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_acknowledge">
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="iso_swabtest_records_note">
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
            <div class="card-header bg-transparent border-primary">
                <div class="card-body">
                    <h4>รายการ</h4> 
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="min-width:120px;">ฝ่าย/แผนก</th>
                                    <th style="min-width:200px;">จุดปฏิบัติงาน/จุดประจำ</th>
                                    <th style="min-width:250px;">ชื่อพนักงาน/ชื่อเครื่องจักร-อุปกรณ์</th>
                                    <th style="min-width:200px;">จุดที่ Swab Test</th>
                                    <th style="min-width:250px;">รายละเอียดการ Swab Test</th>
                                    <th style="min-width:200px;">สีสารละลายที่ปรากฎ</th>
                                    <th style="min-width:200px;">ผลการ Swab Test</th>
                                    <th style="min-width:120px;">สรุปผล</th>
                                    <th style="min-width:120px;">วันที่รายงานผล</th>
                                    <th style="min-width:200px;">ผู้ตรวจสอบ</th>
                                    <th style="min-width:200px;">ผู้ทวนสอบ</th>
                                    <th style="min-width:200px;">ผู้รับทราบ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $key => $item)
                                    <tr>
                                        <td>{{$key +1}}</td>
                                        <td>{{$item->iso_swabtest_records_department}}</td>
                                        <td>{{$item->iso_swabtest_records_area}}</td>
                                        <td>{{$item->iso_swabtest_records_name}}</td>
                                        <td>{{$item->iso_swabtest_records_test}}</td>
                                        <td>{{$item->iso_swabtest_records_remark}}</td>
                                        <td>{{$item->iso_swabtest_records_observed}}</td>
                                        <td>{{$item->iso_swabtest_records_result}}</td>
                                        <td>{{$item->iso_swabtest_records_status}}</td>
                                        <td>{{$item->iso_swabtest_records_date}}</td>
                                        <td>{{$item->iso_swabtest_records_review}}</td>
                                        <td>{{$item->iso_swabtest_records_recheck}}</td>
                                        <td>{{$item->iso_swabtest_records_acknowledge}}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->iso_swabtest_records_id }}')"><i class="fas fa-trash"></i></a>  
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
            url: `{{ url('/confirmDelSwabtestRecord') }}`,
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