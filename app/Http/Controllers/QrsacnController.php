<?php

namespace App\Http\Controllers;

use App\Models\Machine;
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
        ->select('equipment_transfer_dts.*','equipment_transfer_hds.equipment_transfer_hd_date','equipment_transfer_hds.customer_address','equipment.equipment_pic1','equipment_transfer_hds.equipment_transfer_hd_docuno')
        ->where('equipment_transfer_hds.equipment_transfer_hd_docuno',$id)
        ->where('equipment_transfer_dts.equipment_transfer_dt_flag',true)
        ->get();
        return view('qr-customer-transfer',compact('hd'));
    }
}
