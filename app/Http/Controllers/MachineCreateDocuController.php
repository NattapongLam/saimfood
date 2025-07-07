<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\MachineRepairDochd;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MachineCreateDocuController extends Controller
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
        ->whereBetween('machine_repair_dochds.machine_repair_dochd_date', [$datestart, $dateend])
        ->where('machine_repair_dochds.docutype', 'C')
        ->select('machine_repair_dochds.*','machine_repair_statuses.machine_create_status_name')
        ->get();
        return view('docu-machine.list-machinecreate-docu',compact('hd','dateend','datestart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('docu-machine.create-machinecreate-docu');
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
            'machine_repair_dochd_duedate' => $request->machine_repair_dochd_duedate,
            'docutype' => "C",
        ]; 
        try 
        {
            DB::beginTransaction();
            MachineRepairDochd::create($data);
            DB::commit();
            return redirect()->route('machine-create-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-create-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        //
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
        //
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
