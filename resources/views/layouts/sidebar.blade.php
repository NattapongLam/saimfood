 <div class="vertical-menu">
                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Setting</li>
                            @role('superadmin')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-wrench"></i>
                                    <span key="t-starter-page">ตั้งค่าผู้ใช้งาน</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                     <li><a href="{{route('persons.index')}}" key="t-starter-page">ผู้ใช้งาน</a></li>
                                </ul>
                            </li>
                            @endrole 
                            @role('superadmin|admin')
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-wrench"></i>
                                    <span key="t-starter-page">ตั้งค่าพนักงาน</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                     <li><a href="{{route('employees.index')}}" key="t-starter-page">รายชื่อพนักงาน</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-wrench"></i>
                                    <span key="t-starter-page">ตั้งค่าเครื่องจักร</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">  
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow" key="t-starter-page">ภายในองค์กร</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            @can('setup-machinegroup')
                                                <li><a href="{{route('machine-groups.create')}}" key="t-starter-page">กลุ่มเครื่องจักรและอุปกรณ์</a></li>
                                            @endcan
                                            @can('setup-machine')
                                                <li><a href="{{route('machines.index')}}" key="t-starter-page">ใบมาตรฐานของเครื่องจักร</a></li>
                                            @endcan
                                            @can('setup-machineplaning')
                                                <li><a href="{{route('machine-planings.index')}}" key="t-starter-page">ตั้งค่าตรวจเช็คตามแผน</a></li>
                                            @endcan
                                            @can('setup-machinechecksheet')
                                                <li><a href="{{route('machine-checksheets.index')}}" key="t-starter-page">ตั้งค่าตรวจเช็คประจำวัน</a></li>  
                                            @endcan  
                                        </ul>
                                    </li>                               
                                    <li>
                                        @can('setup-equipment')
                                        <a href="javascript: void(0);" class="has-arrow" key="t-starter-page">ลูกค้า</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="{{route('customers.index')}}" key="t-starter-page">ลูกค้า</a></li>
                                            <li><a href="{{route('equipments.index')}}" key="t-starter-page">อุปกรณ์ลูกค้า</a></li>
                                        </ul>
                                        @endcan  
                                    </li>                            
                                </ul>
                            </li>
                            @endrole 
                            @role('superadmin|admin|user')
                            <li class="menu-title" key="t-pages">Pages</li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-detail"></i>
                                    <span key="t-starter-page">งานทั่วไป</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{route('asset-inout.index')}}" key="t-starter-page">ใบนำทรัพย์สินออกนอกบริษัท</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-detail"></i>
                                    <span key="t-starter-page">ซ่อมบำรุง</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li>
                                        <a href="javascript: void(0);" class="has-arrow" key="t-starter-page">ภายในองค์กร</a>
                                        <ul class="sub-menu" aria-expanded="true">   
                                            @can('setup-machineplaning')                                       
                                            <li><a href="{{route('machine-planing-docus.index')}}" key="t-starter-page">แผนการซ่อมบำรุง</a></li>
                                            @endcan
                                            @can('setup-machinechecksheet')
                                            <li><a href="{{route('machine-checksheet-docus.index')}}" key="t-starter-page">ตรวจเช็คประจำวัน</a></li>
                                            @endcan
                                            @can('docu-machine-repair')
                                            <li><a href="{{route('machine-create-docus.index')}}" key="t-starter-page">ใบสร้างงาน</a></li>
                                            @endcan
                                            @can('docu-machine-create')
                                            <li><a href="{{route('machine-repair-docus.index')}}" key="t-starter-page">ใบแจ้งซ่อม</a></li>
                                            @endcan
                                            @can('docu-machine-issuestock')
                                            <li><a href="{{route('machine-issue-docus.index')}}" key="t-starter-page">ใบรับอะไหล่</a></li>
                                            <li><a href="{{ route('stockcardlist') }}" key="t-starter-page">สต็อคอะไหล่</a></li>
                                            @endcan
                                        </ul>
                                    </li>                                  
                                    <li>
                                        @can('setup-equipment')
                                        <a href="javascript: void(0);" class="has-arrow" key="t-starter-page">ลูกค้า</a>
                                        <ul class="sub-menu" aria-expanded="true">
                                            <li><a href="{{route('equipment-transfer.index')}}" key="t-starter-page">ใบโอนย้ายอุปกรณ์</a></li>
                                            <li><a href="{{route('equipment-repair.index')}}" key="t-starter-page">ใบแจ้งซ่อมลูกค้า</a></li>
                                        </ul>
                                        @endcan
                                    </li>
                                   
                                </ul>
                            </li>
                            @can('docu-equipment-request')
                            <li>                               
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-detail"></i>
                                    <span key="t-starter-page">ทีมขาย</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{route('equipment-request.index')}}" key="t-starter-page">ใบร้องขออุปกรณ์</a></li>
                                    <li><a href="{{route('customer-transfer.index')}}" key="t-starter-page">ใบขอย้ายอุปกรณ์ลูกค้า</a></li>
                                </ul>
                            </li>
                            @endcan
                            <li>                               
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-detail"></i>
                                    <span key="t-starter-page">เอกสารควบคุม</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @can('iso-masterlist')
                                    <li><a href="{{route('iso-masterlist.index')}}" key="t-starter-page">Master List</a></li>
                                    @endcan
                                    @can('iso-distributionlist')
                                    <li><a href="{{route('iso-distributionlist.index')}}" key="t-starter-page">การแจกจ่ายเอกสาร</a></li>
                                    @endcan
                                    <li><a href="{{route('iso-ncrlist.index')}}" key="t-starter-page">NCR</a></li>
                                    <li><a href="#" key="t-starter-page">CAR</a></li>
                                    <li><a href="#" key="t-starter-page">Dar</a></li>
                                    <li><a href="#" key="t-starter-page">แผนการ Swab Test</a></li>
                                    @can('iso-airtestplan')
                                    <li><a href="{{route('iso-airtestplan.index')}}" key="t-starter-page">แผนตรวจหาแบคทีเรียในอากาศ</a></li>
                                    @endcan
                                    @can('iso-producttestingplan')
                                    <li><a href="{{route('iso-producttestingplan.index')}}" key="t-starter-page">แผนการส่งตรวจวิเคราะห์สินค้าสำเร็จรูป</a></li>
                                    @endcan
                                    @can('iso-waterqualityplan')
                                    <li><a href="{{route('iso-waterqualityplan.index')}}" key="t-starter-page">แผนการตรวจสอบน้ำใช้ในโรงงาน</a></li>
                                    @endcan
                                </ul>
                            </li>
                            <li>                               
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-detail"></i>
                                    <span key="t-starter-page">เครื่องมือวัด</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    @can('clb-measuringlist')
                                    <li><a href="{{route('clb-measuringlist.index')}}" key="t-starter-page">บัญชีรายชื่อ</a></li>
                                    @endcan
                                    @can('clb-measuringplan')
                                    <li><a href="{{route('clb-measuringplan.index')}}" key="t-starter-page">แผนสอบเทียบ</a></li>
                                    @endcan
                                </ul>
                            </li>
                            @endrole
                            <li class="menu-title" key="t-pages">Report</li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-bar-chart-alt-2"></i>
                                    <span key="t-starter-page">รายงานซ่อมบำรุง</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{url('/report-calendar-pm')}}" key="t-starter-page">ปฏิทิน PM</a></li>
                                    <li><a href="{{url('/report-machine')}}" key="t-starter-page">ภาพรวม</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-bar-chart-alt-2"></i>
                                    <span key="t-starter-page">รายงานอุปกรณ์ลูกค้า</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="true">
                                    <li><a href="{{url('/report-equipment')}}" key="t-starter-page">ภาพรวม</a></li>
                                </ul>
                            </li>
                            
                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>