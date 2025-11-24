<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Machine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MachineChecksheetDt;
use App\Models\MachineChecksheetHd;
use Illuminate\Support\Facades\Auth;

class MachineChecksheetController extends Controller
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
        $hd = MachineChecksheetHd::leftjoin('machines','machine_checksheet_hds.machine_code','=','machines.machine_code')->get();       
        return view('setup-machine.list-machinechecksheet',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $machine = Machine::where('machine_flag',true)->get();
        $emp = DB::table('tg_employee_list')->get();
        return view('setup-machine.create-machinechecksheet',compact('machine','emp'));
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
            'machine_checksheet_dt_listno' => 'required',
            'machine_checksheet_dt_remark' => 'required',
        ]);
         $data = [
            'machine_code' => $request->machine_code,
            'machine_checksheet_hd_note' => $request->machine_checksheet_hd_note,
            'machine_checksheet_hd_flag' => true,           
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
            'review_at1' => $request->review_at1,
            'review_at2' => $request->review_at2
        ]; 
        try 
        {
            DB::beginTransaction();
            $hd = MachineChecksheetHd::create($data);
            foreach ($request->machine_checksheet_dt_listno as $key => $value) {
                MachineChecksheetDt::insert([
                    'machine_checksheet_hd_id' => $hd->machine_checksheet_hd_id,
                    'machine_checksheet_dt_listno' => $value,
                    'machine_checksheet_dt_remark' => $request->machine_checksheet_dt_remark[$key],
                    'machine_checksheet_dt_flag' => true,           
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }
            DB::commit();
            return redirect()->route('machine-checksheets.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-checksheets.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = MachineChecksheetHd::find($id);
        $machine = Machine::where('machine_flag',true)->get();
        $emp = DB::table('tg_employee_list')->get();
        return view('setup-machine.edit-machinechecksheet',compact('hd','machine','emp'));
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
            'machine_code' => 'required',
            'machine_checksheet_dt_listno' => 'required',
            'machine_checksheet_dt_remark' => 'required',
        ]);
        $data = [
            'machine_code' => $request->machine_code,
            'machine_checksheet_hd_note' => $request->machine_checksheet_hd_note,
            'machine_checksheet_hd_flag' => true,           
            'person_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
            'review_at1' => $request->review_at1,
            'review_at2' => $request->review_at2
        ];
        try 
        {
            DB::beginTransaction();
            $hd = MachineChecksheetHd::where('machine_checksheet_hd_id',$id)->update($data);
            foreach ($request->machine_checksheet_dt_listno as $key => $listno) {
                $remark = $request->machine_checksheet_dt_remark[$key];
                $dt_id = $request->machine_checksheet_dt_id[$key] ?? null;
                if ($dt_id && $dt = MachineChecksheetDt::find($dt_id)) {
                    $dt->update([
                        'machine_checksheet_dt_listno' => $listno,
                        'machine_checksheet_dt_remark' => $remark,
                        'machine_checksheet_dt_flag' => true,
                        'person_at' => Auth::user()->name,
                        'updated_at' => Carbon::now(),
                    ]);
                } else {
                    MachineChecksheetDt::create([
                        'machine_checksheet_hd_id' => $id,
                        'machine_checksheet_dt_listno' => $listno,
                        'machine_checksheet_dt_remark' => $remark,
                        'machine_checksheet_dt_flag' => true,           
                        'person_at' => Auth::user()->name,
                        'created_at'=> Carbon::now(),
                        'updated_at'=> Carbon::now(),
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('machine-checksheets.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-checksheets.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelMachineChecksheetHd(Request $request)
    {
        $id = $request->refid;
        try 
        {
            MachineChecksheetHd::where('machine_checksheet_hd_id',$id)
            ->update([
                'machine_checksheet_hd_flag' => 0,
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

    public function confirmDelMachineChecksheet(Request $request)
    {
         $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            $target = MachineChecksheetDt::findOrFail($id);
            $hd_id = $target->machine_checksheet_hd_id;
            $target->update([
                'machine_checksheet_dt_flag' => 0,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            $items = MachineChecksheetDt::where('machine_checksheet_hd_id', $hd_id)
                        ->where('machine_checksheet_dt_flag', 1)
                        ->orderBy('machine_checksheet_dt_listno')
                        ->get();
            foreach ($items as $i => $item) {
                $item->update([
                    'machine_checksheet_dt_listno' => $i + 1,
                    'updated_at' => Carbon::now(),
                ]);
            }
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
}
