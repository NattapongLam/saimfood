<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $users = User::findOrFail($id);
        $roles = Role::all();
        $permissions = Permission::all();
        return view('persons.permission-person',compact('users','roles','permissions'));
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
            'role' => 'required',
        ]);
        $users = User::findOrFail($id);
        $role = Role::where('name',$request->role)->first();
        try{
            DB::beginTransaction();
            $users->syncRoles($role->name);
            if (is_array($request->permission) && count($request->permission)) {
                $permissions = Permission::whereIn('id', $request->permission)->pluck('name')->toArray();
                $users->syncPermissions($permissions);
            }
            DB::commit();
            return redirect()->back()->with('success', 'บันทึกข้อมูลสำเร็จ');
        }catch(\Exception $e){
            DB::rollBack();
            $message = $e->getMessage();
            dd($message);
            return redirect()->back()->with('error', 'บันทึกข้อมูลไม่สำเร็จ');            
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
