<?php

namespace App\Http\Controllers;

use App\Models\IsoAirtestPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $list = IsoAirtestPlan::where('iso_airtest_plans_date',$id)->first();
        $hd = IsoAirtestPlan::where('iso_airtest_plans_date',$id)->get();
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
        try {
            DB::beginTransaction();
           
            foreach ($request->iso_airtest_plans_id as $key => $value) {
                if($value != 0){
                    IsoAirtestPlan::where('iso_airtest_plans_id',$value)->update([
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


                        'iso_airtest_plans_person' => $request->iso_airtest_plans_person[$key],
                        'iso_airtest_plans_review' => $request->iso_airtest_plans_review[$key],

                        'iso_airtest_plans_flag' => true,
                        'person_at' => Auth::user()->name,

                        'updated_at' => now(),
                    ]);
                }else if($value == 0){
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
}
