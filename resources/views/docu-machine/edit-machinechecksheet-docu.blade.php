@extends('layouts.main')
@section('content')
<link href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" rel="stylesheet" />
<link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet" />
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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>ตรวจเช็คประจำวัน</h5>                               
                            </div>                         
                            <div class="card-body">
                                <form class="custom-validation" action="{{ route('machine-checksheet-docus.update',$hd->machine_checksheet_docu_hd_id) }}" method="POST" enctype="multipart/form-data" validate>
                                @csrf  
                                @method('PUT')        
                                <div class="row"> 
                                    <div class="col-6">
                                        <div class="form-group">
                                            <h5>ประจำเดือน : {{ \Carbon\Carbon::parse($hd->machine_checksheet_docu_hd_date)->format('M-y') }}</h5><br>
                                            <img src="{{ asset($hd->machine_pic1 ?? 'images/no-image.png') }}" alt="Machine Image" class="rounded-circle avatar-xl"><br>
                                            <h5>{{$hd->machine_code}} / {{$hd->machine_name}}</h5>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="form-label">หมายเหตุ</label>
                                            <textarea class="form-control" name="machine_checksheet_docu_hd_note">{{$hd->machine_checksheet_docu_hd_note}}</textarea>
                                        </div>
                                    </div>                                   
                                </div>
                                <br>
                                <div class="row">
                                    <div style="overflow-x: auto;">
                                        <table class="table table-bordered nowrap w-100 text-center" id="detailTable">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>รายละเอียด</th>
                                                        @for ($i = 1; $i <= 31; $i++)
                                                            <th>{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                                                        @endfor
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($hd->details as $index => $item)
                                                        <tr>
                                                            <td>
                                                                {{ $index + 1 }}
                                                                <input type="hidden" name="machine_checksheet_docu_dt_id[{{ $index }}]" value="{{ $item->machine_checksheet_docu_dt_id }}">
                                                            </td>
                                                            <td>{{ $item->machine_checksheet_dt_remark }}</td>
                                                            @for ($i = 1; $i <= 31; $i++)
                                                                @php
                                                                    $field = 'check_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                                                                @endphp
                                                                <td>
                                                                     <input type="checkbox" name="check_{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}[{{ $index }}]" value="1" {{ $item->$field ? 'checked' : '' }}>
                                                                </td>
                                                            @endfor
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                        </table>
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
<script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
<script>
$(document).ready(function () {
    $('#detailTable').DataTable({
        scrollX: true,
        scrollCollapse: true,
        paging: false,
        ordering: false,
        searching: false,
        info: false,
        fixedColumns: {
            leftColumns: 2
        }
    });
});
</script>
@endsection