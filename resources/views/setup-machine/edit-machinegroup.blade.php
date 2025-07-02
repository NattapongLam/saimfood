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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>กลุ่มเครื่องจักรและอุปกรณ์</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">                                   
                                        <div class="col-12">
                                        <form class="custom-validation" action="{{ route('machine-groups.update',$hd->machinegroup_id) }}" method="POST" enctype="multipart/form-data" validate>
                                        @csrf    
                                        @method('PUT')  
                                            <div class="form-group">
                                                <label class="form-label">
                                                    Status
                                                </label>
                                                <div class="d-flex">
                                                    <div class="square-switch">
                                                         @if($hd->machinegroup_flag == 1)
                                                        <input type="checkbox" id="square-switch1" switch="none" name="machinegroup_flag" value="true" checked/>
                                                        @else
                                                        <input type="checkbox" id="square-switch1" switch="none" name="machinegroup_flag" />
                                                        @endif
                                                        <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            รหัสกลุ่มเครื่องจักรและอุปกรณ์
                                                        </label>
                                                    <input class="form-control" type="text" name="machinegroup_code" required 
                                                    oninvalid="this.setCustomValidity('กรุณากรอกรหัสกลุ่มเครื่องจักร')" 
                                                    oninput="this.setCustomValidity('')" value="{{$hd->machinegroup_code}}" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group">
                                                        <label class="form-label">
                                                            ชื่อกลุ่มเครื่องจักรและอุปกรณ์
                                                        </label>
                                                        <input class="form-control" type="text" name="machinegroup_name" required 
                                                        oninvalid="this.setCustomValidity('กรุณากรอกชื่อกลุ่มเครื่องจักร')" 
                                                        oninput="this.setCustomValidity('')" value="{{$hd->machinegroup_name}}">
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
    </div>
</div>
@endsection
@section('script')
<script>
</script>
@endsection