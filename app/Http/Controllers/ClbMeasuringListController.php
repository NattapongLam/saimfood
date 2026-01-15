<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ClbMeasuringList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ClbMeasuringListController extends Controller
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
        $hd = ClbMeasuringList::where('clb_measuring_lists_flag',true)->get();
        return view('measurings.list-measuringlist',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = ClbMeasuringList::latest('clb_measuring_lists_listno')
        ->where('clb_measuring_lists_flag',true)
        ->first();
        $listno = 1;
        if($hd){
            $listno = $hd->clb_measuring_lists_listno;
        }
        return view('measurings.create-measuringlist',compact('hd','listno'));
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
            'clb_measuring_lists_listno' => 'required',
            'clb_measuring_lists_code' => 'required',
            'clb_measuring_lists_name' => 'required',
        ]);
        $data = [
            'clb_measuring_lists_listno' => $request->clb_measuring_lists_listno,
            'clb_measuring_lists_code' => $request->clb_measuring_lists_code,
            'clb_measuring_lists_name' => $request->clb_measuring_lists_name,
            'clb_measuring_lists_brand' => $request->clb_measuring_lists_brand,
            'clb_measuring_lists_model' => $request->clb_measuring_lists_model,
            'clb_measuring_lists_serialno' => $request->clb_measuring_lists_serialno,
            'clb_measuring_lists_department' => $request->clb_measuring_lists_department,
            'actualuseperiod' => $request->actualuseperiod,
            'resolution' => $request->resolution,
            'acceptancecriteria' => $request->acceptancecriteria,
            'clb_measuring_lists_start' => $request->clb_measuring_lists_start,
            'clb_measuring_lists_note' => $request->clb_measuring_lists_note,
            'clb_measuring_lists_remark' => $request->clb_measuring_lists_remark,
            'clb_measuring_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        if ($request->hasFile('clb_measuring_lists_file1') && $request->file('clb_measuring_lists_file1')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('clb_measuring_lists_file1')->getClientOriginalExtension();
            $request->file('clb_measuring_lists_file1')->storeAs('measuringlist_img', $filename, 'public');
            $data['clb_measuring_lists_file1'] = 'storage/measuringlist_img/' . $filename;
        }
        if ($request->hasFile('clb_measuring_lists_file2') && $request->file('clb_measuring_lists_file2')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('clb_measuring_lists_file2')->getClientOriginalExtension();
            $request->file('clb_measuring_lists_file2')->storeAs('measuringlist_img', $filename, 'public');
            $data['clb_measuring_lists_file2'] = 'storage/measuringlist_img/' . $filename;
        }
        if ($request->hasFile('clb_measuring_lists_file3') && $request->file('clb_measuring_lists_file3')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('clb_measuring_lists_file3')->getClientOriginalExtension();
            $request->file('clb_measuring_lists_file3')->storeAs('measuringlist_img', $filename, 'public');
            $data['clb_measuring_lists_file3'] = 'storage/measuringlist_img/' . $filename;
        }
        if ($request->hasFile('clb_measuring_lists_file4') && $request->file('clb_measuring_lists_file4')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('clb_measuring_lists_file4')->getClientOriginalExtension();
            $request->file('clb_measuring_lists_file4')->storeAs('measuringlist_img', $filename, 'public');
            $data['clb_measuring_lists_file4'] = 'storage/measuringlist_img/' . $filename;
        }
        try 
        {
            DB::beginTransaction();
            ClbMeasuringList::create($data); 
            DB::commit();
            return redirect()->route('clb-measuringlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('clb-measuringlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = ClbMeasuringList::find($id);
        return view('measurings.edit-measuringlist',compact('hd'));
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
            'clb_measuring_lists_name' => 'required',
        ]);
        $data = [
            'clb_measuring_lists_name' => $request->clb_measuring_lists_name,
            'clb_measuring_lists_brand' => $request->clb_measuring_lists_brand,
            'clb_measuring_lists_model' => $request->clb_measuring_lists_model,
            'clb_measuring_lists_serialno' => $request->clb_measuring_lists_serialno,
            'clb_measuring_lists_department' => $request->clb_measuring_lists_department,
            'actualuseperiod' => $request->actualuseperiod,
            'resolution' => $request->resolution,
            'acceptancecriteria' => $request->acceptancecriteria,
            'clb_measuring_lists_start' => $request->clb_measuring_lists_start,
            'clb_measuring_lists_note' => $request->clb_measuring_lists_note,
            'clb_measuring_lists_remark' => $request->clb_measuring_lists_remark,
            'clb_measuring_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
        ];
        if ($request->hasFile('clb_measuring_lists_file1') && $request->file('clb_measuring_lists_file1')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('clb_measuring_lists_file1')->getClientOriginalExtension();
            $request->file('clb_measuring_lists_file1')->storeAs('measuringlist_img', $filename, 'public');
            $data['clb_measuring_lists_file1'] = 'storage/measuringlist_img/' . $filename;
        }
        if ($request->hasFile('clb_measuring_lists_file2') && $request->file('clb_measuring_lists_file2')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('clb_measuring_lists_file2')->getClientOriginalExtension();
            $request->file('clb_measuring_lists_file2')->storeAs('measuringlist_img', $filename, 'public');
            $data['clb_measuring_lists_file2'] = 'storage/measuringlist_img/' . $filename;
        }
        if ($request->hasFile('clb_measuring_lists_file3') && $request->file('clb_measuring_lists_file3')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('clb_measuring_lists_file3')->getClientOriginalExtension();
            $request->file('clb_measuring_lists_file3')->storeAs('measuringlist_img', $filename, 'public');
            $data['clb_measuring_lists_file3'] = 'storage/measuringlist_img/' . $filename;
        }
        if ($request->hasFile('clb_measuring_lists_file4') && $request->file('clb_measuring_lists_file4')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('clb_measuring_lists_file4')->getClientOriginalExtension();
            $request->file('clb_measuring_lists_file4')->storeAs('measuringlist_img', $filename, 'public');
            $data['clb_measuring_lists_file4'] = 'storage/measuringlist_img/' . $filename;
        }
        try 
        {
            DB::beginTransaction();
            ClbMeasuringList::where('clb_measuring_lists_id',$id)->update($data); 
            DB::commit();
            return redirect()->route('clb-measuringlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('clb-measuringlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelMeasuringlis(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ClbMeasuringList::where('clb_measuring_lists_id',$id)->update([
                'clb_measuring_lists_flag' => false,
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
