<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\MachineGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class MachineGroupController extends Controller
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
        $machinegroup = MachineGroup::get();
        return view('setup-machine.create-machinegroup',compact('machinegroup'));
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
            'machinegroup_code' => 'required',
            'machinegroup_name' => 'required',
        ]);
        $data = [
            'machinegroup_code' => $request->machinegroup_code,
            'machinegroup_name' => $request->machinegroup_name,
            'machinegroup_flag' => true,           
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]; 
        try {
            DB::beginTransaction();
            MachineGroup::create($data);
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
        $hd = MachineGroup::where('machinegroup_id',$id)->first();
        return view('setup-machine.edit-machinegroup',compact('hd'));
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
            'machinegroup_name' => 'required',
        ]);
        $flag = $request->machinegroup_flag;
        if ($flag == 'on' || $flag == 'true') {
            $flag = true;
        } else {
            $flag = false;
        }
        $data = [
            'machinegroup_name' => $request->machinegroup_name,
            'machinegroup_flag' => $flag,           
            'person_at' => Auth::user()->name,
            'updated_at'=> Carbon::now(),
        ]; 
         try {
            DB::beginTransaction();
            MachineGroup::where('machinegroup_id',$id)->update($data);
            DB::commit();
            return redirect()->route('machine-groups.create')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-groups.create')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
    public function updateInline(Request $request, $id)
    {
        $validated = $request->validate([
            'machinegroup_code' => 'required|string|max:255',
            'machinegroup_name' => 'required|string|max:255',
            'machinegroup_flag' => 'required|in:0,1',
        ]);
        DB::table('machine_groups')->where('machinegroup_id', $id)->update([
            'machinegroup_code' => $validated['machinegroup_code'],
            'machinegroup_name' => $validated['machinegroup_name'],
            'machinegroup_flag' => $validated['machinegroup_flag'],
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
        ]);
        return response()->json($validated);
    }   
}
