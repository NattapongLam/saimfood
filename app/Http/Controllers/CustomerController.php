<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
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
        $cust = Customer::leftJoin('tg_employee_list', function($join) {
            $join->on(DB::raw("customers.salecode COLLATE Thai_CI_AS"), '=', DB::raw("tg_employee_list.PersonCode COLLATE Thai_CI_AS"));
        })->get();
        return view('setup-customer.list-customer',compact('cust'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $prov = DB::table('tg_province_list')->get();
        $sale = DB::table('tg_employee_list')->where('Cmb2ID',3)->get();
        return view('setup-customer.create-customer',compact('prov','sale'));
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
            'customer_code' => 'required',
            'customer_name' => 'required',
            'branch_type' => 'required',
            'branch_number' => 'required',
            'customer_province' => 'required',
            'contact_person' => 'required',
            'contact_tel' => 'required',
            'customer_address' => 'required'
        ]);
        $prov = DB::table('tg_province_list')->where('province_code',$request->customer_province)->first();
        $zone = DB::table('tg_zone_list')->where('zone_code',$prov->zone_code)->first();
        $data = [
            'customer_code' => $request->customer_code,
            'customer_name' => $request->customer_name,
            'customer_flag' => true,
            'customer_address' => $request->customer_address,
            'customer_province' => $prov->province_name,
            'customer_zone' => $zone->zone_name,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'contact_person' => $request->contact_person,
            'contact_tel' => $request->contact_tel,
            'branch_type' => $request->branch_type,
            'branch_name' => $request->branch_name,
            'branch_number' => $request->branch_number,
            'salecode' => $request->salecode
        ];
        try {
            DB::beginTransaction();
            Customer::create($data);
            DB::commit();
            return redirect()->route('customers.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('customers.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = Customer::where('customer_id',$id)->first();
        $prov = DB::table('tg_province_list')->get();
        $province = DB::table('tg_province_list')->where('province_name',$hd->customer_province)->first();
        $sale = DB::table('tg_employee_list')->where('Cmb2ID',3)->get();
        return view('setup-customer.edit-customer',compact('hd','prov','province','sale'));
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
            'customer_name' => 'required',
            'branch_type' => 'required',
            'branch_number' => 'required',
            'customer_province' => 'required',
            'contact_person' => 'required',
            'contact_tel' => 'required',
            'customer_address' => 'required'
        ]);
        $flag = $request->customer_flag;
        if ($flag == 'on' || $flag == 'true') {
            $flag = true;
        } else {
            $flag = false;
        }
        $prov = DB::table('tg_province_list')->where('province_code',$request->customer_province)->first();
        $zone = DB::table('tg_zone_list')->where('zone_code',$prov->zone_code)->first();
        $data = [
            'customer_name' => $request->customer_name,
            'customer_flag' => $flag,
            'customer_address' => $request->customer_address,
            'customer_province' => $prov->province_name,
            'customer_zone' => $zone->zone_name,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
            'contact_person' => $request->contact_person,
            'contact_tel' => $request->contact_tel,
            'branch_type' => $request->branch_type,
            'branch_name' => $request->branch_name,
            'branch_number' => $request->branch_number,
            'salecode' => $request->salecode
        ];
        try {
            DB::beginTransaction();
            Customer::where('customer_id',$id)->update($data);
            DB::commit();
            return redirect()->route('customers.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('customers.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
