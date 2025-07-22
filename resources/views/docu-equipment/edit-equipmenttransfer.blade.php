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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบโอนย้ายอุปกรณ์ลูกค้า</h5>
                            <div class="page-title-right">   
                                 <a href="javascript:void(0)" class="btn btn-danger" onclick="confirmDel('{{ $hd->equipment_transfer_hd_id }}')"><i class="fas fa-trash"></i> ยกเลิก</a>                  
                            </div>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('equipment-transfer.update',$hd->equipment_transfer_hd_id) }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf   
                                @method('PUT')  
                                <div class="row"> 
                                    <div class="col-4">
                                        <label class="form-label">วันที่</label>
                                        <input class="form-control" value="{{$hd->equipment_transfer_hd_date}}" readonly>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">เลขที่</label>
                                        <input class="form-control" value="{{$hd->equipment_transfer_hd_docuno}}" readonly>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">ผู้บันทึก</label>
                                        <input class="form-control" value="{{$hd->person_at}}" readonly>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-4">
                                        <label class="form-label">ลูกค้า</label>
                                        <input class="form-control" value="{{$hd->customer_fullname}}" readonly>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">ผู้ติดต่อ</label>
                                        <input class="form-control" value="{{$hd->contact_person}}" readonly>
                                    </div>
                                    <div class="col-4">
                                        <label class="form-label">เบอร์</label>
                                        <input class="form-control" value="{{$hd->contact_tel}}" readonly>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-12">
                                        <label class="form-label">ที่อยู่จัดส่ง</label>
                                        <input class="form-control" value="{{$hd->customer_address}}" readonly>
                                    </div>
                                </div>
                                <br>
                                <div class="row"> 
                                    <div class="col-12">
                                        <label class="form-label">หมายเหตุ</label>
                                        <input class="form-control" value="{{$hd->equipment_transfer_hd_remark}}" readonly>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <h5>รายการ</h5>
                                    <table class="table table-bordered dt-responsive  nowrap w-100 text-center">
                                        <thead>
                                            <tr>
                                                <th style="width: 70px;">#</th>
                                                <th>อุปกรณ์</th>
                                                <th>เพิ่มเติม</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($hd->details->where('equipment_transfer_dt_flag', true) as $key => $item)
                                                <tr>
                                                    <td>{{$item->equipment_transfer_dt_listno}}</td>
                                                    <td>
                                                        รหัส : {{$item->equipment_code}}<br>
                                                        ชื่อ : {{$item->equipment_name}}<br>
                                                        Serial : {{$item->serial_number}}
                                                        <input type="hidden" value="{{$item->equipment_transfer_dt_id}}" name="equipment_transfer_dt_id[]">
                                                    </td>
                                                    <td>{{$item->equipment_transfer_dt_remark}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <hr>
                                @if ($hd->equipment_transfer_status_id == 1)
                                <h5 style="color: red"><strong>เพิ่มเติมหลังส่งสินค้าเสร็จ</strong></h5>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-label">หมายเหตุ</div>
                                            <textarea class="form-control" name="recheck_remark"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                            <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid recheck_file" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">เอกสารจัดส่งที่เซ็นเรียบร้อย</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="recheck_file" onchange="prevFile(this,'recheck_file')" accept="image/*">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                </div>
                                                </div>
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
                                @elseif ($hd->equipment_transfer_status_id == 2)
                                    <h5 style="color: red"><strong>รับเครื่องกลับ</strong></h5>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <div class="form-label">หมายเหตุ</div>
                                                <textarea class="form-control" name="receive_remark"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                                <div class="card ">
                                                    <div class="card-body img-resize">
                                                        <div class="favorite-icon">
                                                            <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                        </div>
                                                        <img src="" class="img-fluid receive_file" alt=""  width="50%" class="mb-3">
                                                        <h5 class="fs-17 mb-2"><a href="#" class="text-dark">เอกสารส่งคืนของลูกค้า</a></h5>                                   
                                                    <div class="mt-4 hstack gap-2">
                                                    <div class="input-group">
                                                    <input type="file" class="form-control" id="inputGroupFile01"  name="receive_file" onchange="prevFile(this,'receive_file')" accept="image/*">
                                                    <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                    </div>
                                                    </div>
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
                                @endif                               
                                </form>
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
            url: `{{ url('/confirmDelEquipmentTransfer') }}`,
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