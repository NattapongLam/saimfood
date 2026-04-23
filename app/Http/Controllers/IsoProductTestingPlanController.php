<?php

namespace App\Http\Controllers;

use App\Models\IsoProductTestingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IsoProductTestingPlanController extends Controller
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
        $hd = IsoProductTestingPlan::select('iso_product_testing_plans_date')
            ->groupBy('iso_product_testing_plans_date')
            ->orderBy('iso_product_testing_plans_date', 'desc')
            ->get();
        return view('iso.list-producttestingplan',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('iso.create-producttestingplan',compact('hd'));
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
           
            foreach ($request->iso_product_testing_plans_listno as $key => $value) {
                IsoProductTestingPlan::create([
                    'iso_product_testing_plans_listno' => $value,
                    'iso_product_testing_plans_name' => $request->iso_product_testing_plans_name[$key],
                    'iso_product_testing_plans_code' => $request->iso_product_testing_plans_code[$key],
                    'iso_product_testing_plans_group' => $request->iso_product_testing_plans_group[$key],

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

                    'iso_product_testing_plans_flag' => true,
                    'person_at' => Auth::user()->name,
                    'iso_product_testing_plans_date' => $request->iso_product_testing_plans_date,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('iso-producttestingplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('iso-producttestingplan.index')
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
        $list = IsoProductTestingPlan::where('iso_product_testing_plans_date',$id)->first();
        $hd = IsoProductTestingPlan::where('iso_product_testing_plans_date',$id)->get();
        return view('iso.edit-producttestingplan',compact('hd','list'));
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
    try {
        DB::beginTransaction();

        $months = ['jan','feb','mar','apr','may','jun','jul','aug','sep','oct','nov','dec'];

        foreach ($request->iso_product_testing_plans_id as $key => $value) {

            $data = [
                'iso_product_testing_plans_name'  => $request->iso_product_testing_plans_name[$key] ?? null,
                'iso_product_testing_plans_code'  => $request->iso_product_testing_plans_code[$key] ?? null,
                'iso_product_testing_plans_group' => $request->iso_product_testing_plans_group[$key] ?? null,
                'iso_product_testing_plans_flag'  => true,
                'person_at' => Auth::user()->name,
                'updated_at' => now(),
            ];

            foreach ($months as $m) {

                // =========================
                // ✅ PLAN (รองรับ 2 format)
                // =========================
                $plan = 0;

                if (isset($request->plans[$key]["plan_$m"])) {
                    $plan = $request->plans[$key]["plan_$m"];
                } elseif (isset($request->{"plan_$m"}[$key])) {
                    $plan = $request->{"plan_$m"}[$key];
                }

                $data["plan_$m"] = $plan ? 1 : 0;

                // =========================
                // ✅ ACTION
                // =========================
                $action = 0;

                if (isset($request->plans[$key]["action_$m"])) {
                    $action = $request->plans[$key]["action_$m"];
                } elseif (isset($request->{"action_$m"}[$key])) {
                    $action = $request->{"action_$m"}[$key];
                }

                $data["action_$m"] = $action ? 1 : 0;

                // =========================
                // ✅ FILE (รองรับ 2 format)
                // =========================
                $file = null;

                if ($request->hasFile("plans.$key.file_$m")) {
                    $file = $request->file("plans.$key.file_$m");
                } elseif ($request->hasFile("file_$m.$key")) {
                    $file = $request->file("file_$m.$key");
                }

                if ($file) {
                    $filename = time() . "_{$m}_" . $file->getClientOriginalName();
                    $path = $file->storeAs('producttestingplan_img', $filename, 'public');

                    $data["file_$m"] = $path;
                }
            }

            // =========================
            // ✅ UPDATE / CREATE
            // =========================
            if ($value != 0) {

                IsoProductTestingPlan::where('iso_product_testing_plans_id', $value)
                    ->update($data);

            } else {

                $data['iso_product_testing_plans_date'] = $request->iso_product_testing_plans_date;
                $data['created_at'] = now();

                IsoProductTestingPlan::create($data);
            }
        }

        DB::commit();

        return redirect()->route('iso-producttestingplan.index')
            ->with('success', 'บันทึกข้อมูลเรียบร้อย');

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect()->route('iso-producttestingplan.index')
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
}
