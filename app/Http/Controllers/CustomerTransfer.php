<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerTransfer extends Controller
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
        return view('docu-equipment.list-customertransfer');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust = Customer::where('customer_flag',true)->get();
        $equipments = DB::table('equipment_transfer_hds')
        ->join('equipment_transfer_dts', 'equipment_transfer_hds.equipment_transfer_hd_id', '=', 'equipment_transfer_dts.equipment_transfer_hd_id')
        ->where('equipment_transfer_hds.equipment_transfer_status_id', 2)
        ->where('equipment_transfer_dts.equipment_transfer_status_id', 2)
        ->select(
            'equipment_transfer_hds.customer_fullname',
            'equipment_transfer_hds.customer_address',
            'equipment_transfer_dts.*'
        )
        ->get();
        return view('docu-equipment.create-customertransfer',compact('cust','equipments'));
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
