<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\MachineRepairDochd;
use Illuminate\Support\Facades\DB;
use App\Models\EquipmentTransferDt;
use App\Models\EquipmentTransferHd;
use App\Models\MachinePlaningdocuHd;
use App\Models\MachineChecksheetDocuHd;

class QrsacnController extends Controller
{
    public function QrcodeScanMachine($id)
    {
        $mc = Machine::where('machine_code',$id)->first();
        $checksheet = MachineChecksheetDocuHd::where('machine_code',$id)->where('machine_checksheet_docu_hd_flag',1)->get();
        $repair = MachineRepairDochd::leftjoin('machine_repair_statuses','machine_repair_dochds.machine_repair_status_id','=','machine_repair_statuses.machine_repair_status_id')
        ->where('machine_code',$id)->get();
        $plan = MachinePlaningdocuHd::leftjoin('machine_planingdocu_dts','machine_planingdocu_hds.machine_planingdocu_hd_id','=','machine_planingdocu_dts.machine_planingdocu_hd_id')
        ->where('machine_planingdocu_hds.machine_planingdocu_hd_flag',true)
        ->where('machine_planingdocu_dts.machine_planingdocu_dt_flag',true)
        ->where('machine_code',$id)
        ->get();
        return view('qr-machine-all',compact('mc','checksheet','repair','plan'));
    }

    public function QrcodeScanCustomerTransfer($id)
    {
        $hd = DB::table('equipment_transfer_hds')
        ->leftjoin('equipment_transfer_dts','equipment_transfer_hds.equipment_transfer_hd_id','=','equipment_transfer_dts.equipment_transfer_hd_id')
        ->leftjoin('equipment','equipment.equipment_id','=','equipment_transfer_dts.equipment_id')        
        ->select(
            'equipment_transfer_dts.*',
            'equipment_transfer_hds.equipment_transfer_hd_date',
            'equipment_transfer_hds.customer_address',
            'equipment.equipment_pic1',
            'equipment_transfer_hds.equipment_transfer_hd_docuno'
        )
        ->where('equipment_transfer_hds.equipment_transfer_hd_docuno', $id)
        ->where('equipment_transfer_dts.equipment_transfer_dt_flag', true)
        ->whereNotIn('equipment_transfer_hds.equipment_transfer_status_id',[6,3])
        ->get();
        // สร้างตัวแปรเก็บข้อมูล cases ต่อแต่ละ equipment_transfer_dt_id
        $hd = $hd->map(function($item) {
            // ดึงข้อมูล case 1 แถวล่าสุด โดยเรียงตาม ID หรือวันที่ล่าสุด เช่น สมมติมี column updated_at
            $case = DB::table('customer_repair_docus')
                ->leftjoin('customer_repair_statuses','customer_repair_docus.customer_repair_status_id','=','customer_repair_statuses.customer_repair_status_id')
                ->where('transfer_id', $item->equipment_transfer_dt_id)
                ->orderByDesc('customer_repair_docu_id')  // หรือเปลี่ยนเป็น orderByDesc('updated_at') หรือวันที่ที่เหมาะสม
                ->first();

            // เพิ่มข้อมูล case เข้าไปใน item
            $item->case = $case;

            return $item;
        });

        return view('qr-customer-transfer', compact('hd'));

    }
     
    public function QrcodeScanEquipment($id)
    {
        $mc = Equipment::leftjoin('equipment_statuses','equipment.equipment_status_id','=','equipment_statuses.equipment_status_id')
        ->where('equipment.equipment_code',$id)
        ->first();
        $hd = DB::table('customer_repair_docus')
        ->leftjoin('customer_repair_statuses','customer_repair_docus.customer_repair_status_id','=','customer_repair_statuses.customer_repair_status_id')
        ->where('customer_repair_docus.equipment_id',$mc->equipment_id)
        ->get();
        return view('qr-equipment-all',compact('mc','hd'));
    }
}