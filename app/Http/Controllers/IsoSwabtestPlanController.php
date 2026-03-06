<?php

namespace App\Http\Controllers;

use App\Models\IsoSwabtestPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IsoSwabtestPlanController extends Controller
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
            ->groupBy('iso_swabtest_plans_date')
            ->orderBy('iso_swabtest_plans_date', 'desc')
            ->get();
        return view('iso.list-swabtestplan',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('iso.create-swabtestplan',compact('hd'));
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
                ]);
            }

            DB::commit();
            return redirect()->route('iso-swabtestplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('iso-swabtestplan.index')
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
        $list = IsoSwabtestPlan::where('iso_swabtest_plans_date',$id)->first();
        $hd = IsoSwabtestPlan::where('iso_swabtest_plans_date',$id)->get();
        //dd($hd);
        return view('iso.edit-swabtestplan',compact('hd','list'));
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

            foreach ($request->iso_swabtest_plans_id as $key => $value) {

                $plan = $request->plans[$key] ?? [];
                $data = [
                    'iso_swabtest_plans_listno' => $request->iso_swabtest_plans_listno[$key] ?? ($key + 1),
                    'iso_swabtest_plans_area' => $request->iso_swabtest_plans_area[$key],
                    'iso_swabtest_plans_list' => $request->iso_swabtest_plans_list[$key],
                    'iso_swabtest_plans_qty' => $request->iso_swabtest_plans_qty[$key],
                    'iso_swabtest_plans_frequency' => $request->iso_swabtest_plans_frequency[$key],

                    'plan_jan' => $plan['jan'] ?? 0,
                    'plan_feb' => $plan['feb'] ?? 0,
                    'plan_mar' => $plan['mar'] ?? 0,
                    'plan_apr' => $plan['apr'] ?? 0,
                    'plan_may' => $plan['may'] ?? 0,
                    'plan_jun' => $plan['jun'] ?? 0,
                    'plan_jul' => $plan['jul'] ?? 0,
                    'plan_aug' => $plan['aug'] ?? 0,
                    'plan_sep' => $plan['sep'] ?? 0,
                    'plan_oct' => $plan['oct'] ?? 0,
                    'plan_nov' => $plan['nov'] ?? 0,
                    'plan_dec' => $plan['dec'] ?? 0,

                    'iso_swabtest_plans_flag' => true,
                    'person_at' => Auth::user()->name,
                    'iso_swabtest_plans_date' => $request->iso_swabtest_plans_date,
                    'iso_swabtest_plans_person' => $request->iso_swabtest_plans_person[$key] ?? null,
                    'iso_swabtest_plans_review' => $request->iso_swabtest_plans_review[$key] ?? null,
                    'updated_at' => now(),
                ];

                if ($value != 0) {

                    IsoSwabtestPlan::where('iso_swabtest_plans_id', $value)
                        ->update($data);

                } else {

                    $data['action_jan'] = 0;
                    $data['action_feb'] = 0;
                    $data['action_mar'] = 0;
                    $data['action_apr'] = 0;
                    $data['action_may'] = 0;
                    $data['action_jun'] = 0;
                    $data['action_jul'] = 0;
                    $data['action_aug'] = 0;
                    $data['action_sep'] = 0;
                    $data['action_oct'] = 0;
                    $data['action_nov'] = 0;
                    $data['action_dec'] = 0;

                    $data['created_at'] = now();

                    IsoSwabtestPlan::create($data);
                }
            }

            DB::commit();

            return redirect()->route('iso-swabtestplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->route('iso-swabtestplan.index')
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
