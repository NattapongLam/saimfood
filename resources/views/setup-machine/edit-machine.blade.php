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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>เครื่องจักรและอุปกรณ์</h5>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('machines.update',$hd->machine_id) }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf   
                                @method('PUT')  
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Status
                                                </label>
                                                <div class="d-flex">
                                                    <div class="square-switch">
                                                         @if($hd->machine_flag == 1)
                                                        <input type="checkbox" id="square-switch1" switch="none" name="machine_flag" value="true" checked/>
                                                        @else
                                                        <input type="checkbox" id="square-switch1" switch="none" name="machine_flag" />
                                                        @endif
                                                        <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                                                    </div>
                                                </div>
                                            </div>
                                <div class="row">  
                                    <div class="col-6">
                                        <div class="form-group">
                                                <label class="form-label">
                                                    รหัสเครื่องจักรและอุปกรณ์
                                                </label>
                                               <input class="form-control" type="text" name="machine_code" required 
                                               oninvalid="this.setCustomValidity('กรุณากรอกรหัสเครื่องจักร')" 
                                               oninput="this.setCustomValidity('')" 
                                               readonly value="{{$hd->machine_code}}">
                                        </div>
                                    </div>  
                                    <div class="col-6">
                                        <div class="form-group">
                                                <label class="form-label">
                                                    ชื่อเครื่องจักรและอุปกรณ์
                                                </label>
                                               <input class="form-control" type="text" name="machine_name" required 
                                               oninvalid="this.setCustomValidity('กรุณากรอกชื่อเครื่องจักร')" 
                                               oninput="this.setCustomValidity('')"
                                               value="{{$hd->machine_name}}">
                                        </div>
                                    </div>
                                </div>
                                <br> 
                                <div class="row">
                                    <div class="col-6">
                                         <div class="form-group">
                                                <label class="form-label">
                                                    กลุ่มเครื่องจักรและอุปกรณ์
                                                </label>
                                                <select class="form-select" name="machinegroup_id" required 
                                                oninvalid="this.setCustomValidity('กรุณากรอกกลุ่มเเครื่องจักร')" 
                                                oninput="this.setCustomValidity('')">
                                                    <option value="">กรุณาเลือก</option>
                                                    @foreach ($machinegroup as $item)
                                                        <option value="{{ $item->machinegroup_id }}"
                                                        {{ $item->machinegroup_id == $hd->machinegroup_id ? 'selected' : '' }}>
                                                        {{$item->machinegroup_name}}</option>
                                                    @endforeach
                                                </select>
                                         </div>
                                    </div>
                                    <div class="col-6">
                                         <div class="form-group">
                                            <label class="form-label">
                                                วันที่ซื้อ/ผลิต
                                            </label>
                                            <input class="form-control" type="date" name="machine_date" required 
                                            oninvalid="this.setCustomValidity('กรุณากรอกวันที่ซื้อ/ผลิต')" 
                                            oninput="this.setCustomValidity('')"
                                            value="{{ $hd->machine_date ? \Carbon\Carbon::parse($hd->machine_date)->format('Y-m-d') : '' }}">
                                         </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                         <div class="form-group">
                                            <label class="form-label">
                                                วันที่หมดประกัน
                                            </label>
                                            <input class="form-control" type="date" name="insurance_date"
                                             value="{{ $hd->insurance_date ? \Carbon\Carbon::parse($hd->insurance_date)->format('Y-m-d') : '' }}">
                                         </div>
                                    </div>
                                    <div class="col-6">
                                         <div class="form-group">
                                            <label class="form-label">
                                                Serial Number
                                            </label>
                                            <input class="form-control" type="text" name="serial_number" value="{{$hd->serial_number}}">
                                         </div>
                                    </div> 
                                </div>
                                <br>                                                                   
                                <div class="row">
                                    <div class="col-12">
                                         <div class="form-group">
                                            <label class="form-label">
                                                รายละเอียดเพิ่มเติม
                                            </label>
                                            <textarea class="form-control" name="machine_details">{{$hd->machine_details}}</textarea>
                                         </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                            <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="{{ asset($hd->machine_pic1) }}" class="img-fluid machine_pic1 mb-3" alt="Machine Image" width="50%" class="rounded me-2">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">รูปภาพ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="machine_pic1" onchange="prevFile(this,'machine_pic1')" accept="image/*">
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
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->machine_pic2) }}" target="_blank" class="text-dark">ใบรับประกัน</a></h5>                                                                                  
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="machine_pic2" onchange="prevFile(this,'machine_pic2')">
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
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->machine_pic3) }}" target="_blank" class="text-dark">คู่มือ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="machine_pic3" onchange="prevFile(this,'machine_pic3')">
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
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->machine_pic4) }}" target="_blank" class="text-dark">เอกสารการซื้อ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="machine_pic4" onchange="prevFile(this,'machine_pic4')">
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