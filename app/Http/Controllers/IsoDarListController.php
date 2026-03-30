<?php

namespace App\Http\Controllers;

use App\Models\IsoDarList;
use App\Models\IsoDarSub;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IsoDarListController extends Controller
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
        $hd = IsoDarList::get();
        return view('iso.list-darlist',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('iso.create-darlist',compact('hd'));
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
            'iso_dar_lists_department' => 'required',
            'iso_dar_lists_objective' => 'required',
            'iso_dar_lists_docutype' => 'required',
            'iso_dar_subs_listno' => 'required',
        ]);
        $data = [
            'iso_dar_lists_department' => $request->iso_dar_lists_department,
            'iso_dar_lists_objective' => $request->iso_dar_lists_objective,
            'objective_remark' => $request->objective_remark,
            'iso_dar_lists_docutype' => $request->iso_dar_lists_docutype,
            'docutype_remark' => $request->docutype_remark,
            'iso_dar_lists_reason' => $request->iso_dar_lists_reason,
            'iso_dar_lists_person' => $request->iso_dar_lists_person,
            'iso_dar_lists_date' => $request->iso_dar_lists_date,
            'flag' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'approved_status' => "รอทบทวน"
        ];
        if ($request->hasFile('iso_dar_lists_file') && $request->file('iso_dar_lists_file')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('iso_dar_lists_file')->getClientOriginalExtension();
            $request->file('iso_dar_lists_file')->storeAs('dar_img', $filename, 'public');
            $data['iso_dar_lists_file'] = 'storage/dar_img/' . $filename;
        }
        try 
        {
            DB::beginTransaction();
            $hd = IsoDarList::create($data);
            foreach ($request->iso_dar_subs_listno as $key => $value) {
              IsoDarSub::insert([
                'iso_dar_lists_id' => $hd->iso_dar_lists_id,
                'iso_dar_subs_listno' => $value,
                'iso_dar_subs_code' => $request->iso_dar_subs_code[$key],
                'iso_dar_subs_rev1' => $request->iso_dar_subs_rev1[$key],
                'iso_dar_subs_rev2' => $request->iso_dar_subs_rev2[$key],
                'iso_dar_subs_name' => $request->iso_dar_subs_name[$key],
                'flag' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
              ]);
            }
            DB::commit();
            return redirect()->route('iso-darlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('iso-darlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = IsoDarList::find($id);
        $dt = IsoDarSub::where('flag',true)->get();
        return view('iso.edit-darlist',compact('hd','dt'));
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
        $hd = IsoDarList::find($id);
        if($hd->approved_status == "รอทบทวน"){
            try 
            {
                DB::beginTransaction();
                IsoDarList::where('iso_dar_lists_id',$id)->update([
                    'iso_dar_lists_reviewer' => $request->iso_dar_lists_reviewer,
                    'iso_dar_lists_reviewerdate' => $request->iso_dar_lists_reviewerdate,
                    'iso_dar_lists_reviewernote' => $request->iso_dar_lists_reviewernote,
                    'approved_status' => "ทบทวนแล้ว"
                ]);
                DB::commit();
                return redirect()->route('iso-darlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-darlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }     
        }elseif($hd->approved_status == "ทบทวนแล้ว"){
            try 
            {
                DB::beginTransaction();
                IsoDarList::where('iso_dar_lists_id',$id)->update([
                    'approved_by' => $request->approved_by,
                    'approved_date' => $request->approved_date,
                    'approved_remark' => $request->approved_remark,
                    'approved_status' => $request->approved_status
                ]);
                DB::commit();
                return redirect()->route('iso-darlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-darlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }     
        }elseif($hd->approved_status == "อนุมัติ" || $hd->approved_status == "ไม่อนุมัติ"){
            try 
            {
                DB::beginTransaction();
                IsoDarList::where('iso_dar_lists_id',$id)->update([
                    'dc_remark' => $request->dc_remark,
                    'dc_ref1' => $request->dc_ref1,
                    'dc_ref2' => $request->dc_ref2,
                    'effective_date1' => $request->effective_date1,
                    'effective_date2' => $request->effective_date2,
                    'start_date1' => $request->start_date1,
                    'start_date2' => $request->start_date2,
                    'dc_by' => Auth::user()->name,
                    'dc_date' => $request->dc_date,
                    'docutype' => $request->docutype
                ]);
                DB::commit();
                return redirect()->route('iso-darlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-darlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
}
