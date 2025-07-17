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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ใบแจ้งซ่อมลูกค้า เลขที่ : {{$case->customer_repair_docu_docuno}} สถานะ : {{$case->customer_repair_status_name}}</h5>
                                <div class="page-title-right">                                                    
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form class="custom-validation" action="{{ route('equipment-repair.update',$case->customer_repair_docu_id) }}" method="POST" enctype="multipart/form-data" validate>
                            @csrf   
                            @method('PUT')  
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">ลูกค้า</label>
                                        <input class="form-control" value="{{$case->customer_fullname}}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">ที่อยู่</label>
                                        <input class="form-control" value="{{$case->customer_address}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">ผู้ติดต่อ</label>
                                        <input class="form-control" value="{{$case->contact_person}}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">เบอร์โทร</label>
                                        <input class="form-control" value="{{$case->contact_tel}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">รหัสอุปกรณ์</label>
                                        <input class="form-control" value="{{$case->equipment_code}}" readonly>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="form-label">ชื่ออุปกรณ์</label>
                                        <input class="form-control" value="{{$case->equipment_name}}" readonly>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label">รายละเอียดอาการเสีย</label>
                                        <textarea class="form-control" name="customer_repair_docu_case" rows="5" readonly>{{$case->customer_repair_docu_case}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <br>                          
                            @if ($case->customer_repair_status_id == 1 || $case->customer_repair_status_id == 5)
                            <h5>รายละเอียดรับงานซ่อม</h5>
                                <div class="row">
                                <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">ความเห็นช่าง</label>
                                        <select class="form-select" name="person_result" required>
                                            <option value="เข้าซ่อมหน้างาน">เข้าซ่อมหน้างาน</option>
                                            <option value="นำเครื่องกลับมาซ่อม">นำเครื่องกลับมาซ่อม</option>
                                            <option value="เปลี่ยนเครื่องใหม่">เปลี่ยนเครื่องใหม่</option>
                                            <option value="ยังอยู่ประกัน">ยังอยู่ประกัน</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="form-group">
                                        <label class="form-label">เพิ่มเติม</label>
                                        <input class="form-control" type="text" name="result_remark" value="{{$case->result_remark}}" required>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                 <div class="col-3">
                                    <div class="form-group">
                                        <label class="form-label">วันที่จะดำเนินการเสร็จ</label>
                                        <input class="form-control"  type="date" name="person_date" value="{{$case->person_date}}" required>
                                    </div>
                                 </div>
                                 <div class="col-9">
                                    <div class="form-group">
                                        <label class="form-label">หมายเหตุ</label>
                                        <input class="form-control"  type="text" name="person_note" value="{{$case->person_note}}">
                                    </div>
                                 </div>
                            </div>
                            <br>
                            <div class="row"> 
                                <div class="col-12" style="text-align: right;">
                                    <a href="javascript:void(0);" class="btn btn-secondary" id="addRowBtn">เพิ่มรายการ</a>
                                </div>
                                <table class="table table-striped mb-0 text-center">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>รายละเอียด</th>
                                            <th>ชื่อร้าน</th> 
                                            <th>ค่าใช้จ่าย</th>                                                         
                                            <th>แนบไฟล์</th>                                                        
                                            <th></th>
                                        </tr>
                                    </thead>
                                    @if ($sub)
                                    <tbody>
                                        @foreach ($sub as $item)
                                            <tr>
                                                    <td>
                                                        {{$item->customer_repair_sub_listno}}
                                                        <input type="hidden" name="customer_repair_sub_listno[]" value="{{$item->customer_repair_sub_listno}}">
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="customer_repair_sub_remark[]" value="{{$item->customer_repair_sub_remark}}">                                                
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="customer_repair_sub_vendor[]" value="{{$item->customer_repair_sub_vendor}}">                                             
                                                    </td>
                                                    <td>
                                                        <input class="form-control" name="customer_repair_sub_cost[]" value="{{$item->customer_repair_sub_cost}}"> 
                                                    </td>
                                                    <td>
                                                        @if (isset($item->customer_repair_sub_file) && $item->customer_repair_sub_file)
                                                            <a href="{{ asset('/'.$item->customer_repair_sub_file) }}" target="_blank"><i class="fas fa-file"></i></a>                                                                 
                                                        @endif
                                                        <input type="file" name="customer_repair_sub_file[]" class="form-control"/>                               
                                                    </td>
                                                    <td>
                                                        <input type="hidden" name="customer_repair_sub_id[]" value="{{$item->customer_repair_sub_id}}">
                                                        <div class="square-switch">
                                                            @if($item->customer_repair_sub_flag == 1)
                                                            <input type="checkbox" id="square-switch1" switch="none" name="customer_repair_sub_flag[]" value="true" checked/>
                                                            @else
                                                            <input type="checkbox" id="square-switch1" switch="none" name="customer_repair_sub_flag[]" />
                                                            @endif
                                                            <label for="square-switch1" data-on-label="On" data-off-label="Off"></label>
                                                        </div>
                                                    </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    @endif 
                                    <tbody id="tableBody"></tbody>
                                </table>
                            </div>
                            <br>
                            <div class="form-group">
                                <div class="d-flex flex-wrap gap-2 justify-content">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light" >
                                        บันทึก
                                    </button>
                                </div>
                            </div>
                            @elseif ($case->customer_repair_status_id == 2)
                            <h5>รายละเอียดรับงานซ่อม ({{$case->person_at}} {{\Carbon\Carbon::parse($case->person_datetime)->format('d/M/y')}})</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">ความเห็นช่าง</label>
                                            <input class="form-control" value="{{$case->person_result}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">วันที่จะดำเนินการเสร็จ</label>
                                            <input class="form-control"  type="date"  value="{{$case->person_date}}" readonly>
                                        </div>
                                    </div>                                   
                                </div>
                                 <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">เพิ่มเติม</label>
                                            <input class="form-control" type="text" value="{{$case->result_remark}}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <input class="form-control"  type="text"  value="{{$case->person_note}}" readonly>
                                        </div>
                                    </div>
                                </div>
                                @if ($sub)
                                <br>
                                <div class="row"> 
                                    <table class="table table-striped mb-0 text-center table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>รายละเอียด</th>
                                                <th>ชื่อร้าน</th> 
                                                <th>ค่าใช้จ่าย</th>                                                         
                                                <th>แนบไฟล์</th>                                                        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($sub as $item)
                                                <tr>
                                                    <td>{{$item->customer_repair_sub_listno}}</td>
                                                    <td>{{$item->customer_repair_sub_remark}}</td>
                                                    <td>{{$item->customer_repair_sub_vendor}}</td>
                                                    <td>{{number_format($item->customer_repair_sub_cost,2)}}</td>
                                                    <td>
                                                        @if (isset($item->customer_repair_sub_file) && $item->customer_repair_sub_file)
                                                            <a href="{{ asset('/'.$item->customer_repair_sub_file) }}" target="_blank"><i class="fas fa-file"></i></a>                                                                 
                                                        @endif                               
                                                    </td>                                                  
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                @endif 
                                <br>
                                <h5>รายละเอียดอนุมัติ</h5>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">ความเห็นผู้อนุมัติ</label>
                                            <select class="form-select" name="customer_repair_status_id">
                                                @foreach ($sta as $item)
                                                    <option value="{{$item->customer_repair_status_id}}">{{$item->customer_repair_status_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">เพิ่มเติม</label>
                                            <textarea class="form-control" name="approved_remark"></textarea>
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
                            @endif                          
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
let listNoStart = {{ $sub->max('customer_repair_sub_listno') ?? 0 }};
function updateRowNumbers() {
    const rows = document.querySelectorAll('#tableBody tr');
    rows.forEach((row, index) => {
        const listno = listNoStart + index + 1;
        row.querySelector('.row-number').textContent = listno;
        row.querySelector('.row-number-hidden').value = listno;
    });
}
document.addEventListener('DOMContentLoaded', function () {
    const addRowBtn = document.getElementById('addRowBtn');
    if (addRowBtn) {
        addRowBtn.addEventListener('click', function () {
            const tbody = document.getElementById('tableBody');

            const newRow = document.createElement('tr');
            newRow.innerHTML = `
                <td>
                    <span class="row-number"></span>
                    <input type="hidden" name="customer_repair_sub_listno[]" class="row-number-hidden"/>
                </td>
                <td><input type="text" name="customer_repair_sub_remark[]" class="form-control"/></td>               
                <td><input type="text" name="customer_repair_sub_vendor[]" class="form-control"/></td>
                <td><input type="text" name="customer_repair_sub_cost[]" value="0"  class="form-control"/></td>
                <td><input type="file" name="customer_repair_sub_file[]" class="form-control"/></td>
                <td><button type="button" class="btn btn-danger btn-sm deleteRow">ลบ</button></td>
            `;

            tbody.appendChild(newRow);
            updateRowNumbers();
        });
    }
});
document.getElementById('tableBody').addEventListener('click', function (e) {
    if (e.target.classList.contains('deleteRow')) {
        e.target.closest('tr').remove();
        updateRowNumbers(); // อัปเดตลำดับหลังจากลบ
    }
});
</script>
@endsection