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
                        <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>กำหนดสิทธิ</h5>
                        <br>
                        <form method="POST" class="form-horizontal" action="{{ route('permissions.update',$users->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">รหัสพนักงาน</label>
                                    <input class="form-control" value="{{$users->employee_code}}" readonly>
                                </div>                                
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">ชื่อ - นามสกุล</label>
                                    <input class="form-control" value="{{$users->name}}" readonly>
                                </div>
                            </div>                                                      
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">ชื่อผู้ใช้งาน</label>
                                    <input class="form-control" value="{{$users->username}}" readonly>
                                </div>
                            </div>
                            @php
                                $currentRole = $users->getRoleNames()->first();
                            @endphp
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">ระดับ</label>
                                    <select class="form-select" name="role" id="role">
                                        <option value="">กรุณาเลือก</option>
                                        @foreach ($roles as $item)
                                            <option value="{{ $item->name }}" {{ $currentRole === $item->name ? 'selected' : '' }}>
                                                {{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                       <div class="row">
                            @php
                                $userPermissions = $users->getPermissionNames()->toArray();
                            @endphp
                            @foreach ($permissions as $key => $item)
                                <div class="col-12 col-md-4">
                                    <div class="form-group">
                                        <div class="form-check form-check-primary mb-3">
                                            <input 
                                                class="form-check-input" 
                                                type="checkbox" 
                                                id="formCheckcolor1{{$item->id}}" 
                                                value="{{$item->id}}" 
                                                name="permission[]" 
                                                {{ in_array($item->name, $userPermissions) ? 'checked' : '' }}
                                            >
                                            <label class="form-check-label" for="formCheckcolor1{{$item->id}}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    </div>
                                </div> 
                            @endforeach
                        </div>
                        <br>
                        <div class="row">
                            <button type="submit" class="btn btn-primary btn-lg waves-effect waves-light">บันทึกข้อมูล</button>    
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection