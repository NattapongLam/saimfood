<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\EquipmentTransferDt;
use App\Models\EquipmentTransferHd;
use App\Models\CustomerTransferDocu;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\CustomerTransferStatus;

class CustomerTransfer extends Controller
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
            $hd = DB::table('customer_transfer_docus')
            ->leftjoin('customer_transfer_statuses','customer_transfer_docus.customer_transfer_status_id','=','customer_transfer_statuses.customer_transfer_status_id')
            ->leftjoin('equipment_transfer_dts','customer_transfer_docus.equipment_transfer_dt_id','=','equipment_transfer_dts.equipment_transfer_dt_id')
            ->leftjoin('equipment_transfer_hds','equipment_transfer_dts.equipment_transfer_hd_id','=','equipment_transfer_hds.equipment_transfer_hd_id')
            ->select('customer_transfer_docus.*','customer_transfer_statuses.customer_transfer_status_name','equipment_transfer_dts.equipment_code','equipment_transfer_dts.equipment_name','equipment_transfer_hds.customer_fullname as req_customer_fullname')
            ->get();
        } else {
            $hd = DB::table('customer_transfer_docus')
            ->leftjoin('customer_transfer_statuses','customer_transfer_docus.customer_transfer_status_id','=','customer_transfer_statuses.customer_transfer_status_id')
            ->leftjoin('equipment_transfer_dts','customer_transfer_docus.equipment_transfer_dt_id','=','equipment_transfer_dts.equipment_transfer_dt_id')
            ->leftjoin('equipment_transfer_hds','equipment_transfer_dts.equipment_transfer_hd_id','=','equipment_transfer_hds.equipment_transfer_hd_id')
            ->leftjoin('customers','customer_transfer_docus.customer_id','=','customers.customer_id')
            ->where('customers.salecode',$user->username)
            ->select('customer_transfer_docus.*','customer_transfer_statuses.customer_transfer_status_name','equipment_transfer_dts.equipment_code','equipment_transfer_dts.equipment_name','equipment_transfer_hds.customer_fullname as req_customer_fullname')
            ->get();
        }
       
        return view('docu-equipment.list-customertransfer',compact('hd'));
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
        } else {
            $cust = Customer::where('customer_flag',true)
            ->where('salecode',$user->username)
            ->get();
            $equipments = DB::table('equipment_transfer_hds')
            ->join('equipment_transfer_dts', 'equipment_transfer_hds.equipment_transfer_hd_id', '=', 'equipment_transfer_dts.equipment_transfer_hd_id')
            ->join('customers','equipment_transfer_hds.customer_id','=','customers.customer_id')
            ->where('equipment_transfer_hds.equipment_transfer_status_id', 2)
            ->where('equipment_transfer_dts.equipment_transfer_status_id', 2)
            ->where('customers.salecode',$user->username)
            ->select(
                'equipment_transfer_hds.customer_fullname',
                'equipment_transfer_hds.customer_address',
                'equipment_transfer_dts.*'
            )
            ->get();
        }
        
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
        $request->validate([
            'customer_id' => 'required',
            'equipment_transfer_dt_id' => 'required',
            'contact_person' => 'required',
            'contact_tel' => 'required',
            'customer_address' => 'required',
        ]);
        $data = [
            'customer_transfer_status_id' => 1,
            'customer_id' => $request->customer_id,
            'customer_fullname' => $request->customer_fullname,
            'customer_address' => $request->customer_address,
            'contact_person' => $request->contact_person,
            'contact_tel' => $request->contact_tel,
            'equipment_transfer_dt_id' => $request->equipment_transfer_dt_id,
            'person_at' => Auth::user()->name,
            'person_remark' => $request->person_remark,
            'created_at' =>  Carbon::now(),
        ];
        try 
        {
            DB::beginTransaction();
            CustomerTransferDocu::create($data);  
            $equi = EquipmentTransferDt::find($request->equipment_transfer_dt_id);
            $cust = EquipmentTransferHd::find($equi->equipment_transfer_hd_id);
            $token = "8218557050:AAF0MyGrfcML02FnKfldCnAozKlwtow1pX4";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4827861264";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 ใบขอย้ายอุปกรณ์ลูกค้า"."\n"
                . "🔹 ลูกค้าปลายทาง  : ". $request->customer_fullname . "\n"
                . "🔹 รายละเอียด  : ". $request->person_remark . "\n"
                . "🔹 อุปกรณ์ที่ย้าย  : ". $equi->equipment_code." " .$equi->equipment_name . " (" . $cust->customer_fullname .")"."\n"
                . "📅 วันที่ร้องขอ : " . date("d-m-Y",strtotime(Carbon::now())) . "\n"
                . "👤 ผู้แจ้ง : " . Auth::user()->name . "\n"
                . "คลิก : " . "https://app.siamfood-beverage.com/customer-transfer" . "\n";
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId); 
            DB::commit();
            return redirect()->route('customer-transfer.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('customer-transfer.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = CustomerTransferDocu::find($id);
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
        $sta = CustomerTransferStatus::get();
        $ck = EquipmentTransferHd::where('customer_id',$hd->customer_id)->orderBy('equipment_transfer_hd_id','desc')->first();
        return view('docu-equipment.update-customertransfer',compact('hd','cust','equipments','sta','ck'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = CustomerTransferDocu::find($id);
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
        $sta = CustomerTransferStatus::get();
        return view('docu-equipment.edit-customertransfer',compact('hd','cust','equipments','sta'));
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
        $ck = DB::table('customer_transfer_docus')->where('customer_transfer_docu_id',$id)->first();
        if($ck->customer_transfer_status_id == 1){
            $request->validate([
            'customer_id' => 'required',
            'equipment_transfer_dt_id' => 'required',
            'contact_person' => 'required',
            'contact_tel' => 'required',
            'customer_address' => 'required',
            'customer_transfer_status_id' => 'required',
            ]);
            $data = [
                'customer_transfer_status_id' => $request->customer_transfer_status_id,
                'customer_id' => $request->customer_id,
                'customer_fullname' => $request->customer_fullname,
                'customer_address' => $request->customer_address,
                'contact_person' => $request->contact_person,
                'contact_tel' => $request->contact_tel,
                'equipment_transfer_dt_id' => $request->equipment_transfer_dt_id,
                'approved_at' => Auth::user()->name,
                'approved_remark' => $request->approved_remark,
                'approved_date' =>  Carbon::now(),
            ];
            try 
            {
                DB::beginTransaction();
                CustomerTransferDocu::where('customer_transfer_docu_id',$id)->update($data);
                $equi = EquipmentTransferDt::find($request->equipment_transfer_dt_id);
                $cust = EquipmentTransferHd::find($equi->equipment_transfer_hd_id);
                $sat = CustomerTransferStatus::find($request->customer_transfer_status_id);
                $token = "8218557050:AAF0MyGrfcML02FnKfldCnAozKlwtow1pX4";  // 🔹 ใส่ Token ที่ได้จาก BotFather
                $chatId = "-4827861264";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
                $message = "📢 ใบขอย้ายอุปกรณ์ลูกค้า"."\n"
                    . "🔹 ลูกค้าปลายทาง  : ". $request->customer_fullname . "\n"
                    . "🔹 รายละเอียด  : ". $request->person_remark . "\n"
                    . "🔹 อุปกรณ์ที่ย้าย  : ". $equi->equipment_code." " .$equi->equipment_name . " (" . $cust->customer_fullname .")"."\n"
                    . "📅 วันที่" .$sat->customer_transfer_status_name." : " . date("d-m-Y",strtotime(Carbon::now())) . "\n"
                    . "👤 ผู้".$sat->customer_transfer_status_name. " : " . Auth::user()->name . "\n"
                    . "🔹 หมายเหตุ  : ". $request->approved_remark . "\n"
                    . "คลิก : " . "https://app.siamfood-beverage.com/customer-transfer" . "\n";
                // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
                $this->notifyTelegram($message, $token, $chatId);    
                DB::commit();
                return redirect()->route('customer-transfer.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('customer-transfer.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }  
        }else{
            $request->validate([
                'customer_id' => 'required',
                'equipment_transfer_dt_id' => 'required',
            ]);          
            $data = [
                'customer_transfer_status_id' => 4,
                'receive_at' => Auth::user()->name,
                'receive_remark' => $request->receive_remark,
                'receive_date' =>  Carbon::now(),
            ];
            if ($request->hasFile('receive_img') && $request->file('receive_img')->isValid()) {
                $filename = "CTF-" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('receive_img')->getClientOriginalExtension();
                $request->file('receive_img')->storeAs('customer_transfer_img', $filename, 'public');
                $data['receive_img'] = 'storage/customer_transfer_img/' . $filename;
            }
            try {
                DB::beginTransaction();
                CustomerTransferDocu::where('customer_transfer_docu_id',$id)->update($data);
                EquipmentTransferDt::where('equipment_transfer_dt_id',$request->equipment_transfer_dt_id)
                ->update([
                    'equipment_transfer_hd_id' => $request->equipment_transfer_hd_id
                ]);
                DB::commit();
                return redirect()->route('customer-transfer.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('customer-transfer.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
