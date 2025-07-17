<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Machine;
use App\Models\MachineGroup;
use Illuminate\Http\Request;
use App\Models\MachinePlaningDt;
use App\Models\MachinePlaningHd;
use Illuminate\Support\Facades\DB;
use App\Models\MachinePlaningdocuDt;
use App\Models\MachinePlaningdocuHd;
use Illuminate\Support\Facades\Auth;
use App\Models\MachinePlaningdocuSub;

class MachinePlaningDocuController extends Controller
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
    public function index(Request $request)
    {
        $dateYear = $request->year ? $request->year : date("Y");
        $hd = MachinePlaningdocuHd::leftjoin('machine_planingdocu_dts','machine_planingdocu_hds.machine_planingdocu_hd_id','=','machine_planingdocu_dts.machine_planingdocu_hd_id')
        ->leftjoin('machines','machine_planingdocu_dts.machine_code','=','machines.machine_code')
        ->where('machine_planingdocu_hds.machine_planingdocu_hd_flag',true)
        ->where('machine_planingdocu_dts.machine_planingdocu_dt_flag',true)
        ->whereYear('machine_planingdocu_hds.machine_planingdocu_hd_date',$dateYear)
        ->get();
        return view('docu-machine.list-machineplaning-docu',compact('hd','dateYear'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $group = MachineGroup::where('machinegroup_flag',true)->get();
        return view('docu-machine.create-machineplaning-docu',compact('group'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'machine_code' => 'required',
            'machine_planingdocu_hd_date' => 'required',
            'machine_planingdocu_dt_date' => 'required',
        ]);
        $data = [
            'machine_planingdocu_hd_date' => $request->machine_planingdocu_hd_date,
            'machine_planingdocu_hd_note' => $request->machine_planingdocu_hd_note,
            'machine_planingdocu_hd_flag' => true,           
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]; 
        try 
        {
            DB::beginTransaction();
            $hd = MachinePlaningdocuHd::create($data);            
            foreach ($request->machine_code as $key => $value){
                MachinePlaningdocuDt::insert([
                    'machine_planingdocu_hd_id' => $hd->machine_planingdocu_hd_id,
                    'machine_code' => $value,
                    'machine_planingdocu_dt_date' => $request->machine_planingdocu_dt_date[$key],
                    'machine_planingdocu_dt_note' => $request->machine_planingdocu_dt_note[$key],
                    'machine_planingdocu_dt_flag' => true,           
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                    'machine_planingdocu_dt_plan' => true,
                    'machine_planingdocu_dt_action' => false
                ]);
            }
            DB::commit();
            return redirect()->route('machine-planing-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-planing-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $dt = MachinePlaningdocuDt::where('machine_planingdocu_dt_id',$id)->first();
        $mc = Machine::where('machine_flag',true)->get();
        $planhd = MachinePlaningHd::where('machine_code',$dt->machine_code)->where('machine_planing_hd_flag',true)->first();
        if($planhd == null){
            return redirect()->route('machine-planing-docus.index')->with('error', 'เครื่องจักรยังไม่ได้ตั้งค่าตรวจเช็คตามแผน');
        }
        $plandt = MachinePlaningDt::where('machine_planing_hd_id',$planhd->machine_planing_hd_id)->where('machine_planing_dt_flag',true)->get();
        return view('docu-machine.edit-machineplaning-docu',compact('dt','mc','plandt'));
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
        $request->validate([
            'machine_planing_dt_id' => 'required',
            'machine_planingdocu_dt_date' => 'required',
            'machine_code' => 'required',
        ]);      
        $data = [
            'machine_planingdocu_dt_date' => $request->machine_planingdocu_dt_date,
            'machine_code' => $request->machine_code,
            'machine_planingdocu_dt_note' => $request->machine_planingdocu_dt_note,
            'machine_planingdocu_dt_action' => true,           
            'action_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
        ];
        try 
        {
            DB::beginTransaction();
            $hd = MachinePlaningdocuDt::where('machine_planingdocu_dt_id',$id)->update($data);
            foreach ($request->machine_planing_dt_id as $key => $value) {
                $isChecked = isset($request->machine_planing_sub_action[$key]); 
                MachinePlaningdocuSub::insert([
                    'machine_planingdocu_dt_id' => $id,
                    'machine_planing_dt_id' => $value,
                    'machine_planing_dt_listno' => $request->machine_planing_dt_listno[$key],
                    'machine_planing_dt_remark' => $request->machine_planing_dt_remark[$key],
                    'machine_planing_sub_action' => $isChecked,
                    'machine_planing_sub_note' => $request->machine_planing_sub_note[$key],           
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }
            $up = Machine::where('machine_code',$request->machine_code)
            ->update([
                'last_planned' => $request->machine_planingdocu_dt_date
            ]);
            DB::commit();
            return redirect()->route('machine-planing-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-planing-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelMachinePlaningDocuDt(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            $target = MachinePlaningdocuDt::findOrFail($id);
            $target->update([
                'machine_planingdocu_dt_flag' => 0,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function getMachinesByGroup(Request $request)
    {
        $machines = Machine::where('machinegroup_id', $request->machinegroup_id)->get();
        return response()->json($machines);
    }

    public function CalendarPm(Request $request)
    {
        $hd = MachinePlaningdocuHd::leftjoin('machine_planingdocu_dts','machine_planingdocu_hds.machine_planingdocu_hd_id','=','machine_planingdocu_dts.machine_planingdocu_hd_id')
            ->leftjoin('machines','machine_planingdocu_dts.machine_code','=','machines.machine_code')
            ->where('machine_planingdocu_hds.machine_planingdocu_hd_flag', true)
            ->where('machine_planingdocu_dts.machine_planingdocu_dt_flag', true)
            ->get();

        $events = $hd->map(function($item) {
            // ตรวจสอบสถานะ plan / action
            $plan = $item->machine_planingdocu_dt_plan ?? false;
            $action = $item->machine_planingdocu_dt_action ?? false;

            // กำหนดสี
            $color = match (true) {
                $plan && $action => '#28a745', // เขียว
                $plan && !$action => '#ffc107', // เหลือง
                !$plan && $action => '#17a2b8', // ฟ้า
                default => '#dc3545' // แดง
            };

            return [
                'title' => $item->machine_code . '/' . $item->machine_name,
                'start' => $item->machine_planingdocu_dt_date,
                'description' => $item->machine_planingdocu_dt_note,
                'id' => $item->machine_planingdocu_dt_id,
                'color' => $color
            ];
        });

        return view('docu-machine.list-machineplaning-calendar')
            ->with('events', $events->toJson());
    }
}
