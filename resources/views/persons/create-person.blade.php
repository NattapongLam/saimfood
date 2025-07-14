@extends('layouts.main')
@section('content')
<link href="{{ asset('assets/libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ผู้ใช้งาน</h5>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('persons.store') }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf      
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">พนักงาน</label>
                                            <select class="select2 form-select" name="username" required>
                                                <option value=""></option>
                                                @foreach ($emp as $item)
                                                    <option value="{{$item->personcode}}">{{$item->personcode}} / {{$item->personfullname}}  {{$item->company}} แผนก : {{$item->department}} ตำแหน่ง : {{$item->position}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">รหัสผ่าน</label>
                                            <input class="form-control" type="password" name="password" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">E-mail</label>
                                            <input class="form-control" type="email" name="email">
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
<script src="{{ asset('assets/libs/select2/js/select2.min.js') }}"></script>
<script>
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "เลือกรหัสพนักงาน",
        allowClear: true,
        width: '100%'
    });
});
</script>
@endsection