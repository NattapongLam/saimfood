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
                                    <h5 class="my-0 text-primary"><i class="mdi mdi-bullseye-arrow me-3"></i>รายงานงานปกติ</h5>
                            </div>
                        </div>
                          <div class="row">
                            @foreach ($hd as $item)
                            <div class="col-xl-6 col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            

                                            <div class="flex-grow-1 overflow-hidden">
                                                <h6>{{$item->machine_repair_dochd_docuno}} ({{$item->person_at}})</h6>
                                                <h5 class="text-truncate font-size-15"><a href="javascript: void(0);" class="text-dark">{{$item->machine_code}}</a></h5>
                                                <p class="text-muted mb-4"><strong> รายละเอียด : </strong>{{$item->machine_repair_dochd_case}}</p>
                                                <p class="text-muted mb-4"><strong> สถานที่ : </strong>{{$item->machine_repair_dochd_location}}</p>
                                                @if ($item->repairer_note)
                                                    <p class="text-muted mb-4"><strong> ผลการดำเนินงาน : </strong>{{$item->repairer_note}}
                                                        @if ($item->repairer_type)
                                                        <br> 
                                                        ({{$item->repairer_type}}/{{$item->repairer_problem}})
                                                        @endif  
                                                    </p>                               
                                                @endif                                               
                                                <p class="text-muted mb-4"><strong> ผู้รับงาน : </strong>
                                                    @if ($item->accepting_at)
                                                        {{$item->accepting_at}} 
                                                        @if ($item->accepting_note)
                                                            ({{$item->accepting_note}})      
                                                        @endif
                                                    @endif
                                                </p>
                                                <p class="text-muted mb-4"><strong> ผู้อนุมัติ : </strong>
                                                    @if ($item->approval_at)
                                                        {{$item->approval_at}} 
                                                        @if ($item->approval_note)
                                                            ({{$item->approval_note}})    
                                                        @endif 
                                                    @endif
                                                </p>
                                                <p class="text-muted mb-4"><strong> ผู้ดำเนินงาน : </strong>
                                                    @if ($item->repairer_at)
                                                        {{$item->repairer_at}}    
                                                    @endif
                                                </p>
                                                <p class="text-muted mb-4"><strong> ผู้ตรวจสอบ : </strong>
                                                    @if ($item->inspector_at)
                                                        {{$item->inspector_at}} 
                                                        @if($item->inspector_note)
                                                            ({{$item->inspector_note}})
                                                        @endif
                                                              
                                                    @endif
                                                </p>
                                                <p class="text-muted mb-4"><strong> ผู้ปิดงาน : </strong>
                                                    @if ($item->closing_at)
                                                        {{$item->closing_at}} 
                                                        @if ($item->closing_note)
                                                            ({{$item->closing_note}})   
                                                        @endif
                                                           
                                                    @endif
                                                </p>
                                                <p class="text-muted mb-4"><strong> มูลค่า : </strong>
                                                     {{$item->total_cost}}
                                                </p>    
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 border-top">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item me-3">
                                                <span class="badge bg-success">{{$item->machine_repair_status_name}}</span>
                                            </li>
                                            <li class="list-inline-item me-3">
                                                <i class= "bx bx-comment-dots me-1"></i> {{$item->machine_repair_dochd_type}}
                                            </li>
                                            <li class="list-inline-item me-3">
                                                <strong> วันที่ร้องขอ : </strong><i class= "bx bx-calendar me-1"></i> {{$item->machine_repair_dochd_date}}<br>
                                                <strong> วันที่ต้องการเสร็จ : </strong><i class= "bx bx-calendar me-1"></i> {{$item->accepting_duedate}}
                                            </li>
                                            
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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