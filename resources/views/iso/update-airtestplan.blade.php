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
                                        บันทึกรายงานผล Air Test หาเชื้อจุลินทรีย์
                                    </h5>                              
                            </div>
                            <form action="{{ route('iso-airtestplan.storeRecord', $hd->iso_airtest_plans_id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">แผนก :</label>
                                            <input class="form-control" type="text" name="iso_airtest_records_department">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ห้อง :</label>
                                            <input class="form-control" type="text" name="iso_airtest_records_area" value="{{$hd->iso_airtest_plans_remark}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">วันที่รายงาน :</label>
                                            <input class="form-control" type="date" name="iso_airtest_records_date">
                                        </div>
                                    </div>
                                     <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">จำนวนโคโลนีที่ปรากฎ :</label>
                                            <input class="form-control" type="text" name="iso_airtest_records_qty">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผลการ Air Test :</label>
                                            <input class="form-control" type="text" name="iso_airtest_records_result">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">สรุปผล Air Test :</label>
                                            <select class="form-control" name="iso_airtest_records_status">
                                                <option value="">กรุณาเลือก</option>
                                                <option value="ผ่าน">ผ่าน</option>
                                                <option value="ไม่ผ่าน">ไม่ผ่าน</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ตรวจสอบ :</label>
                                            <input class="form-control" type="text" name="iso_airtest_records_review">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้ทวนสอบ :</label>
                                            <input class="form-control" type="text" name="iso_airtest_records_recheck">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้รับทราบ :</label>
                                            <input class="form-control" type="text" name="iso_airtest_records_acknowledge">
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ :</label>
                                            <input class="form-control" type="text" name="iso_airtest_records_note">
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
                                    <th style="min-width:120px;">แผนก</th>
                                    <th style="min-width:200px;">ห้อง</th>
                                    <th style="min-width:250px;">วันที่รายงาน</th>
                                    <th style="min-width:200px;">จำนวนโคโลนีที่ปรากฎ</th>
                                    <th style="min-width:250px;">ผลการ Air Test</th>
                                    <th style="min-width:200px;">สรุปผล Air Test</th>
                                    <th style="min-width:200px;">ผู้ตรวจสอบ</th>
                                    <th style="min-width:120px;">ผู้ทวนสอบ</th>
                                    <th style="min-width:120px;">ผู้รับทราบ</th>
                                    <th style="min-width:200px;">หมายเหตุ</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($list as $key => $item)
                                    <tr>
                                        <td>{{$item->iso_airtest_records_department}}</td>
                                        <td>{{$item->iso_airtest_records_area}}</td>
                                        <td>{{$item->iso_airtest_records_date}}</td>
                                        <td>{{$item->iso_airtest_records_qty}}</td>
                                        <td>{{$item->iso_airtest_records_result}}</td>
                                        <td>{{$item->iso_airtest_records_status}}</td>
                                        <td>{{$item->iso_airtest_records_review}}</td>
                                        <td>{{$item->iso_airtest_records_recheck}}</td>
                                        <td>{{$item->iso_airtest_records_acknowledge}}</td>
                                        <td>{{$item->iso_airtest_records_note}}</td>
                                        <td>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->iso_airtest_records_id }}')"><i class="fas fa-trash"></i></a>  
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
            url: `{{ url('/confirmDelAirtestnRecord') }}`,
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