<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MachineIssuestockDt;
use App\Models\MachineIssuestockHd;
use Illuminate\Support\Facades\Auth;

class MachineIssueStockController extends Controller
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
        $hd = MachineIssuestockHd::leftjoin('machine_issuestock_statuses','machine_issuestock_hds.machine_issuestock_statuses_id','=','machine_issuestock_statuses.machine_issuestock_statuses_id')
        ->whereBetween('machine_issuestock_hds.machine_issuestock_hd_date', [$datestart, $dateend])
        ->get();
        return view('docu-machine.list-machinecissuestock',compact('hd','dateend','datestart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('docu-machine.create-machinecissuestock',compact('hd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $docs_last = DB::table('machine_issuestock_hds')
            ->where('machine_issuestock_hd_docuno', 'like', '%' . date('ym') . '%')
            ->orderBy('machine_issuestock_hd_id', 'desc')->first();
        if ($docs_last) {
            $docs = 'GR' . date('ym')  . str_pad($docs_last->machine_issuestock_hd_docunum + 1, 4, '0', STR_PAD_LEFT);
            $docs_number = $docs_last->machine_issuestock_hd_docunum + 1;
        } else {
            $docs = 'GR' . date('ym')  . str_pad(1, 4, '0', STR_PAD_LEFT);
            $docs_number = 1;
        }
        $request->validate([
            'machine_issuestock_hd_date' => 'required',
            'machine_issuestock_hd_vendor' => 'required',
            'machine_issuestock_dt_listno' => 'required',
        ]);
        $data =[
                'machine_issuestock_statuses_id' => 1,
                'machine_issuestock_hd_date' => $request->machine_issuestock_hd_date,
                'machine_issuestock_hd_docuno' => $docs,             
                'machine_issuestock_hd_docunum' => $docs_number,
                'machine_issuestock_hd_vendor' => $request->machine_issuestock_hd_vendor,
                'machine_issuestock_hd_contact' => $request->machine_issuestock_hd_contact,
                'machine_issuestock_hd_tel' => $request->machine_issuestock_hd_tel,
                'machine_issuestock_hd_note' => $request->machine_issuestock_hd_note,
                'person_at' => Auth::user()->name,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('machine_issuestock_hd_file1') && $request->file('machine_issuestock_hd_file1')->isValid()) {
            $filename = "GR_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_issuestock_hd_file1')->getClientOriginalExtension();
            $request->file('machine_issuestock_hd_file1')->storeAs('machine_issuestock_img', $filename, 'public');
            $data['machine_issuestock_hd_file1'] = 'storage/machine_issuestock_img/' . $filename;
        }
        if ($request->hasFile('machine_issuestock_hd_file2') && $request->file('machine_issuestock_hd_file2')->isValid()) {
            $filename = "GR_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_issuestock_hd_file2')->getClientOriginalExtension();
            $request->file('machine_issuestock_hd_file2')->storeAs('machine_issuestock_img', $filename, 'public');
            $data['machine_issuestock_hd_file2'] = 'storage/machine_issuestock_img/' . $filename;
        }
        try {
            DB::beginTransaction();
            $hd = MachineIssuestockHd::create($data);
            foreach ($request->machine_issuestock_dt_listno as $key => $value) {
                MachineIssuestockDt::create([
                    'machine_issuestock_hd_id' => $hd->machine_issuestock_hd_id,
                    'machine_issuestock_dt_listno' => $value,
                    'machine_issuestock_dt_code' => $request->machine_issuestock_dt_code[$key],
                    'machine_issuestock_dt_name' => $request->machine_issuestock_dt_name[$key],
                    'machine_issuestock_dt_qty' => $request->machine_issuestock_dt_qty[$key],
                    'machine_issuestock_dt_note' => $request->machine_issuestock_dt_note[$key],
                    'machine_issuestock_dt_flag' => 1,
                    'person_at' => Auth::user()->name,
                    'poststock' => "N",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'machine_issuestock_dt_price' => $request->machine_issuestock_dt_price[$key],
                    'machine_issuestock_dt_total' => $request->machine_issuestock_dt_qty[$key] * $request->machine_issuestock_dt_price[$key],
                    'machine_issuestock_dt_unit' => $request->machine_issuestock_dt_unit[$key],
                ]);
            }
            DB::commit();
            return redirect()->route('machine-issue-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
           return redirect()->route('machine-issue-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = MachineIssuestockHd::find($id);
        $dt = MachineIssuestockDt::where('machine_issuestock_hd_id',$id)->where('machine_issuestock_dt_flag',true)->get();
        return view('docu-machine.approved-machinecissuestock',compact('hd','dt'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = MachineIssuestockHd::find($id);
        $dt = MachineIssuestockDt::where('machine_issuestock_hd_id',$id)->where('machine_issuestock_dt_flag',true)->get();
        return view('docu-machine.edit-machinecissuestock',compact('hd','dt'));
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
        if($request->reftype == "Edit")
        {
             $request->validate([
            'machine_issuestock_hd_date' => 'required',
            'machine_issuestock_hd_vendor' => 'required',
        ]);
        $data =[
                'machine_issuestock_statuses_id' => 1,
                'machine_issuestock_hd_date' => $request->machine_issuestock_hd_date,
                'machine_issuestock_hd_vendor' => $request->machine_issuestock_hd_vendor,
                'machine_issuestock_hd_contact' => $request->machine_issuestock_hd_contact,
                'machine_issuestock_hd_tel' => $request->machine_issuestock_hd_tel,
                'machine_issuestock_hd_note' => $request->machine_issuestock_hd_note,
                'person_at' => Auth::user()->name,
                'updated_at' => Carbon::now(),
        ];
        if ($request->hasFile('machine_issuestock_hd_file1') && $request->file('machine_issuestock_hd_file1')->isValid()) {
            $filename = "GR_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_issuestock_hd_file1')->getClientOriginalExtension();
            $request->file('machine_issuestock_hd_file1')->storeAs('machine_issuestock_img', $filename, 'public');
            $data['machine_issuestock_hd_file1'] = 'storage/machine_issuestock_img/' . $filename;
        }
        if ($request->hasFile('machine_issuestock_hd_file2') && $request->file('machine_issuestock_hd_file2')->isValid()) {
            $filename = "GR_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_issuestock_hd_file2')->getClientOriginalExtension();
            $request->file('machine_issuestock_hd_file2')->storeAs('machine_issuestock_img', $filename, 'public');
            $data['machine_issuestock_hd_file2'] = 'storage/machine_issuestock_img/' . $filename;
        }
        try {
            DB::beginTransaction();
            $hd = MachineIssuestockHd::where('machine_issuestock_hd_id',$id)->update($data);
            foreach ($request->machine_issuestock_dt_listno as $key => $value) {
                MachineIssuestockDt::create([
                    'machine_issuestock_hd_id' => $hd->machine_issuestock_hd_id,
                    'machine_issuestock_dt_listno' => $value,
                    'machine_issuestock_dt_code' => $request->machine_issuestock_dt_code[$key],
                    'machine_issuestock_dt_name' => $request->machine_issuestock_dt_name[$key],
                    'machine_issuestock_dt_qty' => $request->machine_issuestock_dt_qty[$key],
                    'machine_issuestock_dt_note' => $request->machine_issuestock_dt_note[$key],
                    'machine_issuestock_dt_flag' => 1,
                    'person_at' => Auth::user()->name,
                    'poststock' => "N",
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'machine_issuestock_dt_price' => $request->machine_issuestock_dt_price[$key],
                    'machine_issuestock_dt_total' => $request->machine_issuestock_dt_qty[$key] * $request->machine_issuestock_dt_price[$key],
                    'machine_issuestock_dt_unit' => $request->machine_issuestock_dt_unit[$key],
                ]);
            }
            DB::commit();
            return redirect()->route('machine-issue-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
           return redirect()->route('machine-issue-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
        }  
        }elseif ($request->reftype == "Update") {
            $data =[
                'machine_issuestock_statuses_id' => 3,
                'approved_at' => Auth::user()->name,
                'approved_date' => Carbon::now(),
                'approved_remark' => $request->approved_remark,
            ];
             try {
            DB::beginTransaction();
            MachineIssuestockHd::where('machine_issuestock_hd_id',$id)->update($data);
            $dt = MachineIssuestockDt::where('machine_issuestock_hd_id',$id)->where('machine_issuestock_dt_flag',true)->get();
            $hd = MachineIssuestockHd::find($id);
            foreach ($dt as $key => $value) {

                DB::table('stc_stockcard')->insert([
                    'stc_stockcard_date' => $hd->machine_issuestock_hd_date,
                    'stc_stockcard_docuno' => $hd->machine_issuestock_hd_docuno,
                    'stc_stockcard_productcode' => $value->machine_issuestock_dt_code,
                    'stc_stockcard_productname' => $value->machine_issuestock_dt_name,
                    'stc_stockcard_productunit' => $value->machine_issuestock_dt_unit,
                    'stc_stockcard_productqty' => $value->machine_issuestock_dt_qty,
                    'stockflag' => 1,
                    'person_at' => Auth::user()->name,
                    'update_at' => Carbon::now(),
                    'stc_stockcard_productprice' => $value->machine_issuestock_dt_price,
                ]);
                DB::table('machine_issuestock_dts')
                ->where('machine_issuestock_dt_id',$value->machine_issuestock_dt_id)
                ->update([
                    'poststock' => "Y"
                ]);
            }
            DB::commit();
            return redirect()->route('machine-issue-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
            return redirect()->route('machine-issue-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelMachineIssueStock(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            MachineIssuestockHd::where('machine_issuestock_hd_id',$id)->update([
                'machine_issuestock_statuses_id' => 2,
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

    public function confirmDelMachineIssueStockDt(Request $request)
    {
         $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            MachineIssuestockDt::where('machine_issuestock_dt_id',$id)->update([
                'machine_issuestock_dt_flag' => 0,
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

    public function stockcardlist(Request $request)
    {

        // Query สต็อคอะไหล่
        $query = DB::table('vw_stc_stockcard');

        $stockcards = $query->orderBy('stc_stockcard_productcode')->get();

        return view('docu-machine.stock-machinecissuestock', compact('stockcards'));
    }

}
