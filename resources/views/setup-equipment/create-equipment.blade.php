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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>อุปกรณ์ลูกค้า</h5>
                             <div class="page-title-right">                  
                        </div>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('equipments.store') }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf   
                                    <div class="row"> 
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">รหัสอุปกรณ์</label>
                                                <input class="form-control" name="equipment_code" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">ชื่ออุปกรณ์</label>
                                                <input class="form-control" name="equipment_name" required>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row"> 
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">วันที่ซื้อ</label>
                                                <input class="form-control" name="equipmente_date" type="date" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">วันที่หมดประกัน</label>
                                                <input class="form-control" name="insurance_date" type="date" required>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                Serial Number
                                            </label>
                                            <input class="form-control" type="text" name="serial_number">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                               ยี่ห้อ
                                            </label>
                                            <input class="form-control" type="text" name="equipment_brand">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                มูลค่า
                                            </label>
                                             <input type="number" class="form-control" name="equipment_cost" id="equipment_cost" min="0" step="0.01">
                                        </div>
                                    </div> 
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">รายละเอียดเพิ่มเติม</label>
                                                <textarea class="form-control" name="equipment_details"></textarea>
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
                                                    <img src="" class="img-fluid equipment_pic1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">รูปภาพ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="equipment_pic1" onchange="prevFile(this,'equipment_pic1')" accept="image/*">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                </div>
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
                                                    <img src="" class="img-fluid equipment_pic2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">ใบรับประกัน</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="equipment_pic2" onchange="prevFile(this,'equipment_pic2')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div>
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
                                                    <img src="" class="img-fluid equipment_pic3" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">คู่มือ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile03"  name="equipment_pic3" onchange="prevFile(this,'equipment_pic3')">
                                                <label class="input-group-text" for="inputGroupFile03">Upload</label>
                                                </div>
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
                                                    <img src="" class="img-fluid equipment_pic4" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">เอกสารการซื้อ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile04"  name="equipment_pic4" onchange="prevFile(this,'equipment_pic4')">
                                                <label class="input-group-text" for="inputGroupFile04">Upload</label>
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
</script>
@endsection