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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>Master List</h5>                              
                            </div>
                            <form class="custom-validation" action="{{ route('iso-masterlist.update',$hd->iso_master_lists_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-2">       
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ลำดับ</label>
                                            <input class="form-control" type="number" name="iso_master_lists_listno" value="{{$hd->iso_master_lists_listno}}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">DAR No.</label>
                                            <input class="form-control" name="iso_master_lists_refdocu" value="{{$hd->iso_master_lists_refdocu}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">หมายเลขเอกสาร</label>
                                            <input class="form-control" name="iso_master_lists_docuno" value="{{$hd->iso_master_lists_docuno}}">
                                        </div>
                                    </div>                               
                                </div>
                                <div class="row mt-2">    
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ฝ่าย/แผนก</label>
                                            <input class="form-control" name="iso_master_lists_department" value="{{$hd->iso_master_lists_department}}">
                                        </div>
                                    </div> 
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อเอกสาร</label>
                                            <input class="form-control" name="iso_master_lists_name" value="{{$hd->iso_master_lists_name}}">
                                        </div>
                                    </div>                               
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">แก้ไขครั้งที่</label>
                                            <input class="form-control" name="iso_master_lists_rev" value="{{$hd->iso_master_lists_rev}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่บังคับใช้</label>
                                            <input class="form-control" type="date" name="iso_master_lists_date" value="{{$hd->iso_master_lists_date}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ระยะเวลาการจัดเก็บ</label>
                                            <input class="form-control" name="iso_master_lists_timeline" value="{{$hd->iso_master_lists_timeline}}">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control" name="iso_master_lists_remark" value="{{$hd->iso_master_lists_remark}}">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row mt-2">
                                    <div class="col-6">
                                        <div class="card ">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid iso_master_lists_file1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->iso_master_lists_file1)}}" target="_blank" class="text-dark">ไฟล์แนบ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="iso_master_lists_file1" onchange="prevFile(this,'iso_master_lists_file1')">
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
                                                    <img src="" class="img-fluid iso_master_lists_file2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="{{ asset($hd->iso_master_lists_file2)}}" target="_blank" class="text-dark">ไฟล์แนบ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="iso_master_lists_file2" onchange="prevFile(this,'iso_master_lists_file2')">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                </div>
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