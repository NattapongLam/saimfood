<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Machine;
use Illuminate\Http\Request;
use App\Models\MachinePlaningDt;
use App\Models\MachinePlaningHd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MachinePlaningController extends Controller
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
        $hd = MachinePlaningHd::leftjoin('machines','machine_planing_hds.machine_code','=','machines.machine_code')->get();
        return view('setup-machine.list-machineplaning',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $machine = Machine::where('machine_flag',true)->get();
        return view('setup-machine.create-machineplaning',compact('machine'));
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
            'machine_planing_dt_remark' => 'required',
            'machine_planing_dt_listno' => 'required',
        ]);
        $data = [
            'machine_code' => $request->machine_code,
            'machine_planing_hd_note' => $request->machine_planing_hd_note,
            'machine_planing_hd_flag' => true,           
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]; 
        try 
        {
            DB::beginTransaction();
            $hd = MachinePlaningHd::create($data);
            foreach ($request->machine_planing_dt_listno as $key => $value) {
                MachinePlaningDt::insert([
                    'machine_planing_hd_id' => $hd->machine_planing_hd_id,
                    'machine_planing_dt_listno' => $value,
                    'machine_planing_dt_remark' => $request->machine_planing_dt_remark[$key],
                    'machine_planing_dt_flag' => true,           
                    'person_at' => Auth::user()->name,
                    'created_at'=> Carbon::now(),
                    'updated_at'=> Carbon::now(),
                ]);
            }
            DB::commit();
            return redirect()->route('machine-planings.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-planings.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = MachinePlaningHd::find($id);
        $machine = Machine::where('machine_flag',true)->get();
        return view('setup-machine.edit-machineplaning',compact('hd','machine'));
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
            'machine_planing_dt_remark' => 'required',
            'machine_planing_dt_listno' => 'required',
        ]);
        $data = [
            'machine_code' => $request->machine_code,
            'machine_planing_hd_note' => $request->machine_planing_hd_note,
            'machine_planing_hd_flag' => true,           
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        try 
        {
            DB::beginTransaction();
            $hd = MachinePlaningHd::where('machine_planing_hd_id',$id)->update($data);
            foreach ($request->machine_planing_dt_listno as $key => $listno) {
                $remark = $request->machine_planing_dt_remark[$key];
                $dt_id = $request->machine_planing_dt_id[$key] ?? null;
                if ($dt_id && $dt = MachinePlaningDt::find($dt_id)) {
                    $dt->update([
                        'machine_planing_dt_listno' => $listno,
                        'machine_planing_dt_remark' => $remark,
                        'machine_planing_dt_flag' => true,
                        'person_at' => Auth::user()->name,
                        'updated_at' => Carbon::now(),
                    ]);
                } else {
                    MachinePlaningDt::create([
                        'machine_planing_hd_id' => $id,
                        'machine_planing_dt_listno' => $listno,
                        'machine_planing_dt_remark' => $remark,
                        'machine_planing_dt_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('machine-planings.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-planings.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
    public function confirmDelMachinePlaning(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            $target = MachinePlaningDt::findOrFail($id);
            $hd_id = $target->machine_planing_hd_id;
            $target->update([
                'machine_planing_dt_flag' => 0,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            $items = MachinePlaningDt::where('machine_planing_hd_id', $hd_id)
                        ->where('machine_planing_dt_flag', 1)
                        ->orderBy('machine_planing_dt_listno')
                        ->get();
            foreach ($items as $i => $item) {
                $item->update([
                    'machine_planing_dt_listno' => $i + 1,
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

    public function confirmDelMachinePlaningHd(Request $request)
    {
        $id = $request->refid;
        try 
        {
            MachinePlaningHd::where('machine_planing_hd_id',$id)
            ->update([
                'machine_planing_hd_flag' => 0,
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
}
