<?php

namespace App\Http\Controllers;

use App\Models\IsoSwabtestAllergenRecord;
use App\Models\IsoSwabtestPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IsoSwabtestAllergenPlanController extends Controller
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
        $hd = IsoSwabtestPlan::select('iso_swabtest_plans_date')
            ->where('docutype','Allergen')
            ->groupBy('iso_swabtest_plans_date')
            ->orderBy('iso_swabtest_plans_date', 'desc')
            ->get();
        return view('iso.list-swabtestallergenplan',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('iso.create-swabtestallergenplan',compact('hd'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
           
            foreach ($request->iso_swabtest_plans_listno as $key => $value) {
                IsoSwabtestPlan::create([
                    'iso_swabtest_plans_listno' => $value,
                    'iso_swabtest_plans_area' => $request->iso_swabtest_plans_area[$key],
                    'iso_swabtest_plans_list' => $request->iso_swabtest_plans_list[$key],
                    'iso_swabtest_plans_qty' => $request->iso_swabtest_plans_qty[$key],
                    'iso_swabtest_plans_frequency' => $request->iso_swabtest_plans_frequency[$key],

                    'plan_jan' => isset($request->plan_jan[$key]) ? 1 : 0,
                    'plan_feb' => isset($request->plan_feb[$key]) ? 1 : 0,
                    'plan_mar' => isset($request->plan_mar[$key]) ? 1 : 0,
                    'plan_apr' => isset($request->plan_apr[$key]) ? 1 : 0,
                    'plan_may' => isset($request->plan_may[$key]) ? 1 : 0,
                    'plan_jun' => isset($request->plan_jun[$key]) ? 1 : 0,
                    'plan_jul' => isset($request->plan_jul[$key]) ? 1 : 0,
                    'plan_aug' => isset($request->plan_aug[$key]) ? 1 : 0,
                    'plan_sep' => isset($request->plan_sep[$key]) ? 1 : 0,
                    'plan_oct' => isset($request->plan_oct[$key]) ? 1 : 0,
                    'plan_nov' => isset($request->plan_nov[$key]) ? 1 : 0,
                    'plan_dec' => isset($request->plan_dec[$key]) ? 1 : 0,

                    'action_jan' => false,
                    'action_feb' => false,
                    'action_mar' => false,
                    'action_apr' => false,
                    'action_may' => false,
                    'action_jun' => false,
                    'action_jul' => false,
                    'action_aug' => false,
                    'action_sep' => false,
                    'action_oct' => false,
                    'action_nov' => false,
                    'action_dec' => false,

                    'iso_swabtest_plans_flag' => true,
                    'person_at' => Auth::user()->name,
                    'iso_swabtest_plans_date' => $request->iso_swabtest_plans_date,
                    'iso_swabtest_plans_person' => $request->iso_swabtest_plans_person[$key],
                    'iso_swabtest_plans_review' => $request->iso_swabtest_plans_review[$key],
                    'created_at' => now(),
                    'updated_at' => now(),
                    'docutype' => 'Allergen'
                ]);
            }

            DB::commit();
            return redirect()->route('iso-swabtestplanallergen.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('iso-swabtestplanallergen.index')
                ->with('error', 'บันทึกข้อมูลไม่สำเร็จ : ' . $e->getMessage());
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
        $hd = IsoSwabtestPlan::find($id);
        $list = IsoSwabtestAllergenRecord::where('flag',true)->where('iso_swabtest_plans_id',$id)->get();
        return view('iso.update-swabtestallergenplan',compact('hd','list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = IsoSwabtestPlan::where('iso_swabtest_plans_date',$id)->where('docutype','Allergen')->first();
        $hd = IsoSwabtestPlan::where('iso_swabtest_plans_date',$id)->where('docutype','Allergen')->get();
        //dd($hd);
        return view('iso.edit-swabtestallergenplan',compact('hd','list'));
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
    public function autoUpdate(Request $request)
    {
        try {

            $plan = IsoSwabtestPlan::find($request->id);

            if (!$plan) {
                return response()->json([
                    'status' => false,
                    'msg' => 'not found'
                ]);
            }

            $allowedFields = [
                'plan_jan','plan_feb','plan_mar','plan_apr','plan_may','plan_jun',
                'plan_jul','plan_aug','plan_sep','plan_oct','plan_nov','plan_dec',
                'action_jan','action_feb','action_mar','action_apr','action_may','action_jun',
                'action_jul','action_aug','action_sep','action_oct','action_nov','action_dec',
                // 🔥 FIX
                'iso_swabtest_plans_person',
                'iso_swabtest_plans_review',
                'iso_swabtest_plans_area',
                'iso_swabtest_plans_list',
                'iso_swabtest_plans_qty',
                'iso_swabtest_plans_frequency',
            ];

            if (!in_array($request->field, $allowedFields)) {
                return response()->json([
                    'status' => false,
                    'msg' => 'field not allowed'
                ]);
            }

            $plan->{$request->field} = $request->value;
            $plan->person_at = auth()->user()->name ?? 'system';
            $plan->updated_at = now();
            $plan->save();

            return response()->json(['status' => true]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function storeRecord(Request $request, $planId)
    {
        try {

            $request->validate([
                'iso_swabtest_allergen_records_area' => 'required',
            ]);

            $record = new \App\Models\IsoSwabtestAllergenRecord();

            $record->iso_swabtest_plans_id = $planId;
            $record->iso_swabtest_allergen_records_datetime = $request->iso_swabtest_allergen_records_datetime;
            $record->iso_swabtest_allergen_records_area = $request->iso_swabtest_allergen_records_area;
            $record->iso_swabtest_allergen_records_productname = $request->iso_swabtest_allergen_records_productname;
            $record->iso_swabtest_allergen_records_productcode = $request->iso_swabtest_allergen_records_productcode;
            $record->iso_swabtest_allergen_records_lotno = $request->iso_swabtest_allergen_records_lotno;
            $record->iso_swabtest_allergen_records_bactchno = $request->iso_swabtest_allergen_records_bactchno;
            $record->iso_swabtest_allergen_records_name = $request->iso_swabtest_allergen_records_name;
            $record->iso_swabtest_allergen_records_remark = $request->iso_swabtest_allergen_records_remark;
            $record->iso_swabtest_allergen_records_color = $request->iso_swabtest_allergen_records_color;
            $record->iso_swabtest_allergen_records_result = $request->iso_swabtest_allergen_records_result;
            $record->iso_swabtest_allergen_records_status = $request->iso_swabtest_allergen_records_status;
            $record->iso_swabtest_allergen_records_review = $request->iso_swabtest_allergen_records_review;
            $record->iso_swabtest_allergen_records_recheck = $request->iso_swabtest_allergen_records_recheck;
            $record->iso_swabtest_allergen_records_acknowledge = $request->iso_swabtest_allergen_records_acknowledge;
            $record->iso_swabtest_allergen_records_note = $request->iso_swabtest_allergen_records_note;
            $record->created_at = now();
            $record->updated_at = now();
            $record->save();

            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function confirmDelSwabtestallergenRecord(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            IsoSwabtestAllergenRecord::where('iso_swabtest_allergen_records_id',$id)->update([
                'flag' => false,
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
