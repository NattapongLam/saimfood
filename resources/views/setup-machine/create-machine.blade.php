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
                                <form class="custom-validation" action="{{ route('machines.store') }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf   
                                <div class="row">  
                                    <div class="col-6">
                                        <div class="form-group">
                                                <label class="form-label">
                                                    รหัสเครื่องจักรและอุปกรณ์
                                                </label>
                                               <input class="form-control" type="text" name="machine_code" required 
                                               oninvalid="this.setCustomValidity('กรุณากรอกรหัสเครื่องจักร')" 
                                               oninput="this.setCustomValidity('')">
                                        </div>
                                    </div>  
                                    <div class="col-6">
                                        <div class="form-group">
                                                <label class="form-label">
                                                    ชื่อเครื่องจักรและอุปกรณ์
                                                </label>
                                               <input class="form-control" type="text" name="machine_name" required 
                                               oninvalid="this.setCustomValidity('กรุณากรอกชื่อเครื่องจักร')" 
                                               oninput="this.setCustomValidity('')">
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
                                                        <option value="{{$item->machinegroup_id}}">{{$item->machinegroup_name}}</option>
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
                                               oninput="this.setCustomValidity('')">
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
                                            <input class="form-control" type="date" name="insurance_date">
                                         </div>
                                    </div>
                                    <div class="col-6">
                                         <div class="form-group">
                                            <label class="form-label">
                                                Serial Number
                                            </label>
                                            <input class="form-control" type="text" name="serial_number">
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
                                            <textarea class="form-control" name="machine_details"></textarea>
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
                                                    <img src="" class="img-fluid machine_pic1" alt=""  width="50%" class="mb-3">
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
                                                    <img src="" class="img-fluid machine_pic2" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">ใบรับประกัน</a></h5>                                   
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
                                                    <img src="" class="img-fluid machine_pic3" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">คู่มือ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile03"  name="machine_pic3" onchange="prevFile(this,'machine_pic3')">
                                                <label class="input-group-text" for="inputGroupFile03">Upload</label>
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
                                                    <img src="" class="img-fluid machine_pic4" alt=""  width="50%" class="mb-3">
                                                    <h5 class="fs-17 mb-2"><a href="#" class="text-dark">เอกสารการซื้อ</a></h5>                                   
                                                <div class="mt-4 hstack gap-2">
                                                <div class="input-group">
                                                <input type="file" class="form-control" id="inputGroupFile04"  name="machine_pic4" onchange="prevFile(this,'machine_pic4')">
                                                <label class="input-group-text" for="inputGroupFile04">Upload</label>
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
        {{-- <div class="card">
            <div class="card-body">
                <table id="DataTableList" class="table table-bordered dt-responsive nowrap w-100 table-sm">
                    <thead>
                        <tr>
                            <th>สถานะ</th>
                            <th>รูปภาพ</th>
                            <th>รหัสเครื่องจักรและอุปกรณ์</th>
                            <th>ชื่อเครื่องจักรและอุปกรณ์</th>
                            <th>วันที่ซื้อ/ผลิต</th>
                            <th>กลุ่มเครื่องจักรและอุปกรณ์</th>
                            <th>Serial Number</th>
                            <th>วันที่หมดประกัน</th>
                            <th>วันที่ซ่อมล่าสุด</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($machine as $item)
                        <tr>
                            <td>
                                @if ($item->machine_flag)
                                    <span class="badge bg-success">ใช้งาน</span>
                                @else
                                    <span class="badge bg-danger">ไม่ใช้งาน</span>
                                @endif                                                          
                            </td>
                            <td>
                                <img src="{{ asset($item->machine_pic1 ?? 'images/no-image.png') }}" alt="Machine Image" class="rounded-circle avatar-xl">
                            </td>
                            <td>{{$item->machine_code}}</td>
                            <td>{{$item->machine_name}}</td>                          
                            <td>{{$item->machine_date}}</td>
                            <td>{{$item->machinegroup_name}}</td>
                            <td>{{$item->serial_number}}</td>
                            <td>{{$item->insurance_date}}</td>
                            <td>{{$item->last_repair}}</td>
                            <td>
                                <a href="{{ route('machines.edit', $item->machine_id) }}"class="btn btn-warning btn-sm"><i class="bx bx-edit-alt"></i> แก้ไข</a>
                            </td>
                        </tr>                          
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div> --}}
    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('#DataTableList').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "order": [[4, "desc"]], // <-- เรียงวันที่ล่าสุดก่อน
        "language": {
            "lengthMenu": "แสดง _MENU_ รายการต่อหน้า",
            "zeroRecords": "ไม่พบข้อมูล",
            "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ รายการ",
            "infoEmpty": "ไม่มีข้อมูล",
            "search": "ค้นหา:",
            "paginate": {
                "first": "หน้าแรก",
                "last": "หน้าสุดท้าย",
                "next": "ถัดไป",
                "previous": "ก่อนหน้า"
            }
        },
        "columnDefs": [
            { "className": "text-center", "targets": "_all" }
        ]
    });
});
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