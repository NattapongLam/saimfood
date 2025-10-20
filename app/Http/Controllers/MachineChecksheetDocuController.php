<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MachineChecksheetHd;
use Illuminate\Support\Facades\Auth;
use App\Models\MachineChecksheetDocuDt;
use App\Models\MachineChecksheetDocuHd;
use App\Models\MachineChecksheetDocuEmp;

class MachineChecksheetDocuController extends Controller
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
        $dateMonth = $request->month ? $request->month : date("m");
        $hd = MachineChecksheetDocuHd::leftjoin('machines','machine_checksheet_docu_hds.machine_code','=','machines.machine_code')
        ->where('machine_checksheet_docu_hds.machine_checksheet_docu_hd_flag','=',true)
        ->whereYear('machine_checksheet_docu_hds.machine_checksheet_docu_hd_date', $dateYear)
        ->whereMonth('machine_checksheet_docu_hds.machine_checksheet_docu_hd_date', $dateMonth)
        ->select('machine_checksheet_docu_hds.*','machines.machine_name','machines.machine_pic1')
        ->get();
        return view('docu-machine.list-machinechecksheet-docu',compact('hd','dateYear','dateMonth'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mc = MachineChecksheetHd::leftjoin('machines','machine_checksheet_hds.machine_code','=','machines.machine_code')
        ->where('machine_checksheet_hd_flag',true)
        ->get();
        $emp = DB::table('tg_employee_list')->get();
        return view('docu-machine.create-machinechecksheet-docu',compact('mc','emp'));
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
            'machine_checksheet_docu_hd_date' => 'required',
            'machine_checksheet_dt_id' => 'required',
        ]);
        $data = [
            'machine_checksheet_docu_hd_date' => $request->machine_checksheet_docu_hd_date,
            'machine_code' => $request->machine_code,
            'machine_checksheet_docu_hd_note' => $request->machine_checksheet_docu_hd_note,
            'machine_checksheet_docu_hd_flag' => true,           
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]; 
        try 
        {
            DB::beginTransaction();
            $hd = MachineChecksheetDocuHd::create($data);
            foreach ($request->machine_checksheet_dt_id as $key => $value) {
                $data = [
                            'machine_checksheet_docu_hd_id' => $hd->machine_checksheet_docu_hd_id,
                            'machine_checksheet_dt_id' => $value,
                            'machine_checksheet_dt_listno' => $request->machine_checksheet_dt_listno[$key],
                            'machine_checksheet_dt_remark' => $request->machine_checksheet_dt_remark[$key],
                            'machine_checksheet_docu_dt_flag' => true,
                            'person_at' => Auth::user()->name,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ];
                        for ($i = 1; $i <= 31; $i++) {
                            $dayKey = 'check_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                            $data[$dayKey] = isset($request[$dayKey][$key]) ? true : false;
                        }

                MachineChecksheetDocuDt::insert($data);
            }
            // foreach ($request->emp_day as $key => $value) {
            //     $data = [
            //         'machine_checksheet_docu_hd_id' => $hd->machine_checksheet_docu_hd_id,
            //         'created_at' => Carbon::now(),
            //     ];
            //     for ($i = 1; $i <= 31; $i++) {
            //         $empKey  = 'emp_'  . str_pad($i, 2, '0', STR_PAD_LEFT);
            //         $dateKey = 'date_' . str_pad($i, 2, '0', STR_PAD_LEFT);
            //         $empVal = $request->emp_day[$i] ?? null;
            //         // เก็บรหัสพนักงาน
            //         $data[$empKey] = $empVal;
            //         // ถ้าไม่เป็น null ให้บันทึกวันที่ปัจจุบัน
            //         $data[$dateKey] = $empVal ? now() : null;
            //     }
            //     MachineChecksheetDocuEmp::create($data);
            // }
            DB::commit();
            return redirect()->route('machine-checksheet-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-checksheet-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = MachineChecksheetDocuHd::leftjoin('machines','machine_checksheet_docu_hds.machine_code','=','machines.machine_code')        
        ->findOrFail($id);
        $emp = DB::table('tg_employee_list')->get();
        if ($hd->employees()->count() == 0) {
            try {
                DB::beginTransaction();
                MachineChecksheetDocuEmp::create([
                    'machine_checksheet_docu_hd_id' => $hd->machine_checksheet_docu_hd_id,
                    'created_at' => Carbon::now(),
                ]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                dd($e->getMessage());
            }
        }
        return view('docu-machine.edit-machinechecksheet-docu',compact('hd','emp'));
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
            'machine_checksheet_docu_dt_id' => 'required',
        ]);
        $data = [
            'machine_checksheet_docu_hd_note' => $request->machine_checksheet_docu_hd_note,
            'machine_checksheet_docu_hd_flag' => true,           
            'person_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
        ]; 
        try 
        {
            DB::beginTransaction();
            $hd = MachineChecksheetDocuHd::where('machine_checksheet_docu_hd_id',$id)->update($data);
            foreach ($request->machine_checksheet_docu_dt_id as $index => $id) {
                $data = [];
                for ($i = 1; $i <= 31; $i++) {
                    $field = 'check_' . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $data[$field] = isset($request->$field[$index]) ? 1 : 0;
                }
                $data['updated_at'] = now();
                $data['person_at'] = Auth::user()->name;
                MachineChecksheetDocuDt::where('machine_checksheet_docu_dt_id', $id)->update($data);
            }
            $data1 = [
                'updated_at' => Carbon::now(),
            ];
            for ($i = 1; $i <= 31; $i++) {
                    $empKey  = 'emp_'  . str_pad($i, 2, '0', STR_PAD_LEFT);
                    $dateKey = 'date_' . str_pad($i, 2, '0', STR_PAD_LEFT);

                    $empVal = $request->emp_day[$i] ?? null;

                    // เก็บรหัสพนักงาน
                    $data1[$empKey] = $empVal;

                    // ถ้าไม่เป็น null ให้บันทึกวันที่ปัจจุบัน
                    $data1[$dateKey] = $empVal ? now() : null;
            }
                MachineChecksheetDocuEmp::where('machine_checksheet_docu_emp_id',$request->machine_checksheet_docu_emp_id)->update($data1);   
                
            DB::commit();
            return redirect()->route('machine-checksheet-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-checksheet-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelMachineChecksheetDocuHd(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            $target = MachineChecksheetDocuHd::findOrFail($id);
            $target->update([
                'machine_checksheet_docu_hd_flag' => 0,
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

    public function getCheckDetails($id)
    {
        $details = DB::table('machine_checksheet_dts')
                    ->where('machine_checksheet_hd_id', $id)
                    ->where('machine_checksheet_dt_flag',true)
                    ->select('machine_checksheet_dt_remark as detail','machine_checksheet_dt_id')                  
                    ->orderBy('machine_checksheet_dt_listno','asc')
                    ->get();
        return response()->json($details);
    }
}
