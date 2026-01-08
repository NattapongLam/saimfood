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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>รายงานผลิตภัณฑ์ที่ไม่เป็นไปตามข้อกำหนด ( Non-conformity Report : NCR )</h5>
                            </div>
                            <form class="custom-validation" action="{{ route('iso-ncrlist.store') }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            <div class="card-body">
                                <div class="row mt-3"> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">วันที่ออก NCR</label>
                                            <input class="form-control" type="date" name="iso_ncr_lists_date">
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เลขที่ NCR</label>
                                            <input class="form-control" name="iso_ncr_lists_docuno">
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ถึงหน่วยงาน</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_to">
                                        </div>
                                    </div>                                   
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">สำเนา</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_copy">
                                        </div>
                                    </div>                   
                                </div>
                                <div class="row mt-3">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ผู้พบปัญหา</label>
                                            <input class="form-control" type="text" name="iso_ncr_lists_person">
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">เลขที่ใบสั่งซื้อ/สั่งผลิต</label>
                                            <input class="form-control" name="iso_ncr_lists_refdocu">
                                        </div>
                                    </div>                     
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">พบปัญหาที่กระบวนการ</label>
                                            <select class="form-control" name="ms_processtype_name">
                                                <option value="">กรุณาเลือก</option>
                                                @foreach ($process as $item)
                                                    <option value="{{$item->ms_processtype_name}}">{{$item->ms_processtype_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                                   
                                </div>
                                <div class="row mt-3">
                                     <div class="col-6">

                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid iso_ncr_lists_file1" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">ไฟล์แนบ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile01"  name="iso_ncr_lists_file1" onchange="prevFile(this,'iso_ncr_lists_file1')">
                                                <label class="input-group-text" for="inputGroupFile01">Upload</label>
                                                </div>
                                                </div>
                                                </div>
                                    </div> 
                                    <div class="col-6">
                                                <div class="card-body img-resize">
                                                    <div class="favorite-icon">
                                                        <a href="javascript:void(0)"><i class="uil uil-heart-alt fs-18"></i></a>
                                                    </div>
                                                    <img src="" class="img-fluid iso_ncr_lists_file2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">ไฟล์แนบ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile02"  name="iso_ncr_lists_file2" onchange="prevFile(this,'iso_ncr_lists_file2')">
                                                <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                                </div>
                                                </div>
                                                </div>
                                    </div>     
                                </div>
                                <div class="row mt-3">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ปัญหาที่พบ</label>
                                            <textarea class="form-control" name="iso_ncr_lists_problem"></textarea>
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