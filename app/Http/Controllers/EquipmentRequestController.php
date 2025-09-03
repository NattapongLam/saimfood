<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EquipmentRequestDocu;
use Illuminate\Support\Facades\Auth;
use App\Models\EquipmentRequestStatus;
use Illuminate\Support\Facades\Http;

class EquipmentRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    private function notifyTelegram($message, $token, $chatId)
    {
        $queryData = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $response = file_get_contents($url . "?" . http_build_query($queryData));
        return json_decode($response);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            $hd = EquipmentRequestDocu::leftjoin('equipment_request_statuses','equipment_request_docus.equipment_request_status_id','=','equipment_request_statuses.equipment_request_status_id')
                    ->select('equipment_request_docus.*','equipment_request_statuses.equipment_request_status_name')
                    ->get();
        } else {
            $hd = EquipmentRequestDocu::leftjoin('equipment_request_statuses','equipment_request_docus.equipment_request_status_id','=','equipment_request_statuses.equipment_request_status_id')
                    ->where('equipment_request_docus.person_at',$user->name)
                    ->select('equipment_request_docus.*','equipment_request_statuses.equipment_request_status_name')
                    ->get();
        }   
        return view('docu-equipment.list-equipmentrequest',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->hasAnyRole(['superadmin', 'admin'])) {
            $cust = Customer::where('customer_flag',true)->get();
        } else {
            $cust = Customer::where('customer_flag',true)
            ->where('salecode',$user->username)
            ->get();
        }       
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
            $token = "8218557050:AAF0MyGrfcML02FnKfldCnAozKlwtow1pX4";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4827861264";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 ใบร้องขออุปกรณ์เลขที่ : " . $docs  ."\n"
                . "🔹 ลูกค้า  : ". $request->customer_fullname . "\n"
                . "🔹 รายละเอียด  : ". $request->equipment_request_docu_remark . " จำนวน : " . $request->equipment_request_doc_qty . "\n"
                . "📅 วันที่ร้องขอ : " . date("d-m-Y",strtotime(Carbon::now())) . "\n"
                . "📅 วันที่ต้องการให้จัดส่ง : " . date("d-m-Y",strtotime($request->equipment_request_docu_duedate)). "\n"
                . "👤 ผู้แจ้ง : " . Auth::user()->name . "\n"
                . "คลิก : " . "https://app.siamfood-beverage.com/equipment-request" . "\n";
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);  
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
            $hd = EquipmentRequestDocu::find($id);
            $sat = EquipmentRequestStatus::find($hd->equipment_request_status_id);
            $token = "8218557050:AAF0MyGrfcML02FnKfldCnAozKlwtow1pX4";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4827861264";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 ใบร้องขออุปกรณ์เลขที่ : " . $hd->equipment_request_docu_docuno  ."\n"
                . "🔹 ลูกค้า  : ". $hd->customer_fullname . "\n"
                . "🔹 รายละเอียด  : ". $hd->equipment_request_docu_remark . " จำนวน : " . $hd->equipment_request_doc_qty . "\n"
                . "📅 ". $sat->equipment_request_status_name. "วันที่ : " . date("d-m-Y",strtotime(Carbon::now())) . "\n"
                . "📅 วันที่ต้องการให้จัดส่ง : " . date("d-m-Y",strtotime($request->equipment_request_docu_duedate)). "\n"
                . "👤 ผู้". $sat->equipment_request_status_name. " : " . Auth::user()->name . "\n"
                . "🔹 หมายเหตุ  : ". $request->approved_remark . "\n"
                . "คลิก : " . "https://app.siamfood-beverage.com/equipment-request" . "\n";
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);  
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
