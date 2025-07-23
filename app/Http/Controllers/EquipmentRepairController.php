<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\CustomerRepairSub;
use App\Models\CustomerRepairDocu;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerRepairStatus;
use Illuminate\Support\Facades\Auth;

class EquipmentRepairController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $case = CustomerRepairDocu::leftjoin('customer_repair_statuses','customer_repair_docus.customer_repair_status_id','=','customer_repair_statuses.customer_repair_status_id')
        ->select('customer_repair_docus.*','customer_repair_statuses.customer_repair_status_name')
        ->get();
        return view('docu-equipment.list-equipmentrepair',compact('case'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $case = CustomerRepairDocu::leftjoin('customer_repair_statuses','customer_repair_docus.customer_repair_status_id','=','customer_repair_statuses.customer_repair_status_id')
        ->find($id);
        $sub = CustomerRepairSub::where('customer_repair_docu_id',$id)->where('customer_repair_sub_flag',true)->get();
        $sta = CustomerRepairStatus::whereIn('customer_repair_status_id',[3,4,5])->get();
        $equi = Equipment::where('equipment_flag',true)->where('equipment_status_id',1)->get();
        return view('docu-equipment.edit-equipmentrepair',compact('case','sub','sta','equi'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $ck = CustomerRepairDocu::find($id);
        if($ck->customer_repair_status_id == 1 || $ck->customer_repair_status_id == 5){
            $request->validate([
                'person_result' => 'required',
                'result_remark' => 'required',
                'person_date' => 'required',
            ]);
            $data = [
                'customer_repair_status_id' => 2,
                'person_at' => Auth::user()->name,
                'person_datetime'=> now(),
                'person_date' => $request->person_date,
                'updated_at' => now(),
                'person_result' => $request->person_result,
                'result_remark' => $request->result_remark,
                'person_note' => $request->person_note
            ];
            try {
            DB::beginTransaction();
            CustomerRepairDocu::where('customer_repair_docu_id',$id)->update($data);
            DB::table('equipment_transfer_dts')
            ->where('equipment_transfer_dt_id',$ck->transfer_id)
            ->update([
                'equipment_transfer_status_id' => 5
            ]);
            DB::table('equipment')
            ->where('equipment_id',$ck->equipment_id)
            ->update([
                'equipment_status_id' => 5,
            ]);
            $listnos = $request->customer_repair_sub_listno ?? [];
            $ids = $request->customer_repair_sub_id ?? [];
            foreach ($listnos as $key => $listno) {
                $docdtId = $ids[$key] ?? null;
                $costRaw = $request->customer_repair_sub_cost[$key] ?? 0;
                $remark = $request->customer_repair_sub_remark[$key] ?? null;
                $vendor = $request->customer_repair_sub_vendor[$key] ?? "-";
                $flag = $request->customer_repair_sub_flag[$key] ?? false;
                $flag = $flag == 'on' || $flag == 'true' ? true : false;
                if ($costRaw === null || $remark === null || $vendor === null) {
                    continue; // หรือแจ้งเตือนว่าข้อมูลไม่ครบ
                }
                $cost = str_replace(',', '', $costRaw);
                $filePath = null;
                if ($request->hasFile('customer_repair_sub_file') && isset($request->file('customer_repair_sub_file')[$key])) {
                    $file = $request->file('customer_repair_sub_file')[$key];
                    if ($file && $file->isValid()) {
                        $filename = "ET_FILE_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('equipment_repair_img', $filename, 'public');
                        $filePath = 'storage/equipment_repair_img/' . $filename;
                    }
                }
                if ($docdtId) {
                    CustomerRepairSub::where('customer_repair_sub_id', $docdtId)
                    ->update([
                        'customer_repair_sub_listno' => $listno,
                        'customer_repair_sub_remark' => $remark,
                        'customer_repair_sub_vendor' => $vendor,
                        'customer_repair_sub_cost' => $cost,
                        'customer_repair_sub_file' => $filePath,
                        'customer_repair_sub_flag' => $flag,
                        'person_at' => Auth::user()->name,
                        'updated_at' => now()
                    ]);
                }else{
                    CustomerRepairSub::create([
                        'customer_repair_docu_id' => $ck->customer_repair_docu_id,
                        'customer_repair_sub_listno' => $listno,
                        'customer_repair_sub_remark' => $remark,
                        'customer_repair_sub_vendor' => $vendor,
                        'customer_repair_sub_cost' => $cost,
                        'customer_repair_sub_file' => $filePath,
                        'customer_repair_sub_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }              
            }
            DB::commit();
            return redirect()->route('equipment-repair.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('equipment-repair.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }  
        }elseif($ck->customer_repair_status_id == 2){
            $data = [
                'customer_repair_status_id' => $request->customer_repair_status_id,
                'approved_at' => Auth::user()->name,
                'approved_date'=> now(),
                'updated_at' => now(),
                'approved_remark' => $request->approved_remark,
            ];
                try {
            DB::beginTransaction();
            CustomerRepairDocu::where('customer_repair_docu_id',$id)->update($data);
            if($request->customer_repair_status_id == 3){
                DB::table('equipment')
                    ->where('equipment_id',$ck->equipment_id)
                    ->update([
                        'equipment_status_id' => 6,
                ]);   
            }elseif($request->customer_repair_status_id == 4){
                DB::table('equipment')
                    ->where('equipment_id',$ck->equipment_id)
                    ->update([
                        'equipment_status_id' => 7,
                ]);   
            }                
            DB::commit();
            return redirect()->route('equipment-repair.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('equipment-repair.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }  
        }elseif($ck->customer_repair_status_id == 3){
            if($ck->person_result == "เปลี่ยนเครื่องใหม่")
            {
                $equi = Equipment::find($request->change_equipment_id);
                $change_id = $equi->equipment_id;
                $change_code = $equi->equipment_code;
                $change_name = $equi->equipment_name;
                DB::table('equipment_transfer_dts')
                ->where('equipment_transfer_dt_id',$ck->transfer_id)
                ->update([
                    'equipment_transfer_status_id' => 1,
                    'equipment_id' => $change_id,
                    'equipment_code' => $change_code,
                    'equipment_name' => $change_name,
                ]);
            }
            else{
                $change_id = 0;
                $change_code = "-";
                $change_name = "-";
            }
            $data = [
                'customer_repair_status_id' => 6,
                'result_at' => Auth::user()->name,
                'result_date'=> now(),
                'result_note' => $request->result_note,
                'updated_at' => now(),
                'change_equipment_id' => $change_id,
                'change_equipment_code' => $change_code,
                'change_equipment_name' => $change_name,
            ];
             try {
            DB::beginTransaction();
            CustomerRepairDocu::where('customer_repair_docu_id',$id)->update($data);
            DB::table('equipment_transfer_dts')
            ->where('equipment_transfer_dt_id',$ck->transfer_id)
            ->update([
                'equipment_transfer_status_id' => 1
            ]);
            DB::table('equipment')
            ->where('equipment_id',$ck->equipment_id)
            ->update([
                'equipment_status_id' => 2,
            ]);
            $listnos = $request->customer_repair_sub_listno ?? [];
            $ids = $request->customer_repair_sub_id ?? [];
            foreach ($listnos as $key => $listno) {
                $docdtId = $ids[$key] ?? null;
                $costRaw = $request->customer_repair_sub_cost[$key] ?? 0;
                $remark = $request->customer_repair_sub_remark[$key] ?? null;
                $vendor = $request->customer_repair_sub_vendor[$key] ?? "-";
                $flag = $request->customer_repair_sub_flag[$key] ?? false;
                $flag = $flag == 'on' || $flag == 'true' ? true : false;
                if ($costRaw === null || $remark === null || $vendor === null) {
                    continue; // หรือแจ้งเตือนว่าข้อมูลไม่ครบ
                }
                $cost = str_replace(',', '', $costRaw);
                $filePath = null;
                if ($request->hasFile('customer_repair_sub_file') && isset($request->file('customer_repair_sub_file')[$key])) {
                    $file = $request->file('customer_repair_sub_file')[$key];
                    if ($file && $file->isValid()) {
                        $filename = "ET_FILE_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('equipment_repair_img', $filename, 'public');
                        $filePath = 'storage/equipment_repair_img/' . $filename;
                    }
                }
                if ($docdtId) {
                    CustomerRepairSub::where('customer_repair_sub_id', $docdtId)
                    ->update([
                        'customer_repair_sub_listno' => $listno,
                        'customer_repair_sub_remark' => $remark,
                        'customer_repair_sub_vendor' => $vendor,
                        'customer_repair_sub_cost' => $cost,
                        'customer_repair_sub_file' => $filePath,
                        'customer_repair_sub_flag' => $flag,
                        'person_at' => Auth::user()->name,
                        'updated_at' => now()
                    ]);
                }else{
                    CustomerRepairSub::create([
                        'customer_repair_docu_id' => $ck->customer_repair_docu_id,
                        'customer_repair_sub_listno' => $listno,
                        'customer_repair_sub_remark' => $remark,
                        'customer_repair_sub_vendor' => $vendor,
                        'customer_repair_sub_cost' => $cost,
                        'customer_repair_sub_file' => $filePath,
                        'customer_repair_sub_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }              
            }
            DB::commit();
            return redirect()->route('equipment-repair.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('equipment-repair.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }  
        }elseif($ck->customer_repair_status_id == 6){
            $data = [
                'customer_repair_status_id' => 7,
                'delivery_at' => Auth::user()->name,
                'delivery_date'=> $request->delivery_date,
                'result_note' => $request->result_note,
                'updated_at' => now(),
                'delivery_address' => $request->delivery_address
            ];
             try {
            DB::beginTransaction();
            CustomerRepairDocu::where('customer_repair_docu_id',$id)->update($data);
            DB::table('equipment_transfer_dts')
            ->where('equipment_transfer_dt_id',$ck->transfer_id)
            ->update([
                'equipment_transfer_status_id' => 2
            ]);
            DB::table('equipment')
            ->where('equipment_id',$ck->equipment_id)
            ->update([
                'equipment_status_id' => 3,
            ]);
            $listnos = $request->customer_repair_sub_listno ?? [];
            $ids = $request->customer_repair_sub_id ?? [];
            foreach ($listnos as $key => $listno) {
                $docdtId = $ids[$key] ?? null;
                $costRaw = $request->customer_repair_sub_cost[$key] ?? 0;
                $remark = $request->customer_repair_sub_remark[$key] ?? null;
                $vendor = $request->customer_repair_sub_vendor[$key] ?? "-";
                $flag = $request->customer_repair_sub_flag[$key] ?? false;
                $flag = $flag == 'on' || $flag == 'true' ? true : false;
                if ($costRaw === null || $remark === null || $vendor === null) {
                    continue; // หรือแจ้งเตือนว่าข้อมูลไม่ครบ
                }
                $cost = str_replace(',', '', $costRaw);
                $filePath = null;
                if ($request->hasFile('customer_repair_sub_file') && isset($request->file('customer_repair_sub_file')[$key])) {
                    $file = $request->file('customer_repair_sub_file')[$key];
                    if ($file && $file->isValid()) {
                        $filename = "ET_FILE_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
                        $file->storeAs('equipment_repair_img', $filename, 'public');
                        $filePath = 'storage/equipment_repair_img/' . $filename;
                    }
                }
                if ($docdtId) {
                    CustomerRepairSub::where('customer_repair_sub_id', $docdtId)
                    ->update([
                        'customer_repair_sub_listno' => $listno,
                        'customer_repair_sub_remark' => $remark,
                        'customer_repair_sub_vendor' => $vendor,
                        'customer_repair_sub_cost' => $cost,
                        'customer_repair_sub_file' => $filePath,
                        'customer_repair_sub_flag' => $flag,
                        'person_at' => Auth::user()->name,
                        'updated_at' => now()
                    ]);
                }else{
                    CustomerRepairSub::create([
                        'customer_repair_docu_id' => $ck->customer_repair_docu_id,
                        'customer_repair_sub_listno' => $listno,
                        'customer_repair_sub_remark' => $remark,
                        'customer_repair_sub_vendor' => $vendor,
                        'customer_repair_sub_cost' => $cost,
                        'customer_repair_sub_file' => $filePath,
                        'customer_repair_sub_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }              
            }
            DB::commit();
            return redirect()->route('equipment-repair.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('equipment-repair.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            } 
        }      
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
