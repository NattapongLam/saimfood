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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบควบคุมใบ NCR (NCR Log Sheet)</h5>
                            </div>
                            <form class="custom-validation" action="{{ route('iso-ncrlist.update',$hd->iso_ncr_lists_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf  
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mt-2"> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ลำดับ</label>
                                            <input class="form-control" type="number" name="iso_ncr_lists_listno" value="{{$hd->iso_ncr_lists_listno}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">เลขที่ NCR</label>
                                            <input class="form-control" name="iso_ncr_lists_docuno" value="{{$hd->iso_ncr_lists_docuno}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่ออก NCR</label>
                                            <input class="form-control" type="date" name="iso_ncr_lists_date" value="{{$hd->iso_ncr_lists_date}}">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row mt-2">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ปัญหาที่พบ</label>
                                            <input class="form-control" name="iso_ncr_lists_description" value="{{$hd->iso_ncr_lists_description}}">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row mt-2">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">ผู้รับผิดชอบ</label>
                                            <input class="form-control" name="iso_ncr_lists_person" value="{{$hd->iso_ncr_lists_person}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">วันที่ปิดเรื่อง</label>
                                            <input class="form-control" type="date" name="iso_ncr_lists_closedate" value="{{$hd->iso_ncr_lists_closedate}}">
                                        </div>
                                    </div> 
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control"  name="iso_ncr_lists_remark" value="{{$hd->iso_ncr_lists_remark}}">
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
</script>
@endsection