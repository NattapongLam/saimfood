<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\IsoMasterList;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class IsoMasterListController extends Controller
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
        return view('iso.list-masterlist',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = IsoMasterList::latest('iso_master_lists_listno')
        ->where('iso_master_lists_flag',true)
        ->first();
        $listno = 1;
        if($hd){
            $listno = $hd->iso_master_lists_listno + 1;
        }
        return view('iso.create-masterlist',compact('hd','listno'));
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
            'iso_master_lists_docuno' => 'required',
            'iso_master_lists_department' => 'required',
            'iso_master_lists_name' => 'required',
            'iso_master_lists_rev' => 'required',
            'iso_master_lists_date' => 'required',
            'iso_master_lists_timeline' => 'required',
        ]);
        $data = [
            'iso_master_lists_listno' => $request->iso_master_lists_listno,
            'iso_master_lists_refdocu' => $request->iso_master_lists_refdocu,
            'iso_master_lists_docuno' => $request->iso_master_lists_docuno,
            'iso_master_lists_department' => $request->iso_master_lists_department,
            'iso_master_lists_name' => $request->iso_master_lists_name,
            'iso_master_lists_rev' => $request->iso_master_lists_rev,
            'iso_master_lists_date' => $request->iso_master_lists_date,
            'iso_master_lists_timeline' => $request->iso_master_lists_timeline,
            'iso_master_lists_remark' => $request->iso_master_lists_remark,
            'iso_master_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        if ($request->hasFile('iso_master_lists_file1') && $request->file('iso_master_lists_file1')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('iso_master_lists_file1')->getClientOriginalExtension();
            $request->file('iso_master_lists_file1')->storeAs('masterlist_img', $filename, 'public');
            $data['iso_master_lists_file1'] = 'storage/masterlist_img/' . $filename;
        }
        if ($request->hasFile('iso_master_lists_file2') && $request->file('iso_master_lists_file2')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('iso_master_lists_file2')->getClientOriginalExtension();
            $request->file('iso_master_lists_file2')->storeAs('masterlist_img', $filename, 'public');
            $data['iso_master_lists_file2'] = 'storage/masterlist_img/' . $filename;
        }
        try 
        {
            DB::beginTransaction();
            IsoMasterList::create($data); 
            DB::commit();
            return redirect()->route('iso-masterlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('iso-masterlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = IsoMasterList::find($id);
        return view('iso.edit-masterlist',compact('hd'));
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
            'iso_master_lists_department' => 'required',
            'iso_master_lists_name' => 'required',
            'iso_master_lists_rev' => 'required',
            'iso_master_lists_date' => 'required',
            'iso_master_lists_timeline' => 'required',
        ]);
        $data = [
            'iso_master_lists_refdocu' => $request->iso_master_lists_refdocu,
            'iso_master_lists_department' => $request->iso_master_lists_department,
            'iso_master_lists_name' => $request->iso_master_lists_name,
            'iso_master_lists_rev' => $request->iso_master_lists_rev,
            'iso_master_lists_date' => $request->iso_master_lists_date,
            'iso_master_lists_timeline' => $request->iso_master_lists_timeline,
            'iso_master_lists_remark' => $request->iso_master_lists_remark,
            'iso_master_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
        ];
         if ($request->hasFile('iso_master_lists_file1') && $request->file('iso_master_lists_file1')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('iso_master_lists_file1')->getClientOriginalExtension();
            $request->file('iso_master_lists_file1')->storeAs('masterlist_img', $filename, 'public');
            $data['iso_master_lists_file1'] = 'storage/masterlist_img/' . $filename;
        }
        if ($request->hasFile('iso_master_lists_file2') && $request->file('iso_master_lists_file2')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('iso_master_lists_file2')->getClientOriginalExtension();
            $request->file('iso_master_lists_file2')->storeAs('masterlist_img', $filename, 'public');
            $data['iso_master_lists_file2'] = 'storage/masterlist_img/' . $filename;
        }
        try 
        {
            DB::beginTransaction();
            IsoMasterList::where('iso_master_lists_id',$id)->update($data); 
            DB::commit();
            return redirect()->route('iso-masterlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('iso-masterlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelMasterlist(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            IsoMasterList::where('iso_master_lists_id',$id)->update([
                'iso_master_lists_flag' => false,
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
