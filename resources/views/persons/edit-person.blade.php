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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ผู้ใช้งาน</h5>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('persons.update',$users->id) }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf    
                                @method('PUT')  
                                <div class="form-group">
                                                <label class="form-label">
                                                    Status
                                                </label>
                                                <div class="d-flex">
                                                    <div class="square-switch">
                                                         @if($users->status == 1)
                                                        <input type="checkbox" id="square-switch1" switch="none" name="status" value="true" checked/>
                                                        @else
                                                        <input type="checkbox" id="square-switch1" switch="none" name="status" />
                                                        @endif
                                                        <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                                                    </div>
                                                </div>
                                            </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">รหัสพนักงาน</label>
                                            <input class="form-control" type="text" name="username" value="{{$users->username}}" required>
                                            <input type="hidden" value="user-update" name="checktype">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ชื่อ - นามสกุล</label>
                                            <input class="form-control" type="text" name="name" value="{{$users->name}}" required>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">รหัสผ่าน</label>
                                            <input class="form-control" type="password" name="password">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">E-mail</label>
                                            <input class="form-control" type="email" name="email" value="{{$users->email}}">
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