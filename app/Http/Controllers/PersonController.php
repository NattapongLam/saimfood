<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class PersonController extends Controller
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
        $users = DB::table('users')->get();
        return view('persons.main-person',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $emp = DB::table('tg_employee_list')->get();
        return view('persons.create-person',compact('emp'));
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
            'username' => 'required',
            'password' => 'required',
        ]);
        $emp = DB::table('tg_employee_list')->where('personcode',$request->username)->first();
        $data = [
            'name' => $emp->personfullname,
            'username' => $request->username,
            'employee_code' => $request->username,
            'employee_fullname' => $emp->personfullname,
            'email' => $request->email,
            'status' => true,   
            'password' => Hash::make($request->password),        
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ]; 
        try 
        {
            DB::beginTransaction();
            DB::table('users')->insert($data);
            DB::commit();
            return redirect()->route('persons.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('persons.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $users = DB::table('users')->where('id',$id)->first();
        return view('persons.edit-person',compact('users'));
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
        if($request->checktype == "new-pass"){
            try {
                DB::beginTransaction();
                DB::table('users')
                    ->where('id', $id)
                    ->update([
                        'password' => Hash::make($request->new_password)
                    ]);
                DB::commit();
                Auth::logout();
                return redirect('/login');
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }
        else if($request->checktype == "user-update"){
            $flag = $request->status;
            if ($flag == 'on' || $flag == 'true') {
                $flag = true;
            } else {
                $flag = false;
            }
            if($request->password){
                try {
                    DB::beginTransaction();
                    DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'employee_code' => $request->username,
                            'employee_fullname' => $request->name,
                            'email' => $request->email,
                            'status' => $flag,   
                            'person_at' => Auth::user()->name,
                            'updated_at'=> Carbon::now(),
                            'password' => Hash::make($request->password)
                        ]);
                    DB::commit();
                    return redirect()->route('persons.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
                } catch (\Exception $e) {
                    DB::rollback();
                    $message = $e->getMessage();
                    dd($message);
                    return redirect()->route('persons.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
                }     
            }
            else{
                try {
                    DB::beginTransaction();
                    DB::table('users')
                        ->where('id', $id)
                        ->update([
                            'employee_code' => $request->username,
                            'employee_fullname' => $request->name,
                            'email' => $request->email,
                            'status' => $flag,   
                            'person_at' => Auth::user()->name,
                            'updated_at'=> Carbon::now(),
                        ]);
                    DB::commit();
                    return redirect()->route('persons.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
                } catch (\Exception $e) {
                    DB::rollback();
                    $message = $e->getMessage();
                    dd($message);
                    return redirect()->route('persons.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
                }     
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
