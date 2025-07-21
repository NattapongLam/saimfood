<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Equipment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EquipmentController extends Controller
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
        $equipment = Equipment::leftjoin('equipment_statuses','equipment.equipment_status_id','=','equipment_statuses.equipment_status_id')
        ->select('equipment.*','equipment_statuses.equipment_status_name')
        ->get();
        return view('setup-equipment.list-equipment',compact('equipment'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('setup-equipment.create-equipment');
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
            'equipmente_date' => 'required',
            'equipment_code' => 'required',
            'equipment_name' => 'required',
            'insurance_date' => 'required',
        ]);
        $data = [
            'equipmente_date' => $request->equipmente_date,
            'equipment_code' => $request->equipment_code,
            'equipment_name' => $request->equipment_name,
            'serial_number' => $request->serial_number,
            'insurance_date' => $request->insurance_date,
            'equipment_details' => $request->equipment_details,
            'equipment_flag' => true,           
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
            'equipment_status_id' => 1,
            'equipment_cost' => $request->equipment_cost,
            'equipment_brand' => $request->equipment_brand
        ];
        if ($request->hasFile('equipment_pic1') && $request->file('equipment_pic1')->isValid()) {
            $filename = "EQ_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('equipment_pic1')->getClientOriginalExtension();
            $request->file('equipment_pic1')->storeAs('equipment_img', $filename, 'public');
            $data['equipment_pic1'] = 'storage/equipment_img/' . $filename;
        }
        if ($request->hasFile('equipment_pic2') && $request->file('equipment_pic2')->isValid()) {
            $filename = "EQ_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('equipment_pic2')->getClientOriginalExtension();
            $request->file('equipment_pic2')->storeAs('equipment_img', $filename, 'public');
            $data['equipment_pic2'] = 'storage/equipment_img/' . $filename;
        }
        if ($request->hasFile('equipment_pic3') && $request->file('equipment_pic3')->isValid()) {
            $filename = "EQ_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('equipment_pic3')->getClientOriginalExtension();
            $request->file('equipment_pic3')->storeAs('equipment_img', $filename, 'public');
            $data['equipment_pic3'] = 'storage/equipment_img/' . $filename;
        }
        if ($request->hasFile('equipment_pic4') && $request->file('equipment_pic4')->isValid()) {
            $filename = "EQ_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('equipment_pic4')->getClientOriginalExtension();
            $request->file('equipment_pic4')->storeAs('equipment_img', $filename, 'public');
            $data['equipment_pic4'] = 'storage/equipment_img/' . $filename;
        }
        try {
            DB::beginTransaction();
            Equipment::create($data);
            DB::commit();
            return redirect()->route('equipments.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('equipments.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = Equipment::where('equipment_id',$id)->first();
        return view('setup-equipment.edit-equipment',compact('hd'));
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
        
        $request->validate([
            'equipment_name' => 'required',
            'equipmente_date' => 'required',
            'insurance_date' => 'required',
        ]);
        $flag = $request->equipment_flag;
        if ($flag == 'on' || $flag == 'true') {
            $flag = true;
        } else {
            $flag = false;
        }
         $data = [
            'equipmente_date' => $request->equipmente_date,
            'equipment_name' => $request->equipment_name,
            'serial_number' => $request->serial_number,
            'insurance_date' => $request->insurance_date,
            'equipment_details' => $request->equipment_details,
            'equipment_flag' =>  $flag,           
            'person_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
            'equipment_cost' => $request->equipment_cost,
            'equipment_brand' => $request->equipment_brand
        ];
        if ($request->hasFile('equipment_pic1') && $request->file('equipment_pic1')->isValid()) {
            $filename = "EQ_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('equipment_pic1')->getClientOriginalExtension();
            $request->file('equipment_pic1')->storeAs('equipment_img', $filename, 'public');
            $data['equipment_pic1'] = 'storage/equipment_img/' . $filename;
        }
        if ($request->hasFile('equipment_pic2') && $request->file('equipment_pic2')->isValid()) {
            $filename = "EQ_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('equipment_pic2')->getClientOriginalExtension();
            $request->file('equipment_pic2')->storeAs('equipment_img', $filename, 'public');
            $data['equipment_pic2'] = 'storage/equipment_img/' . $filename;
        }
        if ($request->hasFile('equipment_pic3') && $request->file('equipment_pic3')->isValid()) {
            $filename = "EQ_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('equipment_pic3')->getClientOriginalExtension();
            $request->file('equipment_pic3')->storeAs('equipment_img', $filename, 'public');
            $data['equipment_pic3'] = 'storage/equipment_img/' . $filename;
        }
        if ($request->hasFile('equipment_pic4') && $request->file('equipment_pic4')->isValid()) {
            $filename = "EQ_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('equipment_pic4')->getClientOriginalExtension();
            $request->file('equipment_pic4')->storeAs('equipment_img', $filename, 'public');
            $data['equipment_pic4'] = 'storage/equipment_img/' . $filename;
        }
        try {
            DB::beginTransaction();
            Equipment::where('equipment_id',$id)->update($data);
            DB::commit();
            return redirect()->route('equipments.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('equipments.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
