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
                                    <h5 class="text-center"><strong>"งานเกี่ยวกับปัจจัยเสี่ยง" หมายความว่า  งานที่ลูกจ้างทำเกี่ยวกับ</strong></h5>
                                    <h5 class="text-center"><strong>(๑) สารเคมีอันตรายตามที่อธิบดีประกาศกำหนด</strong></h5>
                                    <h5 class="text-center"><strong>(๒) จุลชีวันเป็นพิษซึ่งอาจเป็นเชื้อไวรัส แบคทีเรีย รา หรือสารชีวภาพอื่น</strong></h5>
                                    <h5 class="text-center"><strong>(๓) กัมมันตภาพรังสี</strong></h5>
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