<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use App\Models\Equipment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EquipmentTransferHd;
use App\Models\EquipmentRequestDocu;
use Illuminate\Support\Facades\Auth;

class EquipmentTransferController extends Controller
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
        $hd = EquipmentTransferHd::leftjoin('equipment_transfer_statuses','equipment_transfer_hds.equipment_transfer_status_id','=','equipment_transfer_statuses.equipment_transfer_status_id')
        ->leftjoin('equipment_request_docus','equipment_transfer_hds.equipment_request_docu_id','=','equipment_request_docus.equipment_request_docu_id')
        ->select('equipment_transfer_hds.*','equipment_transfer_statuses.equipment_transfer_status_name','equipment_request_docus.equipment_request_docu_docuno')
        ->get();
        return view('docu-equipment.list-equipmenttransfer',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $docu = EquipmentRequestDocu::leftjoin('customers','equipment_request_docus.customer_id','=','customers.customer_id')
        ->select('equipment_request_docus.*','customers.branch_name')
        ->where('equipment_request_docus.equipment_request_status_id',3)
        ->get();
        $equi = Equipment::where('equipment_flag',true)->where('equipment_status_id',1)->get();
        return view('docu-equipment.create-equipmenttransfer',compact('equi','docu'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $docs_last = DB::table('equipment_transfer_hds')
            ->where('equipment_transfer_hd_docuno', 'like', '%' . date('ym') . '%')
            ->orderBy('equipment_transfer_hd_id', 'desc')->first();
        if ($docs_last) {
            $docs = 'ETS' . date('ym')  . str_pad($docs_last->equipment_transfer_hd_docunum + 1, 4, '0', STR_PAD_LEFT);
            $docs_number = $docs_last->equipment_transfer_hd_docunum + 1;
        } else {
            $docs = 'ETS' . date('ym')  . str_pad(1, 4, '0', STR_PAD_LEFT);
            $docs_number = 1;
        }
        $request->validate([
            'equipment_transfer_hd_date' => 'required',
            'customer_id' => 'required',
            'contact_person' => 'required',
            'contact_tel' => 'required',
            'customer_address' => 'required',
            'equipment_id' => 'required',
            'equipment_request_docu_id' => 'required',
            'equipment_request_docu_duedate' => 'required',
        ]);
        $data = [
            'equipment_transfer_status_id' => 1,
            'equipment_transfer_hd_date' => $request->equipment_transfer_hd_date,
            'contact_person' => $request->contact_person,
            'contact_tel' => $request->contact_tel,  
            'customer_fullname' => $request->customer_fullname,         
            'customer_address' => $request->customer_address,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
            'customer_id' => $request->customer_id,
            'equipment_transfer_hd_docuno' => $docs,
            'equipment_transfer_hd_docunum' => $docs_number,
            'equipment_transfer_hd_remark' => $request->equipment_transfer_hd_remark,
            'equipment_request_docu_id' => $request->equipment_request_docu_id,
            'equipment_request_docu_duedate' => $request->equipment_request_docu_duedate,
            'equipment_request_docu_remark' => $request->equipment_request_docu_remark,
            'approved_remark' => $request->approved_remark
        ]; 
        try {
            DB::beginTransaction();
            $hd = EquipmentTransferHd::create($data);
            if ($request->has('equipment_id')) {
                $equipment_ids = array_values($request->equipment_id);
                $equipment_codes = array_values($request->equipment_code);
                $equipment_names = array_values($request->equipment_name);
                $serial_numbers = array_values($request->serial_number ?? []);
                $remarks = array_values($request->equipment_transfer_dt_remark ?? []);
                foreach ($equipment_ids as $index => $equipment_id) {
                    DB::table('equipment_transfer_dts')->insert([
                        'equipment_transfer_hd_id' => $hd->equipment_transfer_hd_id,
                        'equipment_transfer_dt_listno' => $index + 1,
                        'equipment_code' => $equipment_codes[$index] ?? '',
                        'equipment_name' => $equipment_names[$index] ?? '',
                        'serial_number' => $serial_numbers[$index] ?? '',
                        'equipment_transfer_dt_remark' => $remarks[$index] ?? null,
                        'equipment_transfer_dt_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at'=> now(),
                        'updated_at'=> now(),
                        'equipment_id' => $equipment_id,
                        'equipment_transfer_status_id' => 1
                    ]);
                    $upequipment = DB::table('equipment')
                    ->where('equipment_id',$equipment_id)
                    ->update([
                        'equipment_status_id' => 2,
                        'last_transfer' => $request->equipment_transfer_hd_date,
                        'equipment_location' => $request->customer_address,
                        'equipment_refdocuno' => $docs,
                    ]);
                }
            }
            EquipmentRequestDocu::where('equipment_request_docu_id',$request->equipment_request_docu_id)
            ->update([
                'equipment_request_status_id' => 6
            ]);
            DB::commit();
            return redirect()->route('equipment-transfer.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('equipment-transfer.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $hd = EquipmentTransferHd::find($id);
        return view('docu-equipment.print-equipmenttransfer',compact('hd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = EquipmentTransferHd::find($id);
        return view('docu-equipment.edit-equipmenttransfer',compact('hd'));
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
        $ck = EquipmentTransferHd::where('equipment_transfer_hd_id',$id)->first();
        if($ck->equipment_transfer_status_id == 1){
            $data = [           
                'recheck_at' => Auth::user()->name,
                'recheck_date'=> Carbon::now(),
                'recheck_remark'=> $request->recheck_remark,
                'equipment_transfer_status_id' => 2,
            ]; 
            if ($request->hasFile('recheck_file') && $request->file('recheck_file')->isValid()) {
                $filename = "ETS_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('recheck_file')->getClientOriginalExtension();
                $request->file('recheck_file')->storeAs('equipment_transfer_img', $filename, 'public');
                $data['recheck_file'] = 'storage/equipment_transfer_img/' . $filename;
            }
            try {
                DB::beginTransaction();
                EquipmentTransferHd::where('equipment_transfer_hd_id',$id)->update($data);
                foreach ($request->equipment_transfer_dt_id as $key => $value) {
                    $dt = DB::table('equipment_transfer_dts')->where('equipment_transfer_dt_id',$value)->first();
                    DB::table('equipment_transfer_dts')
                    ->where('equipment_transfer_dt_id',$value)
                    ->update([
                        'equipment_transfer_status_id' => 2,
                    ]);
                    DB::table('equipment')
                    ->where('equipment_id',$dt->equipment_id)
                    ->update([
                        'equipment_status_id' => 3,
                    ]);
                }
                DB::commit();
                return redirect()->route('equipment-transfer.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('equipment-transfer.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }   
        }
        elseif($ck->equipment_transfer_status_id == 2){
             $data = [           
                'receive_at' => Auth::user()->name,
                'receive_date'=> Carbon::now(),
                'receive_remark'=> $request->recheck_remark,
                'equipment_transfer_status_id' => 6,
            ]; 
            if ($request->hasFile('receive_file') && $request->file('receive_file')->isValid()) {
                $filename = "ETS_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('receive_file')->getClientOriginalExtension();
                $request->file('receive_file')->storeAs('equipment_transfer_img', $filename, 'public');
                $data['receive_file'] = 'storage/equipment_transfer_img/' . $filename;
            }
            try {
                DB::beginTransaction();
                EquipmentTransferHd::where('equipment_transfer_hd_id',$id)->update($data);
                foreach ($request->equipment_transfer_dt_id as $key => $value) {
                    $dt = DB::table('equipment_transfer_dts')->where('equipment_transfer_dt_id',$value)->first();
                    DB::table('equipment_transfer_dts')
                    ->where('equipment_transfer_dt_id',$value)
                    ->update([
                        'equipment_transfer_status_id' => 6,
                    ]);
                    DB::table('equipment')
                    ->where('equipment_id',$dt->equipment_id)
                    ->update([
                        'equipment_status_id' => 1,
                    ]);
                }
                DB::commit();
                return redirect()->route('equipment-transfer.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('equipment-transfer.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelEquipmentTransfer(Request $request)
    {
        $id = $request->refid;
        $hd = EquipmentTransferHd::find($id);
        try 
        {
            DB::beginTransaction();
            EquipmentTransferHd::where('equipment_transfer_hd_id',$id)->update([
                'equipment_transfer_status_id' => 3,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            $dt = DB::table('equipment_transfer_dts')->where('equipment_transfer_hd_id',$id)->get();
            foreach ($dt as $key => $value) {
                DB::table('equipment_transfer_dts')
                ->where('equipment_transfer_dt_id',$value->equipment_transfer_dt_id)
                ->update([
                    'equipment_transfer_status_id' => 3,
                    'person_at' => Auth::user()->name,
                    'updated_at'=> Carbon::now(),
                ]);
                DB::table('equipment')
                ->where('equipment_id',$value->equipment_id)
                ->update([
                    'equipment_status_id' => 1,
                ]);
            }
            EquipmentRequestDocu::where('equipment_request_docu_id',$hd->equipment_request_docu_id)
            ->update([
                'equipment_request_status_id' => 3
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
            return redirect()->route('equipment-request.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
