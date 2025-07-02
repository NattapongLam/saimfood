<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Machine;
use Illuminate\Support\Str;
use App\Models\MachineGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\File;

class MachineController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $machinegroup = MachineGroup::where('machinegroup_flag',true)->get();
        $machine = Machine::leftjoin('machine_groups','machines.machinegroup_id','=','machine_groups.machinegroup_id')->get();
        return view('setup-machine.create-machine',compact('machinegroup','machine'));
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
            'machine_code' => 'required',
            'machine_name' => 'required',
            'machinegroup_id' => 'required',
            'machine_date' => 'required',
        ]);
        $data = [
            'machine_date' => $request->machine_date,
            'machine_code' => $request->machine_code,
            'machine_name' => $request->machine_name,
            'machinegroup_id' => $request->machinegroup_id,
            'serial_number' => $request->serial_number,
            'insurance_date' => $request->insurance_date,
            'machine_details' => $request->machine_details,
            'machine_flag' => true,           
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]; 
        if ($request->hasFile('machine_pic1') && $request->file('machine_pic1')->isValid()) {
            $filename = "MC_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_pic1')->getClientOriginalExtension();
            $request->file('machine_pic1')->storeAs('machine_img', $filename, 'public');
            $data['machine_pic1'] = 'storage/machine_img/' . $filename;
        }
        if ($request->hasFile('machine_pic2') && $request->file('machine_pic2')->isValid()) {
            $filename = "MC_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_pic2')->getClientOriginalExtension();
            $request->file('machine_pic2')->storeAs('machine_img', $filename, 'public');
            $data['machine_pic2'] = 'storage/machine_img/' . $filename;
        }
        if ($request->hasFile('machine_pic3') && $request->file('machine_pic3')->isValid()) {
            $filename = "MC_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_pic3')->getClientOriginalExtension();
            $request->file('machine_pic3')->storeAs('machine_img', $filename, 'public');
            $data['machine_pic3'] = 'storage/machine_img/' . $filename;
        }
        if ($request->hasFile('machine_pic4') && $request->file('machine_pic4')->isValid()) {
            $filename = "MC_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_pic4')->getClientOriginalExtension();
            $request->file('machine_pic4')->storeAs('machine_img', $filename, 'public');
            $data['machine_pic4'] = 'storage/machine_img/' . $filename;
        }
        try {
            DB::beginTransaction();
            Machine::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->back()->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $machinegroup = MachineGroup::where('machinegroup_flag',true)->get();
        $hd = Machine::where('machine_id',$id)->first();
        return view('setup-machine.edit-machine',compact('machinegroup','hd'));
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
            'machine_name' => 'required',
            'machinegroup_id' => 'required',
            'machine_date' => 'required',
        ]);
        $flag = $request->machine_flag;
        if ($flag == 'on' || $flag == 'true') {
            $flag = true;
        } else {
            $flag = false;
        }
         $data = [
            'machine_date' => $request->machine_date,
            'machine_name' => $request->machine_name,
            'machinegroup_id' => $request->machinegroup_id,
            'serial_number' => $request->serial_number,
            'insurance_date' => $request->insurance_date,
            'machine_details' => $request->machine_details,
            'machine_flag' => $flag,           
            'person_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
        ]; 
        if ($request->hasFile('machine_pic1') && $request->file('machine_pic1')->isValid()) {
            $filename = "MC_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_pic1')->getClientOriginalExtension();
            $request->file('machine_pic1')->storeAs('machine_img', $filename, 'public');
            $data['machine_pic1'] = 'storage/machine_img/' . $filename;
        }
        if ($request->hasFile('machine_pic2') && $request->file('machine_pic2')->isValid()) {
            $filename = "MC_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_pic2')->getClientOriginalExtension();
            $request->file('machine_pic2')->storeAs('machine_img', $filename, 'public');
            $data['machine_pic2'] = 'storage/machine_img/' . $filename;
        }
        if ($request->hasFile('machine_pic3') && $request->file('machine_pic3')->isValid()) {
            $filename = "MC_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_pic3')->getClientOriginalExtension();
            $request->file('machine_pic3')->storeAs('machine_img', $filename, 'public');
            $data['machine_pic3'] = 'storage/machine_img/' . $filename;
        }
        if ($request->hasFile('machine_pic4') && $request->file('machine_pic4')->isValid()) {
            $filename = "MC_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('machine_pic4')->getClientOriginalExtension();
            $request->file('machine_pic4')->storeAs('machine_img', $filename, 'public');
            $data['machine_pic4'] = 'storage/machine_img/' . $filename;
        }
        try {
            DB::beginTransaction();
            Machine::where('machine_id',$id)->update($data);
            DB::commit();
            return redirect()->route('machines.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machines.create')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
