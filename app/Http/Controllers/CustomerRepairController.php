<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\CustomerRepairDocu;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CustomerRepairController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $request->validate([
            'contact_person' => 'required',
            'contact_tel' => 'required',
            'customer_repair_docu_case' => 'required',
        ]);
        $docs_last = DB::table('customer_repair_docus')
            ->where('customer_repair_docu_docuno', 'like', '%' . date('ym') . '%')
            ->orderBy('customer_repair_docu_id', 'desc')->first();
        if ($docs_last) {
            $docs = 'CASE' . date('ym')  . str_pad($docs_last->customer_repair_docu_docunum + 1, 4, '0', STR_PAD_LEFT);
            $docs_number = $docs_last->customer_repair_docu_docunum + 1;
        } else {
            $docs = 'CASE' . date('ym')  . str_pad(1, 4, '0', STR_PAD_LEFT);
            $docs_number = 1;
        }
        $data = [
            'customer_repair_docu_docuno' => $docs,
            'customer_repair_docu_docunum' => $docs_number,
            'transfer_id' => $request->equipment_transfer_dt_id,
            'transfer_docuno' => $request->equipment_transfer_hd_docuno,
            'customer_id' => $request->customer_id,
            'customer_fullname' => $request->customer_fullname,
            'customer_address' => $request->customer_address,
            'contact_person' => $request->contact_person,
            'contact_tel' => $request->contact_tel,
            'equipment_id' => $request->equipment_id,
            'equipment_code' => $request->equipment_code,
            'equipment_name' => $request->equipment_name,
            'customer_repair_status_id' => 1,
            'customer_repair_docu_case' => $request->customer_repair_docu_case,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
        ];
        try {
            DB::beginTransaction();
            if($request->equipment_transfer_dt_id <> 0){
                DB::table('equipment_transfer_dts')
                ->where('equipment_transfer_dt_id',$request->equipment_transfer_dt_id)
                ->update([
                    'equipment_transfer_status_id' => 4
                ]);
            }
            DB::table('equipment')
                ->where('equipment_id',$request->equipment_id)
                ->update([
                    'equipment_status_id' => 4,
                ]);   
            CustomerRepairDocu::create($data);
            $token = "8218557050:AAF0MyGrfcML02FnKfldCnAozKlwtow1pX4";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4827861264";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 ลูกค้าแจ้งซ่อมเลขที่ : " . $docs ."\n"
                . "🔹 ลูกค้า  : ". $request->customer_fullname . "\n"
                . "🔹 ที่อยู่  : ". $request->customer_address . "\n"
                . "🔹 อาการ  : ". $request->customer_repair_docu_case . " (" . $request->equipment_name.")"."\n"
                . "📅 วันที่แจ้ง : " . date("d-m-Y",strtotime(Carbon::now())) . "\n"
                . "คลิก : " . "https://app.siamfood-beverage.com/equipment-repair" . "\n";
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);
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
        $dt = DB::table('equipment_transfer_dts')->where('equipment_transfer_dt_id',$id)->first();
        $hd = DB::table('equipment_transfer_hds')->where('equipment_transfer_hd_id',$dt->equipment_transfer_hd_id)->first();
        return view('create-customerrepair-docu',compact('dt','hd'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = Equipment::find($id);
        return view('docu-equipment.create-employeerepair-docu',compact('hd'));
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
