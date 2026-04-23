<?php

namespace App\Http\Controllers;

use App\Models\ClbMeasuringList;
use App\Models\ClbMeasuringPlan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClbMeasuringPlanController extends Controller
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
        $hd = ClbMeasuringPlan::select('clb_measuring_lists_date')
            ->groupBy('clb_measuring_lists_date')
            ->orderBy('clb_measuring_lists_date', 'desc')
            ->get();
        return view('measurings.list-measuringplan',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clb = ClbMeasuringList::where('clb_measuring_lists_flag',true)->orderBy('clb_measuring_lists_listno', 'asc')->get();
        return view('measurings.create-measuringplan',compact('clb'));
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
           
            foreach ($request->clb_measuring_lists_id as $key => $value) {
                ClbMeasuringPlan::create([
                    'clb_measuring_lists_id' => $value,
                    'clb_measuring_lists_listno' => $request->clb_measuring_lists_listno[$key],
                    'clb_measuring_lists_code' => $request->clb_measuring_lists_code[$key],
                    'clb_measuring_lists_name' => $request->clb_measuring_lists_name[$key],
                    'clb_measuring_lists_department' => $request->clb_measuring_lists_department[$key],
                    'clb_measuring_lists_frequency' => $request->clb_measuring_lists_frequency[$key],
                    'actualuseperiod' => $request->actualuseperiod[$key],
                    'acceptancecriteria' => $request->acceptancecriteria[$key],

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

                    'clb_measuring_lists_inside' => $request->clb_measuring_lists_inside[$key],
                    'clb_measuring_lists_external' => $request->clb_measuring_lists_external[$key],
                    'clb_measuring_lists_remark' => $request->clb_measuring_lists_remark[$key],

                    'clb_measuring_lists_flag' => true,
                    'person_at' => Auth::user()->name,
                    'clb_measuring_lists_date' => $request->clb_measuring_lists_date,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('clb-measuringplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('clb-measuringplan.index')
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
        $year = $id;        
        $clb = DB::table('clb_measuring_plans')
        ->where('clb_measuring_lists_flag',true)
        ->where('clb_measuring_lists_date',$id)
        ->orderBy('clb_measuring_lists_listno', 'asc')
        ->get();
        return view('measurings.edit-measuringplan',compact('clb','year'));
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
        $hd = ClbMeasuringPlan::where('clb_measuring_lists_date', $id)->first();

        if (!$hd) {
            return redirect()->back()->with('error', 'ไม่พบข้อมูล');
        }

        try {
            DB::beginTransaction();

            $plans = $request->clb_measuring_plans_id ?? [];

            foreach ($plans as $key => $value) {

                $data = [
                    'clb_measuring_lists_id' => $request->clb_measuring_lists_id[$key] ?? null,
                    'clb_measuring_lists_listno' => $request->clb_measuring_lists_listno[$key] ?? null,
                    'clb_measuring_lists_code' => $request->clb_measuring_lists_code[$key] ?? null,
                    'clb_measuring_lists_name' => $request->clb_measuring_lists_name[$key] ?? null,
                    'clb_measuring_lists_department' => $request->clb_measuring_lists_department[$key] ?? null,
                    'clb_measuring_lists_frequency' => $request->clb_measuring_lists_frequency[$key] ?? null,
                    'actualuseperiod' => $request->actualuseperiod[$key] ?? null,
                    'acceptancecriteria' => $request->acceptancecriteria[$key] ?? null,

                    // PLAN
                    'plan_jan' => $request->plan_jan[$key] ?? 0,
                    'plan_feb' => $request->plan_feb[$key] ?? 0,
                    'plan_mar' => $request->plan_mar[$key] ?? 0,
                    'plan_apr' => $request->plan_apr[$key] ?? 0,
                    'plan_may' => $request->plan_may[$key] ?? 0,
                    'plan_jun' => $request->plan_jun[$key] ?? 0,
                    'plan_jul' => $request->plan_jul[$key] ?? 0,
                    'plan_aug' => $request->plan_aug[$key] ?? 0,
                    'plan_sep' => $request->plan_sep[$key] ?? 0,
                    'plan_oct' => $request->plan_oct[$key] ?? 0,
                    'plan_nov' => $request->plan_nov[$key] ?? 0,
                    'plan_dec' => $request->plan_dec[$key] ?? 0,

                    // ACTION
                    'action_jan' => $request->action_jan[$key] ?? 0,
                    'action_feb' => $request->action_feb[$key] ?? 0,
                    'action_mar' => $request->action_mar[$key] ?? 0,
                    'action_apr' => $request->action_apr[$key] ?? 0,
                    'action_may' => $request->action_may[$key] ?? 0,
                    'action_jun' => $request->action_jun[$key] ?? 0,
                    'action_jul' => $request->action_jul[$key] ?? 0,
                    'action_aug' => $request->action_aug[$key] ?? 0,
                    'action_sep' => $request->action_sep[$key] ?? 0,
                    'action_oct' => $request->action_oct[$key] ?? 0,
                    'action_nov' => $request->action_nov[$key] ?? 0,
                    'action_dec' => $request->action_dec[$key] ?? 0,

                    'clb_measuring_lists_inside' => $request->clb_measuring_lists_inside[$key] ?? null,
                    'clb_measuring_lists_external' => $request->clb_measuring_lists_external[$key] ?? null,
                    'clb_measuring_lists_remark' => $request->clb_measuring_lists_remark[$key] ?? null,

                    'clb_measuring_lists_flag' => true,
                    'person_at' => Auth::user()->name,
                    'clb_measuring_lists_date' => $request->clb_measuring_lists_date,
                    'updated_at' => now(),
                ];

                // ================= FILE UPLOAD =================
                $months = [
                    'jan','feb','mar','apr','may','jun',
                    'jul','aug','sep','oct','nov','dec'
                ];

                foreach ($months as $m) {
                    if ($request->hasFile("file_{$m}.$key")) {

                        $file = $request->file("file_{$m}.$key");

                        $filename = time() . "_{$m}_{$key}." . $file->getClientOriginalExtension();

                        $path = $file->storeAs('measuringplan_img', $filename, 'public');

                        $data["file_{$m}"] = $path;
                    }
                }

                ClbMeasuringPlan::where('clb_measuring_plans_id', $value)->update($data);
            }

            DB::commit();

            return redirect()->route('clb-measuringplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()
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

    public function confirmDelMeasuringPlan(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            ClbMeasuringPlan::where('clb_measuring_plans_id',$id)->update([
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
