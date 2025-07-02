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
                <div class="page-title-right">
                    <h5 class="my-0 text-primary">
                        <a href="{{route('persons.create')}}">
                            เพิ่มผู้ใช้งาน
                        </a>
                    </h5>                  
                </div>
                </div>
                </div>
                 </div>       
            </div>          
            <div class="card-body">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-bordered dt-responsive  nowrap w-100 text-center">
                            <thead>
                                <tr>
                                    <th>สถานะ</th>
                                    <th>รหัสพนักงาน</th>
                                    <th>ชื่อ - นามสกุล</th>         
                                    <th>ชื่อผู้ใช้งาน</th>                             
                                    <th>กำหนดสิทธิ</th>
                                    <th>แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                    <tr>
                                        <td>
                                            @if ($item->status)
                                                <span class="badge bg-success">ใช้งาน</span>
                                            @else
                                                <span class="badge bg-danger">ไม่ใช้งาน</span>
                                            @endif                                                          
                                        </td>
                                        <td>{{$item->employee_code}}</td>
                                        <td>{{$item->employee_fullname}}</td>
                                        <td>{{$item->username}}</td>
                                        <td>
                                            <a href="{{route('permissions.edit',$item->id)}}"
                                            class="btn btn-sm btn-info">
                                            <i class="fas fa-user"></i>
                                            </a> 
                                        </td>
                                        <td>
                                            <a href="{{ route('persons.edit', $item->id) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bx bx-edit-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>                  
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>
@endsection