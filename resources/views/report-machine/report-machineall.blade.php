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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>รายงาน</h5>
                            </div>
                            <form method="GET" class="form-horizontal">
                            @csrf
                                <div class="row">                              
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="date" class="form-control" name="datestart" value="{{$datestart}}">
                                            </div>                                          
                                        </div>
                                        <div class="col-3">
                                            <div class="form-group">
                                                <input type="date" class="form-control" name="dateend" value="{{$dateend}}">
                                            </div>                                          
                                        </div>
                                        <div class="col-3">
                                             <div class="form-group">
                                                <button class="btn btn-info w-lg">
                                                    <i class="fas fa-search"></i> ค้นหา
                                                </button>
                                             </div>                                          
                                        </div>                                
                                </div>
                            </form>
                        </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                  <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted fw-medium">งานสร้าง</h5>
                                                        <h4 class="mb-0">{{$hd1}}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-copy-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                </div>
            </div>           
            <div class="col-md-3">
                  <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted fw-medium">งานซ่อม</h5>
                                                        <h4 class="mb-0">{{$hd2}}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="mini-stat-icon avatar-sm rounded-circle bg-primary">
                                                            <span class="avatar-title">
                                                                <i class="bx bx-copy-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                </div>
            </div>
            <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted fw-medium">ด่วน</h5>
                                                        <h4 class="mb-0">{{$hd3}}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            </div>   
             <div class="col-md-3">
                                        <div class="card mini-stats-wid">
                                            <div class="card-body">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1">
                                                        <h5 class="text-muted fw-medium">ปกติ</h5>
                                                        <h4 class="mb-0">{{$hd4}}</h4>
                                                    </div>

                                                    <div class="flex-shrink-0 align-self-center">
                                                        <div class="avatar-sm rounded-circle bg-primary mini-stat-icon">
                                                            <span class="avatar-title rounded-circle bg-primary">
                                                                <i class="bx bx-purchase-tag-alt font-size-24"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
            </div>                 
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4">การให้บริการ</h4>

                                        <div class="text-center">
                                            <div class="mb-4">
                                                <i class="bx bx-map-pin text-primary display-4"></i>
                                            </div>
                                            <h3>{{$hd5}}</h3>
                                            <p>ทั้งหมด</p>
                                        </div>

                                        <div class="table-responsive mt-4">
                                            <table class="table align-middle table-nowrap">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 30%">
                                                            <p class="mb-0">งานรอซ่อม</p>
                                                        </td>
                                                        <td style="width: 25%">
                                                            <h5 class="mb-0">{{$hd6}}</h5></td>
                                                        <td>
                                                            <div class="progress bg-transparent progress-sm">
                                                                <div class="progress-bar bg-warning rounded" role="progressbar" style="width: {{$hd6}}%" aria-valuenow="{{$hd6}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0">กำลังดำเนินการ</p>
                                                        </td>
                                                        <td>
                                                            <h5 class="mb-0">{{$hd7}}</h5>
                                                        </td>
                                                        <td>
                                                            <div class="progress bg-transparent progress-sm">
                                                                <div class="progress-bar bg-secondary rounded" role="progressbar" style="width: {{$hd7}}%" aria-valuenow="{{$hd7}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <p class="mb-0">ปิดงานเรียบร้อย</p>
                                                        </td>
                                                        <td>
                                                            <h5 class="mb-0">{{$hd8}}</h5>
                                                        </td>
                                                        <td>
                                                            <div class="progress bg-transparent progress-sm">
                                                                <div class="progress-bar bg-success rounded" role="progressbar" style="width: {{$hd8}}%" aria-valuenow="{{$hd8}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                     <tr>
                                                        <td>
                                                            <p class="mb-0">ยกเลิกงาน</p>
                                                        </td>
                                                        <td>
                                                            <h5 class="mb-0">{{$hd9}}</h5>
                                                        </td>
                                                        <td>
                                                            <div class="progress bg-transparent progress-sm">
                                                                <div class="progress-bar bg-danger rounded" role="progressbar" style="width: {{$hd9}}%" aria-valuenow="{{$hd9}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
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
</script>
@endsection