<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeList extends Controller
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
        $emp = DB::table('tg_employee_list')->get();
        return view('employees.list-employee',compact('emp'));
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
        $emp = DB::table('tg_employee_list')
        ->leftjoin('tg_province_list','tg_employee_list.CurrentProvince','=','tg_province_list.province_id')
        ->leftjoin('tg_amphur_list','tg_employee_list.CurrentAmphur','=','tg_amphur_list.amphur_id')
        ->leftjoin('tg_district_list','tg_employee_list.CurrentDistric','=','tg_district_list.district_id')
        ->select('tg_employee_list.*','tg_province_list.province_name as CurrentProvinceName','tg_amphur_list.amphur_name as CurrentAmphurName',
        'tg_district_list.district_name as CurrentDistricName')
        ->where('personcode',$id)
        ->first();
        return view('employees.show-employee',compact('emp'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
