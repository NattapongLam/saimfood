<?php

namespace App\Http\Controllers;

use App\Models\IsoWaterQualityPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class IsoWaterQualityPlanController extends Controller
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
        $hd = IsoWaterQualityPlan::select('iso_water_quality_plans_date')
            ->groupBy('iso_water_quality_plans_date')
            ->orderBy('iso_water_quality_plans_date', 'desc')
            ->get();
        return view('iso.list-waterqualityplan',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('iso.create-waterqualityplan',compact('hd'));
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
           
            foreach ($request->iso_water_quality_plans_listno as $key => $value) {
                IsoWaterQualityPlan::create([
                    'iso_water_quality_plans_listno' => $value,
                    'iso_water_quality_plans_location' => $request->iso_water_quality_plans_location[$key],
                    'iso_water_quality_plans_area' => $request->iso_water_quality_plans_area[$key],

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

                    'iso_water_quality_plans_person' => $request->iso_water_quality_plans_person[$key],
                    'iso_water_quality_plans_review' => $request->iso_water_quality_plans_review[$key],
                    'iso_water_quality_plans_remark' => $request->iso_water_quality_plans_remark[$key],

                    'iso_water_quality_plans_flag' => true,
                    'person_at' => Auth::user()->name,
                    'iso_water_quality_plans_date' => $request->iso_water_quality_plans_date,

                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            DB::commit();
            return redirect()->route('iso-waterqualityplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('iso-waterqualityplan.index')
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
        $list = IsoWaterQualityPlan::where('iso_water_quality_plans_date',$id)->first();
        $hd = IsoWaterQualityPlan::where('iso_water_quality_plans_date',$id)->get();
        return view('iso.edit-waterqualityplan',compact('hd','list'));
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
        DB::beginTransaction();
        try {

            foreach ($request->iso_water_quality_plans_id as $key => $value) {

                $data = [
                    'iso_water_quality_plans_location' => $request->iso_water_quality_plans_location[$key],
                    'iso_water_quality_plans_area' => $request->iso_water_quality_plans_area[$key],

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

                    'iso_water_quality_plans_person' => $request->iso_water_quality_plans_person[$key],
                    'iso_water_quality_plans_review' => $request->iso_water_quality_plans_review[$key],
                    'iso_water_quality_plans_remark' => $request->iso_water_quality_plans_remark[$key],

                    'person_at' => auth()->user()->name,
                    'updated_at' => now(),
                ];

                // ===============================
                // 📌 HANDLE FILE UPLOAD (12 เดือน)
                // ===============================
                $months = [
                    'jan','feb','mar','apr','may','jun',
                    'jul','aug','sep','oct','nov','dec'
                ];

                foreach ($months as $m) {

                    $fileKey = "file_{$m}";

                    if ($request->hasFile($fileKey) && isset($request->file($fileKey)[$key])) {

                        $file = $request->file($fileKey)[$key];

                        $path = $file->store('waterquality_img', 'public');

                        // ลบไฟล์เก่า (ถ้ามี)
                        $old = IsoWaterQualityPlan::find($value);
                        if ($old && $old->$fileKey) {
                            Storage::disk('public')->delete($old->$fileKey);
                        }

                        $data[$fileKey] = $path;
                    }
                }

                if ($value != 0) {
                    IsoWaterQualityPlan::where('iso_water_quality_plans_id', $value)
                        ->update($data);
                } else {
                    $data['created_at'] = now();
                    $data['iso_water_quality_plans_flag'] = 1;

                    IsoWaterQualityPlan::create($data);
                }
            }

            DB::commit();

            return redirect()
                ->route('iso-waterqualityplan.index')
                ->with('success', 'บันทึกข้อมูลเรียบร้อย');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->route('iso-waterqualityplan.index')
                ->with('error', 'เกิดข้อผิดพลาด : ' . $e->getMessage());
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
