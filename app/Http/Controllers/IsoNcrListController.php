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
        $hd = IsoNcrList::find($id);
        $process = DB::table('ms_processtype')->get();
        return view('iso.update-ncrlist',compact('hd','process'));
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
        if($request->checktype == "update")
        {
            $data = [
                'iso_ncr_lists_date' => $request->iso_ncr_lists_date,
                'iso_ncr_lists_docuno' => $request->iso_ncr_lists_docuno,
                'iso_ncr_lists_to' => $request->iso_ncr_lists_to,
                'iso_ncr_lists_copy' => $request->iso_ncr_lists_copy,
                'iso_ncr_lists_person' => $request->iso_ncr_lists_person,
                'iso_ncr_lists_refdocu' => $request->iso_ncr_lists_refdocu,
                'ms_processtype_name' => $request->ms_processtype_name,
                'iso_ncr_lists_problem' => $request->iso_ncr_lists_problem,
                'person_at' =>  Auth::user()->name,
                'updated_at' => Carbon::now(),
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
                'cause_approved' => $request->cause_approved,
                'cause_approvedposition' => $request->cause_approvedposition,
                'cause_approveddate' => $request->cause_approveddate,
                'rework_check' => $request->has('rework_check') ? 1 : 0,
                'rework_qty' => $request->rework_qty,
                'rework_correct' => $request->rework_correct,
                'reprocess_check' => $request->has('reprocess_check') ? 1 : 0,
                'reprocess_qty' => $request->reprocess_qty,
                'reprocess_correct' => $request->reprocess_correct,
                'acceptance_check' => $request->has('acceptance_check') ? 1 : 0,
                'acceptance_qty' => $request->acceptance_qty,
                'acceptance_correct' => $request->acceptance_correct,
                'reject_check' => $request->has('reject_check') ? 1 : 0,
                'reject_qty' => $request->reject_qty,
                'scrap_check' => $request->has('scrap_check') ? 1 : 0,
                'scrap_qty' => $request->scrap_qty,
                'return_check' => $request->has('return_check') ? 1 : 0,
                'return_qty' => $request->return_qty,
                'change_check' => $request->has('change_check') ? 1 : 0,
                'change_qty' => $request->change_qty,
                'corrective_person' => $request->corrective_person,
                'corrective_position' => $request->corrective_position,
                'corrective_date' => $request->corrective_date,
                'corrective_duedate' => $request->corrective_duedate,
                'corrective_approved' => $request->corrective_approved,
                'corrective_approvedposition' => $request->corrective_approvedposition,
                'corrective_approveddate' => $request->corrective_approveddate,
                'following_note' => $request->following_note,
                'following_person' => $request->following_person,
                'following_date' => $request->following_date,
                'following_productname' => $request->following_productname,
                'following_productcode' => $request->following_productcode,
                'following_productlot' => $request->following_productlot,
                'following_productqty' => $request->following_productqty,
                'following_productnote' => $request->following_productnote,
                'accept_proposed1' => $request->has('accept_proposed1') ? 1 : 0,
                'accept_proposed2' => $request->has('accept_proposed2') ? 1 : 0,
                'accept_proposed3' => $request->has('accept_proposed3') ? 1 : 0,
                'proposed_person' => $request->proposed_person,
                'proposed_approved' => $request->proposed_approved,
                'accept_proposed2_note' => $request->accept_proposed2_note,
                'accept_proposed3_note' => $request->accept_proposed3_note,
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
            if ($request->hasFile('following_file') && $request->file('following_file')->isValid()) {
                $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('following_file')->getClientOriginalExtension();
                $request->file('following_file')->storeAs('ncr_img', $filename, 'public');
                $data['following_file'] = 'storage/ncr_img/' . $filename;
            }
            try 
            {
                DB::beginTransaction();
                $hd = IsoNcrList::where('iso_ncr_lists_id',$id)->update($data);
                DB::commit();
                return redirect()->route('iso-ncrlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-ncrlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }     
        }
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
        }elseif($hd->status == 3){
            try 
            {
                DB::beginTransaction();
                $hd = IsoNcrList::where('iso_ncr_lists_id',$id)
                ->update([
                    'rework_check' => $request->has('rework_check') ? 1 : 0,
                    'rework_qty' => $request->rework_qty,
                    'rework_correct' => $request->rework_correct,
                    'reprocess_check' => $request->has('reprocess_check') ? 1 : 0,
                    'reprocess_qty' => $request->reprocess_qty,
                    'reprocess_correct' => $request->reprocess_correct,
                    'acceptance_check' => $request->has('acceptance_check') ? 1 : 0,
                    'acceptance_qty' => $request->acceptance_qty,
                    'acceptance_correct' => $request->acceptance_correct,
                    'reject_check' => $request->has('reject_check') ? 1 : 0,
                    'reject_qty' => $request->reject_qty,
                    'scrap_check' => $request->has('scrap_check') ? 1 : 0,
                    'scrap_qty' => $request->scrap_qty,
                    'return_check' => $request->has('return_check') ? 1 : 0,
                    'return_qty' => $request->return_qty,
                    'change_check' => $request->has('change_check') ? 1 : 0,
                    'change_qty' => $request->change_qty,
                    'corrective_person' => $request->corrective_person,
                    'corrective_position' => $request->corrective_position,
                    'corrective_date' => $request->corrective_date,
                    'corrective_duedate' => $request->corrective_duedate,
                    'corrective_approved' => $request->corrective_approved,
                    'corrective_approvedposition' => $request->corrective_approvedposition,
                    'corrective_approveddate' => $request->corrective_approveddate,
                    'status' => 4
                ]);
                DB::commit();
                return redirect()->route('iso-ncrlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-ncrlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }     
        }elseif($hd->status == 4){
            try 
            {
                $data = [
                    'following_note' => $request->following_note,
                    'following_person' => $request->following_person,
                    'following_date' => $request->following_date,
                    'following_productname' => $request->following_productname,
                    'following_productcode' => $request->following_productcode,
                    'following_productlot' => $request->following_productlot,
                    'following_productqty' => $request->following_productqty,
                    'following_productnote' => $request->following_productnote,
                    'status' => 5
                ];
                if ($request->hasFile('following_file') && $request->file('following_file')->isValid()) {
                    $filename = "ISO_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('following_file')->getClientOriginalExtension();
                    $request->file('following_file')->storeAs('ncr_img', $filename, 'public');
                    $data['following_file'] = 'storage/ncr_img/' . $filename;
                }
                DB::beginTransaction();
                $hd = IsoNcrList::where('iso_ncr_lists_id',$id)->update($data);
                DB::commit();
                return redirect()->route('iso-ncrlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-ncrlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }     
        }elseif($hd->status == 5){
            try 
            {
                DB::beginTransaction();
                $hd = IsoNcrList::where('iso_ncr_lists_id',$id)
                ->update([
                    'accept_proposed1' => $request->has('accept_proposed1') ? 1 : 0,
                    'accept_proposed2' => $request->has('accept_proposed2') ? 1 : 0,
                    'accept_proposed3' => $request->has('accept_proposed3') ? 1 : 0,
                    'proposed_person' => $request->proposed_person,
                    'proposed_approved' => $request->proposed_approved,
                    'accept_proposed2_note' => $request->accept_proposed2_note,
                    'accept_proposed3_note' => $request->accept_proposed3_note, 
                    'status' => 6
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
