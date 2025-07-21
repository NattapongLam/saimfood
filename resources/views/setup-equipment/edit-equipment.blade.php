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
                                <form class="custom-validation" action="{{ route('equipments.update',$hd->equipment_id) }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf   
                                @method('PUT')  
                                <div class="form-group">
                                    <label class="form-label">
                                        Status
                                    </label>
                                    <div class="d-flex">
                                        <div class="square-switch">
                                                        @if($hd->equipment_flag == 1)
                                                        <input type="checkbox" id="square-switch1" switch="none" name="equipment_flag" value="true" checked/>
                                                        @else
                                                        <input type="checkbox" id="square-switch1" switch="none" name="equipment_flag" />
                                                        @endif
                                                        <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row"> 
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">รหัสอุปกรณ์</label>
                                                <input class="form-control" name="equipment_code" value="{{$hd->equipment_code}}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">ชื่ออุปกรณ์</label>
                                                <input class="form-control" name="equipment_name" value="{{$hd->equipment_name}}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row"> 
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">วันที่ซื้อ</label>
                                                <input class="form-control" name="equipmente_date" type="date" value="{{$hd->equipmente_date}}" required>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label class="form-label">วันที่หมดประกัน</label>
                                                <input class="form-control" name="insurance_date" type="date" value="{{$hd->insurance_date}}" required>
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
                                            <input class="form-control" type="text" name="serial_number" value="{{$hd->serial_number}}">
                                         </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                               ยี่ห้อ
                                            </label>
                                            <input class="form-control" type="text" name="equipment_brand" value="{{$hd->equipment_brand}}">
                                        </div>
                                    </div>
                                     <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">
                                                มูลค่า
                                            </label>
                                             <input type="number" class="form-control" name="equipment_cost" id="equipment_cost" min="0" step="0.01"  value="{{$hd->equipment_cost}}">
                                        </div>
                                    </div>  
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label class="form-label">รายละเอียดเพิ่มเติม</label>
                                                <textarea class="form-control" name="equipment_details">{{$hd->equipment_details}}</textarea>
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
                                                    <img src="{{ asset($hd->equipment_pic1) }}" class="img-fluid equipment_pic1 mb-3" alt="Machine Image" width="50%" class="rounded me-2">
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
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->equipment_pic2) }}" target="_blank" class="text-dark">ใบรับประกัน</a></h5>                                                                                  
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
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->equipment_pic3) }}" target="_blank" class="text-dark">คู่มือ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="equipment_pic3" onchange="prevFile(this,'equipment_pic3')">
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
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->equipment_pic4) }}" target="_blank" class="text-dark">เอกสารการซื้อ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="equipment_pic4" onchange="prevFile(this,'equipment_pic4')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
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