<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Machine;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MachineRepairDocdt;
use App\Models\MachineRepairDochd;
use Illuminate\Support\Facades\DB;
use App\Models\MachineRepairStatus;
use Illuminate\Support\Facades\Auth;

class MachineRepairDocuController extends Controller
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
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-2 month", strtotime($dateend)));
        $hd = MachineRepairDochd::leftjoin('machine_repair_statuses','machine_repair_dochds.machine_repair_status_id','=','machine_repair_statuses.machine_repair_status_id')
        ->leftjoin('machines','machine_repair_dochds.machine_code','=','machines.machine_code')
        ->whereBetween('machine_repair_dochds.machine_repair_dochd_date', [$datestart, $dateend])
        ->select('machine_repair_dochds.*','machines.machine_name','machines.machine_pic1','machine_repair_statuses.machine_repair_status_name')
        ->get();
        return view('docu-machine.list-machinerepair-docu',compact('hd','dateend','datestart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $machine = Machine::where('machine_flag',true)->get();
        return view('docu-machine.create-machinerepair-docu',compact('machine'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $docs_last = DB::table('machine_repair_dochds')
            ->where('machine_repair_dochd_docuno', 'like', '%' . date('ym') . '%')
            ->orderBy('machine_repair_dochd_id', 'desc')->first();
        if ($docs_last) {
            $docs = 'MTN' . date('ym')  . str_pad($docs_last->machine_repair_dochd_docunum + 1, 4, '0', STR_PAD_LEFT);
            $docs_number = $docs_last->machine_repair_dochd_docunum + 1;
        } else {
            $docs = 'MTN' . date('ym')  . str_pad(1, 4, '0', STR_PAD_LEFT);
            $docs_number = 1;
        }
        $request->validate([
            'machine_repair_dochd_date' => 'required',
            'machine_repair_dochd_type' => 'required',
            'machine_code' => 'required',
            'machine_repair_dochd_location' => 'required',
            'machine_repair_dochd_case' => 'required',
            'machine_repair_dochd_duedate' => 'required',
        ]);
        $data = [
            'machine_repair_dochd_date' => $request->machine_repair_dochd_date,
            'machine_code' => $request->machine_code,
            'machine_repair_dochd_type' => $request->machine_repair_dochd_type,
            'machine_repair_dochd_case' => $request->machine_repair_dochd_case,           
            'machine_repair_dochd_location' => $request->machine_repair_dochd_location,
            'machine_repair_status_id' => 1,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
            'machine_repair_dochd_datetime' => Carbon::now(),
            'machine_repair_dochd_docuno' => $docs,
            'machine_repair_dochd_docunum' => $docs_number,
            'machine_repair_dochd_duedate' => $request->machine_repair_dochd_duedate
        ]; 
        try 
        {
            DB::beginTransaction();
            MachineRepairDochd::create($data);
            DB::commit();
            return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = MachineRepairDochd::leftjoin('machine_repair_statuses','machine_repair_dochds.machine_repair_status_id','=','machine_repair_statuses.machine_repair_status_id')
        ->find($id);      
        $machine = Machine::where('machine_flag',true)->get();
        $status = MachineRepairStatus::whereIn('machine_repair_status_id',[3,8,9])->get();
        return view('docu-machine.edit-machinerepair-docu',compact('hd','machine','status'));
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
        $ck = MachineRepairDochd::where('machine_repair_dochd_id',$id)->first();
        if($ck->machine_repair_status_id == 1 || $ck->machine_repair_status_id == 9){
            $request->validate([
                'accepting_note' => 'required',
            ]);            
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'machine_repair_dochd_type' => $request->machine_repair_dochd_type,
                    'machine_repair_dochd_case' => $request->machine_repair_dochd_case,
                    'machine_repair_dochd_location' => $request->machine_repair_dochd_location,
                    'machine_repair_dochd_duedate' => $request->machine_repair_dochd_duedate,
                    'machine_repair_status_id' => 2,
                    'accepting_at' => Auth::user()->name,
                    'accepting_date' =>  Carbon::now(),
                    'accepting_note' => $request->accepting_note,
                    'accepting_duedate' => $request->accepting_duedate,
                ]);
                $listnos = $request->machine_repair_docdt_listno ?? [];
                $ids = $request->machine_repair_docdt_id ?? [];
                foreach ($listnos as $key => $listno) {
                    $docdtId = $ids[$key] ?? null;
                    $cost = str_replace(',', '', $request->machine_repair_docdt_cost[$key]);
                    $flag = $request->machine_repair_docdt_flag[$key] ?? false;
                    $flag = $flag == 'on' || $flag == 'true' ? true : false;
                    if ($docdtId) {
                        MachineRepairDocdt::where('machine_repair_docdt_id', $docdtId)
                            ->update([
                                'machine_repair_docdt_listno' => $listno,
                                'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                                'machine_repair_docdt_cost' => $cost,
                                'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                                'machine_repair_docdt_flag' => $flag,
                                'person_at' => Auth::user()->name,
                                'updated_at' => Carbon::now(),
                                'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                            ]);
                    } else {
                        MachineRepairDocdt::create([
                            'machine_repair_dochd_id' => $ck->machine_repair_dochd_id,
                            'machine_repair_docdt_listno' => $listno,
                            'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                            'machine_repair_docdt_cost' => $cost,
                            'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                            'machine_repair_docdt_flag' => true,
                            'person_at' => Auth::user()->name,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                        ]);
                    }
                }
                DB::commit();
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }  
        }else if($ck->machine_repair_status_id == 2){
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'machine_repair_status_id' => $request->machine_repair_status_id,
                    'approval_at' => Auth::user()->name,
                    'approval_date' =>  Carbon::now(),
                    'approval_note' => $request->approval_note
                ]);
                DB::commit();
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }  
        }else if($ck->machine_repair_status_id == 3){
            $request->validate([
                'accepting_note' => 'required',
                'repairer_datetime' => 'required',
            ]);
            $datetime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->repairer_datetime);
            $data = [
                'machine_repair_status_id' => 4,
                'repairer_at' => Auth::user()->name,
                'repairer_date' =>  $datetime->format('Y-m-d'),
                'repairer_note' => $request->repairer_note,
                'repairer_datetime' => $datetime,
                'repairer_type' => $request->repairer_type,
                'repairer_problem' => $request->repairer_problem,
            ];
            if ($request->hasFile('repairer_pic1') && $request->file('repairer_pic1')->isValid()) {
                $filename = "MTN_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('repairer_pic1')->getClientOriginalExtension();
                $request->file('repairer_pic1')->storeAs('machine_repair_img', $filename, 'public');
                $data['repairer_pic1'] = 'storage/machine_repair_img/' . $filename;
            }
            if ($request->hasFile('repairer_pic2') && $request->file('repairer_pic2')->isValid()) {
                $filename = "MTN_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('repairer_pic2')->getClientOriginalExtension();
                $request->file('repairer_pic2')->storeAs('machine_repair_img', $filename, 'public');
                $data['repairer_pic2'] = 'storage/machine_repair_img/' . $filename;
            }  
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)->update($data);
                $mc = Machine::where('machine_code',$ck->machine_code)->update([
                    'last_repair' => $datetime->format('Y-m-d'),
                ]);
                $listnos = $request->machine_repair_docdt_listno ?? [];
              
                foreach ($listnos as $key => $listno) {
                    $cost = str_replace(',', '', $request->machine_repair_docdt_cost[$key]);
                    MachineRepairDocdt::create([
                        'machine_repair_dochd_id' => $ck->machine_repair_dochd_id,
                        'machine_repair_docdt_listno' => $listno,
                        'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                        'machine_repair_docdt_cost' => $cost,
                        'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                        'machine_repair_docdt_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                        'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                    ]);
                }
                DB::commit();
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }   
        }else if($ck->machine_repair_status_id == 4){
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'machine_repair_status_id' => 5,
                    'inspector_at' => Auth::user()->name,
                    'inspector_date' =>  Carbon::now(),
                    'inspector_note' => $request->inspector_note
                ]);
                DB::commit();
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            } 
        }else if($ck->machine_repair_status_id == 5){ 
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'machine_repair_status_id' => 6,
                    'closing_at' => Auth::user()->name,
                    'closing_date' =>  Carbon::now(),
                    'closing_note' => $request->closing_note
                ]);
                DB::commit();
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelMachineRepairHd(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            MachineRepairDochd::where('machine_repair_dochd_id',$id)->update([
                'machine_repair_status_id' => 7,
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
    public function confirmDelMachineRepairDt(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            MachineRepairDocdt::where('machine_repair_docdt_id',$id)->update([
                'machine_repair_docdt_flag' => false,
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
