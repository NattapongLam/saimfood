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
                            <div class="card-body">
                                <div class="row"> 
                                    <h5 class="text-center"><strong>สมุดสุขภาพประจำตัวของลูกจ้าง ซึ่งทำงานเกี่ยวกับปัจจัยเสี่ยง</strong></h5>
                                    <h5 class="text-center"><strong>กฎกระทรวง กำหนดมาตรฐานการรตรวจสุขภาพลูกจ้างซึ่งทำงานเกี่ยวกับปัจจัยเสี่ยง พ.ศ. ๒๕๖๓</strong></h5>
                                    <h5 class="text-center"><strong>ชื่อ - นามสกุล {{$emp->personfullname}}</strong></h5>
                                    <h5 class="text-center"><strong>ชื่อสถานประกอบกิจการ {{$emp->company}}</strong></h5>
                                    <h5 class="text-center"><strong>
                                        รัฐมนตรีว่าการกระทรวงแรงงานออกกฎกระทรวงกำหนดมาตรฐานการ ตรวจสุขภาพลูกจ้างซึ่งทำงานเกี่ยวกับปัจจัยเสี่ยง พ.ศ. ๒๕๖๓ โดยกำหนดให้ 
                                        นายจ้างจัดให้มีสมุดสุขภาพประจำตัวของลูกจ้างซึ่งทำงาน เกี่ยวกับปัจจัยเสี่ยง ตามแบบที่อธิบดีประกาศกำหนด และให้นายจ้างบันทึกผลการตรวจสุขภาพ
                                        ลูกจ้างในสมุดสุขภาพประจำตัวของลูกจ้างตามผลการตรวจของแพทย์ทุกครั้ง ที่มีการตรวจสุขภาพ
                                    </strong></h5>
                                    <h5><strong>"งานเกี่ยวกับปัจจัยเสี่ยง" หมายความว่า  งานที่ลูกจ้างทำเกี่ยวกับ</strong></h5>
                                    <h5><strong>(๑) สารเคมีอันตรายตามที่อธิบดีประกาศกำหนด</strong></h5>
                                    <h5><strong>(๒) จุลชีวันเป็นพิษซึ่งอาจเป็นเชื้อไวรัส แบคทีเรีย รา หรือสารชีวภาพอื่น</strong></h5>
                                    <h5><strong>(๓) กัมมันตภาพรังสี</strong></h5>
                                    <h5><strong>(๔) ความร้อน ความเย็น ความสั่นสะเทือน ความกดดันบรรยากาศ แสง หรือเสียง</strong></h5>
                                    <h5><strong>(๕) สภาพแวดล้อมอื่นที่อาจเป็นอันตรายต่อสุขภาพของลูกจ้าง เช่น ฝุ่นฝ้าย ฝุ่นไม้ ไอควันจากการเผาไหม้</strong></h5>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row"> 
                    <h5 class="text-center"><strong>ประวัติส่วนตัว</strong></h5>
                    <h5><strong>ชื่อ - นามสกุล {{$emp->personfullname}}</strong></h5>
                    <h5><strong>วัน เดือน ปี เกิด {{ \Carbon\Carbon::parse($emp->BirthDate)->format('d/m/Y') }} เพศ  {{$emp->SexT}}</strong></h5>
                    <h5><strong>วันที่เข้าทำงาน {{ \Carbon\Carbon::parse($emp->StartDate)->format('d/m/Y') }}</strong></h5>
                    <h5><strong>๑. เลขที่บัตรประจำตัวประชาชน {{$emp->TaxID}}</strong></h5>
                    <h5><strong>๒. ที่อยู่ตามบัตรประชาชน</strong></h5>
                    <h5><strong>เลขที่ {{$emp->CardAddress}}</strong></h5>
                    <h5><strong>ซอย {{$emp->CardSoi}} ถนน {{$emp->CardRoad}}</strong></h5>
                    <h5><strong>ตำบล(แขวง) {{$emp->DistrictT}} อำเภอ(เขต) {{$emp->AmphurT}}</strong></h5>
                    <h5><strong>จังหวัด {{$emp->ProveNameT}} รหัสไปรษณีย์ {{$emp->CardPostID}}</strong></h5>
                    <h5><strong>โทรศัพท์ {{$emp->CardTel}}</strong></h5>
                    <h5><strong>๓. ที่อยู่ที่สามารถติดต่อได้</strong></h5>
                    <h5><strong>เลขที่ {{$emp->CurrentAddress}}</strong></h5>
                    <h5><strong>ซอย {{$emp->CurrentSoi}} ถนน {{$emp->CurrentRoad}}</strong></h5>
                    <h5><strong>ตำบล(แขวง) {{$emp->CurrentDistricName}} อำเภอ(เขต) {{$emp->CurrentAmphurName}}</strong></h5>
                    <h5><strong>จังหวัด {{$emp->CurrentProvinceName}} รหัสไปรษณีย์ {{$emp->CurrentPostID}}</strong></h5>
                    <h5><strong>โทรศัพท์ {{$emp->CurrentTel}}</strong></h5>
                    <h5><strong>๔. ชื่อสถานประกอบกิจการ</strong></h5>
                    <h5><strong>เลขที่ {{$emp->Company_Add}}</strong></h5>
                    <h5><strong>ซอย {{$emp->Company_Soi}} ถนน {{$emp->Company_Stree}}</strong></h5>
                    <h5><strong>ตำบล(แขวง) บ้านคลองสวน อำเภอ(เขต) พระสมุทรเจดีย์</strong></h5>
                    <h5><strong>จังหวัด สมุทรปราการ รหัสไปรษณีย์ {{$emp->Company_PostalCode}}</strong></h5>
                    <h5><strong>โทรศัพท์ {{$emp->Company_Tel}}</strong></h5>
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