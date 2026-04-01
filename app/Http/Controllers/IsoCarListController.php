<?php

namespace App\Http\Controllers;

use App\Models\IsoCarList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IsoCarListController extends Controller
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
        $hd = IsoCarList::get();
        return view('iso.list-carlist',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $hd = null;
        return view('iso.create-carlist',compact('hd'));
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
            'iso_car_lists_docuno' => 'required',
            'type_name' => 'required',
        ]);
        $data = [
            'iso_car_lists_docuno' => $request->iso_car_lists_docuno,
            'iso_car_lists_refno' => $request->iso_car_lists_refno,
            'type_name' => $request->type_name,
            'type_remark' => $request->type_remark,
            'iso_car_lists_problem' => $request->iso_car_lists_problem,
            'iso_car_lists_requirement' => $request->iso_car_lists_requirement,
            'iso_car_lists_person' => $request->iso_car_lists_person,
            'iso_car_lists_position' => $request->iso_car_lists_position,
            'iso_car_lists_date' => $request->iso_car_lists_date,
            'status' => 1
        ];
        try {
            DB::beginTransaction();
            IsoCarList::create($data);
            DB::commit();
            return redirect()->route('iso-carlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('iso-carlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = IsoCarList::find($id);
        return view('iso.edit-carlist',compact('hd'));
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
        $hd = IsoCarList::find($id);
        if($hd->status == 1){
            try {
                DB::beginTransaction();
                IsoCarList::where('iso_car_lists_id',$id)
                ->update([
                    'cause_name' => $request->cause_name,
                    'cause_remark' => $request->cause_remark,
                    'cause_analysis' => $request->cause_analysis,
                    'cause_actions' => $request->cause_actions,
                    'cause_recurrence' => $request->cause_recurrence,
                    'cause_duedate' => $request->cause_duedate,
                    'cause_person' => $request->cause_person,
                    'cause_position' => $request->cause_position,
                    'cause_date' => $request->cause_date,
                    'status' => 2
                ]);
                DB::commit();
                return redirect()->route('iso-carlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-carlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }    
        }elseif ($hd->status == 2) {
            try {
                DB::beginTransaction();
                IsoCarList::where('iso_car_lists_id',$id)
                ->update([
                    'cause_correction_person' => $request->cause_correction_person,
                    'cause_correction_position' => $request->cause_correction_position,
                    'cause_correction_date' => $request->cause_correction_date,
                    'status' => 3
                ]);
                DB::commit();
                return redirect()->route('iso-carlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-carlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }    
        }elseif($hd->status == 3){
            try {
                DB::beginTransaction();
                IsoCarList::where('iso_car_lists_id',$id)
                ->update([
                    'cause_management_person' => $request->cause_management_person,
                    'cause_management_date' => $request->cause_management_date,
                    'status' => 4
                ]);
                DB::commit();
                return redirect()->route('iso-carlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-carlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }    
        }elseif($hd->status == 4){
            try {
                DB::beginTransaction();
                IsoCarList::where('iso_car_lists_id',$id)
                ->update([
                    'measuresone_check' => $request->has('measuresone_check') ? 1 : 0,
                    'measuresone_next'  => $request->has('measuresone_next') ? 1 : 0,
                    'measuresone_date'  => $request->measuresone_date,
                    'status'            => 5,
                    'measuresone_remark'=> $request->measuresone_remark,
                    'measuresone_person'=> $request->measuresone_person,
                    'measuresone_position'=> $request->measuresone_position,
                    'measuresone_persondate' => $request->measuresone_persondate,                  
                ]);
                DB::commit();
                return redirect()->route('iso-carlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-carlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }    
        }elseif($hd->status == 5){
            try {
                DB::beginTransaction();
                IsoCarList::where('iso_car_lists_id',$id)
                ->update([
                    'status'            => 6,
                    'measuresone_correction_person'=> $request->measuresone_correction_person,
                    'measuresone_correction_position'=> $request->measuresone_correction_position,
                    'measuresone_correction_date' => $request->measuresone_correction_date,                  
                ]);
                DB::commit();
                return redirect()->route('iso-carlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-carlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }    
        }elseif($hd->status == 6){
            try {
                DB::beginTransaction();
                IsoCarList::where('iso_car_lists_id',$id)
                ->update([
                    'status'            => 7,
                    'measuresone_management_person'=> $request->measuresone_management_person,
                    'measuresone_management_date' => $request->measuresone_management_date,                  
                ]);
                DB::commit();
                return redirect()->route('iso-carlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-carlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }    
        }elseif($hd->status == 7){
            try {
                DB::beginTransaction();
                IsoCarList::where('iso_car_lists_id',$id)
                ->update([
                    'status'            => 8,
                    'close_car'=> $request->has('close_car') ? 1 : 0,
                    'new_car' => $request->has('new_car') ? 1 : 0, 
                    'new_docuno' => $request->new_docuno,
                    'car_remark' => $request->car_remark,  
                    'car_management_person' => $request->car_management_person,
                    'car_management_date' => $request->car_management_date
                ]);
                DB::commit();
                return redirect()->route('iso-carlist.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('iso-carlist.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
