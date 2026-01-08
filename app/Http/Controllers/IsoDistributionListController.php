<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\IsoMasterList;
use Illuminate\Support\Facades\DB;
use App\Models\IsoDistributionList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IsoDistributionListController extends Controller
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
        $hd = IsoMasterList::where('iso_master_lists_flag',true)->get();
        return view('iso.list-distributionlist',compact('hd'));
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
        $request->validate([
            'ms_documenttype_name' => 'required',
            'iso_distribution_lists_date' => 'required',
            'iso_distribution_lists_empcode' => 'required',
        ]);
        $data = [
            'iso_master_lists_id' => $request->iso_master_lists_id,
            'iso_master_lists_docuno' => $request->iso_master_lists_docuno,
            'iso_master_lists_department' => $request->iso_master_lists_department,
            'iso_master_lists_name' => $request->iso_master_lists_name,
            'iso_master_lists_rev' => $request->iso_master_lists_rev,
            'ms_documenttype_name' => $request->ms_documenttype_name,
            'iso_distribution_lists_date' => $request->iso_distribution_lists_date,
            'iso_distribution_lists_empcode' => $request->iso_distribution_lists_empcode,
            'iso_distribution_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
            'iso_distribution_lists_status' => "N"
        ];
        try 
        {
            DB::beginTransaction();
            IsoDistributionList::create($data); 
            DB::commit();
            return redirect()->route('iso-distributionlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('iso-distributionlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $list = IsoDistributionList::where('iso_distribution_lists_flag',true)
        ->where('iso_distribution_lists_empcode',$id)
        ->get();
        return view('iso.view-distributionlist',compact('list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = IsoMasterList::find($id);
        $sta = DB::table('ms_documenttype')->get();
        $emp = DB::table('tg_employee_list')->get();
        $list = IsoDistributionList::where('iso_distribution_lists_flag',true)
        ->where('iso_master_lists_id',$id)
        ->get();
        return view('iso.create-distributionlist',compact('hd','sta','emp','list'));
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

    public function confirmDelDistributionlist(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            IsoDistributionList::where('iso_distribution_lists_id',$id)->update([
                'iso_distribution_lists_flag' => false,
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

    public function approvedDistributionlist(Request $request)
    {
         $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            IsoDistributionList::where('iso_distribution_lists_id',$id)->update([
                'iso_distribution_lists_status' => "Y",
                'iso_distribution_lists_person' => Auth::user()->name,
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
