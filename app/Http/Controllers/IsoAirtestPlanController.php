<?php

namespace App\Http\Controllers;

use App\Models\IsoAirtestPlan;
use App\Models\IsoAirtestRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IsoAirtestPlanController extends Controller
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
        $hd = IsoAirtestPlan::select('iso_airtest_plans_date')
            ->groupBy('iso_airtest_plans_date')
            ->orderBy('iso_airtest_plans_date', 'desc')
            ->get();
        return view('iso.list-airtestplan',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('iso.create-airtestplan',compact('hd'));
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
           
            foreach ($request->iso_airtest_plans_listno as $key => $value) {
                IsoAirtestPlan::create([
                    'iso_airtest_plans_listno' => $value,
                    'iso_airtest_plans_remark' => $request->iso_airtest_plans_remark[$key],
                    'iso_airtest_plans_frequency' => $request->iso_airtest_plans_frequency[$key],

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

                    'iso_airtest_plans_person' => $request->iso_airtest_plans_person[$key],
                    'iso_airtest_plans_review' => $request->iso_airtest_plans_review[$key],

                    'iso_airtest_plans_flag' => true,
                    'person_at' => Auth::user()->name,
                    'iso_airtest_plans_date' => $request->iso_airtest_plans_date,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('iso-airtestplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('iso-airtestplan.index')
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
        $hd = IsoAirtestPlan::find($id);
        $list = IsoAirtestRecord::where('flag',true)->where('iso_airtest_plans_id',$id)->get();
        return view('iso.update-airtestplan',compact('hd','list'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $list = IsoAirtestPlan::where('iso_airtest_plans_date',$id)
        ->where('iso_airtest_plans_flag',true)
        ->first();
        $hd = IsoAirtestPlan::where('iso_airtest_plans_date',$id)
        ->where('iso_airtest_plans_flag',true)
        ->get();
        return view('iso.edit-airtestplan',compact('hd','list'));
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
        //dd($request->all());
        try {
            DB::beginTransaction();

            foreach ($request->iso_airtest_plans_id as $key => $value) {

                // 🔥 รองรับ 2 format
                $plan = $request->plans[$key] ?? [];

                $data = [
                    'iso_airtest_plans_remark' => $request->iso_airtest_plans_remark[$key] ?? null,
                    'iso_airtest_plans_frequency' => $request->iso_airtest_plans_frequency[$key] ?? null,

                    // ✅ priority: plans[index][month] ก่อน
                    // ถ้าไม่มี → fallback ไป plan_xxx[]
                    'plan_jan' => $plan['jan'] ?? (isset($request->plan_jan[$key]) ? 1 : 0),
                    'plan_feb' => $plan['feb'] ?? (isset($request->plan_feb[$key]) ? 1 : 0),
                    'plan_mar' => $plan['mar'] ?? (isset($request->plan_mar[$key]) ? 1 : 0),
                    'plan_apr' => $plan['apr'] ?? (isset($request->plan_apr[$key]) ? 1 : 0),
                    'plan_may' => $plan['may'] ?? (isset($request->plan_may[$key]) ? 1 : 0),
                    'plan_jun' => $plan['jun'] ?? (isset($request->plan_jun[$key]) ? 1 : 0),
                    'plan_jul' => $plan['jul'] ?? (isset($request->plan_jul[$key]) ? 1 : 0),
                    'plan_aug' => $plan['aug'] ?? (isset($request->plan_aug[$key]) ? 1 : 0),
                    'plan_sep' => $plan['sep'] ?? (isset($request->plan_sep[$key]) ? 1 : 0),
                    'plan_oct' => $plan['oct'] ?? (isset($request->plan_oct[$key]) ? 1 : 0),
                    'plan_nov' => $plan['nov'] ?? (isset($request->plan_nov[$key]) ? 1 : 0),
                    'plan_dec' => $plan['dec'] ?? (isset($request->plan_dec[$key]) ? 1 : 0),

                    'iso_airtest_plans_person' => $request->iso_airtest_plans_person[$key] ?? null,
                    'iso_airtest_plans_review' => $request->iso_airtest_plans_review[$key] ?? null,

                    'iso_airtest_plans_flag' => true,
                    'person_at' => Auth::user()->name,
                    'updated_at' => now(),
                ];

                // 🔥 update / insert
                if ($value != 0) {

                    IsoAirtestPlan::where('iso_airtest_plans_id', $value)
                        ->update($data);

                } else {

                    $data['iso_airtest_plans_listno'] = $request->iso_airtest_plans_listno[$key] ?? ($key + 1);
                    $data['iso_airtest_plans_date'] = $request->iso_airtest_plans_date;

                    // default action = false
                    $data += [
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
                        'created_at' => now(),
                    ];

                    IsoAirtestPlan::create($data);
                }
            }

            DB::commit();

            return redirect()->route('iso-airtestplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('iso-airtestplan.index')
                ->with('error', 'บันทึกข้อมูลไม่สำเร็จ : ' . $e->getMessage());
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

    public function storeRecord(Request $request, $planId)
    {
        try {

            $record = new \App\Models\IsoAirtestRecord();

            $record->iso_airtest_plans_id = $planId;
            $record->iso_airtest_records_date = $request->iso_airtest_records_date;
            $record->iso_airtest_records_department = $request->iso_airtest_records_department;
            $record->iso_airtest_records_area = $request->iso_airtest_records_area;
            $record->iso_airtest_records_qty = $request->iso_airtest_records_qty;
            $record->iso_airtest_records_result = $request->iso_airtest_records_result;
            $record->iso_airtest_records_status = $request->iso_airtest_records_status;
            $record->iso_airtest_records_review = $request->iso_airtest_records_review;
            $record->iso_airtest_records_recheck = $request->iso_airtest_records_recheck;
            $record->iso_airtest_records_acknowledge = $request->iso_airtest_records_acknowledge;
            $record->iso_airtest_records_note = $request->iso_airtest_records_note;
            $record->created_at = now();
            $record->updated_at = now();
            $record->save();

            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อยแล้ว');

        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function confirmDelAirtestnRecord(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            IsoAirtestRecord::where('iso_airtest_records_id',$id)->update([
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

    public function confirmDelAirtestnPlan(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            IsoAirtestPlan::where('iso_airtest_plans_id',$id)->update([
                'iso_airtest_plans_flag' => false,
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
