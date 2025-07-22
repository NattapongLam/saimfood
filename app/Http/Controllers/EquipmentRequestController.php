<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EquipmentRequestDocu;
use Illuminate\Support\Facades\Auth;
use App\Models\EquipmentRequestStatus;

class EquipmentRequestController extends Controller
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
        $hd = EquipmentRequestDocu::leftjoin('equipment_request_statuses','equipment_request_docus.equipment_request_status_id','=','equipment_request_statuses.equipment_request_status_id')
        ->select('equipment_request_docus.*','equipment_request_statuses.equipment_request_status_name')
        ->get();
        return view('docu-equipment.list-equipmentrequest',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cust = Customer::where('customer_flag',true)->get();
        return view('docu-equipment.create-equipmentrequest',compact('cust'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $docs_last = DB::table('equipment_request_docus')
            ->where('equipment_request_docu_docuno', 'like', '%' . date('ym') . '%')
            ->orderBy('equipment_request_docu_id', 'desc')->first();
        if ($docs_last) {
            $docs = 'ETR' . date('ym')  . str_pad($docs_last->equipment_request_doc_docunum + 1, 4, '0', STR_PAD_LEFT);
            $docs_number = $docs_last->equipment_request_doc_docunum + 1;
        } else {
            $docs = 'ETR' . date('ym')  . str_pad(1, 4, '0', STR_PAD_LEFT);
            $docs_number = 1;
        }
        $request->validate([
            'customer_id' => 'required',
            'contact_person' => 'required',
            'contact_tel' => 'required',
            'customer_address' => 'required',
            'equipment_request_docu_duedate' => 'required',
            'equipment_request_doc_qty' => 'required',
            'equipment_request_docu_remark' => 'required',
        ]);
        $data = [
            'equipment_request_status_id' => 1,
            'customer_id' => $request->customer_id,
            'customer_fullname' => $request->customer_fullname,
            'customer_address' => $request->customer_address,
            'contact_person' => $request->contact_person,
            'contact_tel' => $request->contact_tel,
            'equipment_request_docu_date' => Carbon::now(),
            'equipment_request_docu_docuno' => $docs,
            'equipment_request_doc_docunum' => $docs_number,
            'equipment_request_docu_duedate' => $request->equipment_request_docu_duedate,
            'equipment_request_doc_qty' => $request->equipment_request_doc_qty,
            'equipment_request_docu_remark' => $request->equipment_request_docu_remark,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        try {
            DB::beginTransaction();
            EquipmentRequestDocu::create($data);
            DB::commit();
            return redirect()->route('equipment-request.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('equipment-request.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = EquipmentRequestDocu::find($id);
        $cust = Customer::where('customer_flag',true)->get();
        $sta = EquipmentRequestStatus::whereIn('equipment_request_status_id',[3,4,5])->get();
        return view('docu-equipment.approved-equipmentrequest',compact('cust','hd','sta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = EquipmentRequestDocu::find($id);
        $cust = Customer::where('customer_flag',true)->get();
        return view('docu-equipment.edit-equipmentrequest',compact('cust','hd'));
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
            'customer_id' => 'required',
            'contact_person' => 'required',
            'contact_tel' => 'required',
            'customer_address' => 'required',
            'equipment_request_docu_duedate' => 'required',
            'equipment_request_doc_qty' => 'required',
            'equipment_request_docu_remark' => 'required',
        ]);
        $data = [
            'equipment_request_status_id' => 1,
            'customer_id' => $request->customer_id,
            'customer_fullname' => $request->customer_fullname,
            'customer_address' => $request->customer_address,
            'contact_person' => $request->contact_person,
            'contact_tel' => $request->contact_tel,
            'equipment_request_docu_duedate' => $request->equipment_request_docu_duedate,
            'equipment_request_doc_qty' => $request->equipment_request_doc_qty,
            'equipment_request_docu_remark' => $request->equipment_request_docu_remark,
            'person_at' => Auth::user()->name,
            'updated_at' => Carbon::now(),
        ];
        try {
            DB::beginTransaction();
            EquipmentRequestDocu::where('equipment_request_docu_id',$id)->update($data);
            DB::commit();
            return redirect()->route('equipment-request.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('equipment-request.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
    public function updateApproved(Request $request, $id)
    {
        $data = [
            'equipment_request_status_id' => $request->equipment_request_status_id,
            'approved_remark' => $request->approved_remark,
            'approved_at' => Auth::user()->name,
            'approved_date' => Carbon::now(),
        ];
        try 
        {
            DB::beginTransaction();
            EquipmentRequestDocu::where('equipment_request_docu_id',$id)->update($data);
            DB::commit();
            return redirect()->route('equipment-request.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('equipment-request.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
        }      
    }

    public function confirmDelEquipmentRequest(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            EquipmentRequestDocu::where('equipment_request_docu_id',$id)->update([
                'equipment_request_status_id' => 2,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
            return redirect()->route('equipment-request.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
