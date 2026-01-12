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
                                <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>แผนการซ่อมบำรุง</h5>
                             <div class="page-title-right">                                             
                        </div>
                            </div>
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('machine-planing-docus.store') }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf      
                                <div class="row"> 
                                   <div class="col-3">
                                        <div class="form-group">
                                            <label class="form-label">ปี</label>
                                            <select class="form-control" name="machine_planingdocu_hd_date" required>
                                            @for ($i = date('Y'); $i >= 2025; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-9">
                                        <label class="form-label">หมายเหตุ</label>
                                        <input class="form-control" type="text" name="machine_planingdocu_hd_note">
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="form-label">กลุ่มเครื่องจักร</label>
                                            <select class="select2 form-select" name="machinegroup_id" id="machinegroup-select">
                                                <option value="">กรุณาเลือก</option>
                                                @foreach ($group as $item)
                                                    <option value="{{ $item->machinegroup_id }}">{{ $item->machinegroup_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <table class="table table-bordered dt-responsive  nowrap w-100 text-center">
                                        <thead>
                                            <tr>
                                                <th>วันที่</th>
                                                <th>เครื่องจักร</th>
                                                <th>หมายเหตุ</th>
                                                <th>ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody id="machine-table-body"></tbody>
                                        {{-- <tbody>
                                            @if($hd > 0)
                                                @foreach ($hd as $item)
                                                    <tr>
                                                        <td>
                                                            <input class="form-control" name="machine_planingdocu_dt_date[]" type="date">
                                                        </td>
                                                        <td>
                                                            <img src="{{ asset($item->machine_pic1 ?? 'images/no-image.png') }}" alt="Machine Image" class="rounded-circle avatar-xl"><br>
                                                            {{$item->machine_code}}/{{$item->machine_name}}
                                                            <input class="form-control" value="{{$item->machine_code}}" name="machine_code[]" type="hidden">
                                                        </td>
                                                        <td>
                                                            <input class="form-control" name="machine_planingdocu_dt_note[]" type="text">
                                                        </td>
                                                        <td>
                                                            <button type="button" class="btn btn-danger btn-sm delete-row">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </button>
                                                        </td>   
                                                    </tr>
                                                @endforeach
                                            @endif                                          
                                        </tbody> --}}
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
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-row').forEach(function (button) {
        button.addEventListener('click', function () {
            this.closest('tr').remove();
        });
    });
});
$(document).ready(function () {
    $('.select2').select2({
        placeholder: "เลือกกลุ่มเครื่องจักร",
        allowClear: true,
        width: '100%'
    });
});
$(document).ready(function () {
        $('#machinegroup-select').on('change', function () {
            var groupId = $(this).val();

            $.ajax({
                url: '/api/machines-by-group', // เปลี่ยนตาม route จริงของคุณ
                method: 'GET',
                data: { machinegroup_id: groupId },
                success: function (data) {
                    var tbody = '';
                    if(data.length === 0) {
                        tbody = '<tr><td colspan="4">ไม่พบข้อมูลเครื่องจักรในกลุ่มนี้</td></tr>';
                    } else {
                        data.forEach(function (item) {
                            tbody += '<tr>';
                            tbody += `<td><input class="form-control" name="machine_planingdocu_dt_date[]" type="date"></td>`;
                            tbody += `<td><img src="${item.machine_pic1 ? '/storage/' + item.machine_pic1 : '/images/no-image.png'}" alt="Machine Image" class="rounded-circle avatar-xl"><br>${item.machine_code} / ${item.machine_name}<input class="form-control" value="${item.machine_code}" name="machine_code[]" type="hidden"></td>`;
                            tbody += `<td><input class="form-control" name="machine_planingdocu_dt_note[]" type="text"></td>`;
                            tbody += `<td><button type="button" class="btn btn-danger btn-sm delete-row"><i class="fas fa-trash-alt"></i></button></td>`;
                            tbody += '</tr>';
                        });
                    }
                    $('#machine-table-body').html(tbody);
                },
                error: function () {
                    alert('เกิดข้อผิดพลาดในการโหลดข้อมูล');
                }
            });
        });

        // ถ้ามีปุ่มลบแถว ให้ลบแถวออก (delegate event)
        $(document).on('click', '.delete-row', function () {
            $(this).closest('tr').remove();
        });
});
</script>
@endsection