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
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="custom-validation" action="{{ route('machine-issue-docus.update',$hd->machine_issuestock_hd_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')    
                            <input type="hidden" value="Update" name="reftype">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">วันที่</label>
                                        <input class="form-control" type="date" name="machine_issuestock_hd_date" value="{{$hd->machine_issuestock_hd_date}}" readonly>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">ผู้จำหน่าย</label>
                                        <input class="form-control" type="text" name="machine_issuestock_hd_vendor"  value="{{$hd->machine_issuestock_hd_vendor}}" readonly>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">ผู้ติดต่อ</label>
                                        <input class="form-control" type="text" name="machine_issuestock_hd_contact" value="{{$hd->machine_issuestock_hd_contact}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <label class="form-label">เบอร์โทร</label>
                                        <input class="form-control" type="text" name="machine_issuestock_hd_tel" value="{{$hd->machine_issuestock_hd_tel}}" readonly>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุ</label>
                                        <input class="form-control" type="text" name="machine_issuestock_hd_note"  value="{{$hd->machine_issuestock_hd_note}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                    <div class="col-6">
                                            <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid machine_issuestock_hd_file1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->machine_issuestock_hd_file1)}}" target="_blank" class="text-dark">เอกสารแนบ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                {{-- <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="machine_issuestock_hd_file1" onchange="prevFile(this,'machine_issuestock_hd_file1')">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                </div> --}}
                                                </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="col-6">
                                            <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid machine_issuestock_hd_file2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->machine_issuestock_hd_file2)}}" target="_blank" class="text-dark">เอกสารแนบ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                {{-- <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="machine_issuestock_hd_file2" onchange="prevFile(this,'machine_issuestock_hd_file2')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div> --}}
                                                </div>
                                                </div>
                                            </div>
                                    </div>                                  
                                </div>
                                <div class="row">
                                    <div class="col-12" style="text-align: right;">
                                        {{-- <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a> --}}
                                    </div>
                                    <table class="table table-striped mb-0 text-center">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รหัสสินค้า</th>
                                                        <th>ชื่อสินค้า</th>
                                                        <th>หน่วยนับ</th>
                                                        <th>จำนวน</th>
                                                        <th>ราคาต่อหน่วย</th>
                                                        <th>หมายเหตุ</th>
                                                        {{-- <th></th> --}}
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dt as $item)
                                                        <tr>
                                                            <td>{{$item->machine_issuestock_dt_listno}}</td>
                                                            <td>{{$item->machine_issuestock_dt_code}}</td>
                                                            <td>{{$item->machine_issuestock_dt_name}}</td>
                                                            <td>{{$item->machine_issuestock_dt_unit}}</td>
                                                            <td>{{$item->machine_issuestock_dt_qty}}</td>
                                                            <td>{{$item->machine_issuestock_dt_price}}</td>
                                                            <td>{{$item->machine_issuestock_dt_note}}</td>
                                                            {{-- <td>
                                                                  <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="confirmDel('{{ $item->machine_issuestock_dt_id }}')"><i class="fas fa-trash"></i></a>
                                                            </td> --}}
                                                        </tr>
                                                    @endforeach
                                                </tbody>    
                                                <tbody id="tableBody">
                                                </tbody>       
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" type="text" name="approved_remark" >
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
    </div>
</div>
@endsection
@section('script')
<script>
function prevFile(input, elm) {
                if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('.' + elm).attr('src', e.target.result);
                    file = input.files[0];
                }

                reader.readAsDataURL(input.files[0]);
            }
}
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
            url: `{{ url('/confirmDelMachineIssueStockDt') }}`,
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