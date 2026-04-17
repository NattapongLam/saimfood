<?php

namespace App\Http\Controllers;

use App\Models\IsoNcrList;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IsoNcrListController extends Controller
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
        $hd = IsoNcrList::orderby('iso_ncr_lists_id','asc')->get();
        return view('iso.list-ncrlist',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $process = DB::table('ms_processtype')->get();
        return view('iso.create-ncrlist',compact('process'));
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
            'iso_ncr_lists_date' => 'required',
            'iso_ncr_lists_docuno' => 'required',
        ]);
        $data = [
            'iso_ncr_lists_date' => $request->iso_ncr_lists_date,
            'iso_ncr_lists_docuno' => $request->iso_ncr_lists_docuno,
            'iso_ncr_lists_to' => $request->iso_ncr_lists_to,
            'iso_ncr_lists_copy' => $request->iso_ncr_lists_copy,
            'iso_ncr_lists_person' => $request->iso_ncr_lists_person,
            'iso_ncr_lists_refdocu' => $request->iso_ncr_lists_refdocu,
            'ms_processtype_name' => $request->ms_processtype_name,
            'iso_ncr_lists_problem' => $request->iso_ncr_lists_problem,
            'iso_ncr_lists_flag' => true,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'status' => 1
        ];
        if ($request->hasFile('iso_ncr_lists_file1') && $request->file('iso_ncr_lists_file1')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('iso_ncr_lists_file1')->getClientOriginalExtension();
            $request->file('iso_ncr_lists_file1')->storeAs('ncr_img', $filename, 'public');
            $data['iso_ncr_lists_file1'] = 'storage/ncr_img/' . $filename;
        }
        if ($request->hasFile('iso_ncr_lists_file2') && $request->file('iso_ncr_lists_file2')->isValid()) {
            $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('iso_ncr_lists_file2')->getClientOriginalExtension();
            $request->file('iso_ncr_lists_file2')->storeAs('ncr_img', $filename, 'public');
            $data['iso_ncr_lists_file2'] = 'storage/ncr_img/' . $filename;
        }
        try 
        {
            DB::beginTransaction();
            $hd = IsoNcrList::create($data);
            DB::commit();
            return redirect()->route('iso-ncrlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('iso-ncrlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = IsoNcrList::find($id);
        return view('iso.edit-ncrlist',compact('hd'));
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
        $hd = IsoNcrList::find($id);
        if($hd->status == 1){
            try 
            {
                DB::beginTransaction();
                $hd = IsoNcrList::where('iso_ncr_lists_id',$id)
                ->update([
                    'material_check' => $request->has('material_check') ? 1 : 0,
                    'human_check' => $request->has('human_check') ? 1 : 0,
                    'machinery_check' => $request->has('machinery_check') ? 1 : 0,
                    'method_check' => $request->has('method_check') ? 1 : 0,
                    'environment_check' => $request->has('environment_check') ? 1 : 0,
                    'other_check' => $request->has('other_check') ? 1 : 0,
                    'cause_remark' => $request->cause_remark,
                    'cause_person' => $request->cause_person,
                    'cause_position' => $request->cause_position,
                    'cause_persondate' => $request->cause_persondate,
                    'status' => 2
                ]);
                DB::commit();
                return redirect()->route('iso-ncrlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-ncrlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }     
        }elseif($hd->status == 2){
            try 
            {
                DB::beginTransaction();
                $hd = IsoNcrList::where('iso_ncr_lists_id',$id)
                ->update([
                    'cause_approved' => $request->cause_approved,
                    'cause_approvedposition' => $request->cause_approvedposition,
                    'cause_approveddate' => $request->cause_approveddate,
                    'status' => 3
                ]);
                DB::commit();
                return redirect()->route('iso-ncrlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-ncrlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
