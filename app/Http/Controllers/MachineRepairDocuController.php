<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Machine;
use Illuminate\Support\Str;
use App\Models\MachineGroup;
use Illuminate\Http\Request;
use App\Models\MachineRepairDocdt;
use App\Models\MachineRepairDochd;
use Illuminate\Support\Facades\DB;
use App\Models\MachineRepairStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MachineRepairDocuController extends Controller
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
    public function index(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-2 month", strtotime($dateend)));
        $hd = MachineRepairDochd::leftjoin('machine_repair_statuses','machine_repair_dochds.machine_repair_status_id','=','machine_repair_statuses.machine_repair_status_id')
        ->leftjoin('machines','machine_repair_dochds.machine_code','=','machines.machine_code')
        ->whereBetween('machine_repair_dochds.machine_repair_dochd_date', [$datestart, $dateend])
        ->where('machine_repair_dochds.docutype', 'R')
        ->select('machine_repair_dochds.*','machines.machine_name','machines.machine_pic1','machine_repair_statuses.machine_repair_status_name')
        ->get();
        return view('docu-machine.list-machinerepair-docu',compact('hd','dateend','datestart'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $machine = Machine::where('machine_flag',true)->get();
        $machinegroup = MachineGroup::where('machinegroup_flag',true)->get();
        return view('docu-machine.create-machinerepair-docu',compact('machine','machinegroup'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $docs_last = DB::table('machine_repair_dochds')
            ->where('machine_repair_dochd_docuno', 'like', '%' . date('ym') . '%')
            ->orderBy('machine_repair_dochd_id', 'desc')->first();
        if ($docs_last) {
            $docs = 'MTN' . date('ym')  . str_pad($docs_last->machine_repair_dochd_docunum + 1, 4, '0', STR_PAD_LEFT);
            $docs_number = $docs_last->machine_repair_dochd_docunum + 1;
        } else {
            $docs = 'MTN' . date('ym')  . str_pad(1, 4, '0', STR_PAD_LEFT);
            $docs_number = 1;
        }
        $request->validate([
            'machine_repair_dochd_date' => 'required',
            'machine_repair_dochd_type' => 'required',
            'machine_code' => 'required',
            'machine_repair_dochd_location' => 'required',
            'machine_repair_dochd_case' => 'required',
            'machine_repair_dochd_duedate' => 'required',
        ]);
        $data = [
            'machine_repair_dochd_date' => $request->machine_repair_dochd_date,
            'machine_code' => $request->machine_code,
            'machine_repair_dochd_type' => $request->machine_repair_dochd_type,
            'machine_repair_dochd_case' => $request->machine_repair_dochd_case,           
            'machine_repair_dochd_location' => $request->machine_repair_dochd_location,
            'machine_repair_status_id' => 1,
            'person_at' => Auth::user()->name,
            'created_at'=> Carbon::now(),
            'updated_at'=> Carbon::now(),
            'machine_repair_dochd_datetime' => Carbon::now(),
            'machine_repair_dochd_docuno' => $docs,
            'machine_repair_dochd_docunum' => $docs_number,
            'machine_repair_dochd_duedate' => $request->machine_repair_dochd_duedate,
            'docutype' => "R",
            'machine_repair_dochd_part' => $request->machine_repair_dochd_part
        ]; 
        try 
        {
            DB::beginTransaction();
            MachineRepairDochd::create($data);
            $mc = Machine::where('machine_code',$request->machine_code)->first();
            $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4871539820";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 แจ้งซ่อมเลขที่ : " . $docs . " เครื่อง : " .  $mc->machine_code ."/". $mc->machine_name  ."\n"
                . "🔹 ชิ้นส่วน  : ". $request->machine_repair_dochd_part . "\n"
                . "🔹 รายละเอียด  : ". $request->machine_repair_dochd_case . "\n"
                . "📅 วันที่แจ้ง : " . date("d-m-Y",strtotime($request->machine_repair_dochd_date)) . "\n"
                . "📅 วันที่ต้องการให้เสร็จ : " . date("d-m-Y",strtotime($request->machine_repair_dochd_duedate)). "\n"
                . "👤 ผู้แจ้ง : " . Auth::user()->name . "\n"
                . "คลิก : " . "https://app.siamfood-beverage.com/machine-repair-docus" . "\n";
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);    
            DB::commit();
            return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = MachineRepairDochd::leftjoin('machine_repair_statuses','machine_repair_dochds.machine_repair_status_id','=','machine_repair_statuses.machine_repair_status_id')
        ->find($id);      
        $machine = Machine::where('machine_flag',true)->get();
        return view('docu-machine.safety-machinerepair-docu',compact('hd','machine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = MachineRepairDochd::leftjoin('machine_repair_statuses','machine_repair_dochds.machine_repair_status_id','=','machine_repair_statuses.machine_repair_status_id')
        ->find($id);      
        $machine = Machine::where('machine_flag',true)->get();
        $status = MachineRepairStatus::whereIn('machine_repair_status_id',[3,8,9])->get();
        $stc = DB::table('vw_stc_stockcard')->get();
        return view('docu-machine.edit-machinerepair-docu',compact('hd','machine','status','stc'));
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
        $ck = MachineRepairDochd::where('machine_repair_dochd_id',$id)->first();
        if($ck->machine_repair_status_id == 1 || $ck->machine_repair_status_id == 9){
            $request->validate([
                'accepting_note' => 'required',
            ]);            
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'machine_repair_dochd_type' => $request->machine_repair_dochd_type,
                    'machine_repair_dochd_case' => $request->machine_repair_dochd_case,
                    'machine_repair_dochd_location' => $request->machine_repair_dochd_location,
                    'machine_repair_dochd_duedate' => $request->machine_repair_dochd_duedate,
                    'machine_repair_status_id' => 2,
                    'accepting_at' => Auth::user()->name,
                    'accepting_date' =>  Carbon::now(),
                    'accepting_note' => $request->accepting_note,
                    'accepting_duedate' => $request->accepting_duedate,
                    'machine_repair_dochd_part' => $request->machine_repair_dochd_part,
                    'accepting_datetime' => Carbon::parse($request->accepting_datetime)->format('Y-m-d H:i:s'),
                ]);
                $listnos = $request->machine_repair_docdt_listno ?? [];
                $ids = $request->machine_repair_docdt_id ?? [];
                foreach ($listnos as $key => $listno) {
                    $docdtId = $ids[$key] ?? null;
                    $cost = str_replace(',', '', $request->machine_repair_docdt_cost[$key]);
                    $flag = $request->machine_repair_docdt_flag[$key] ?? false;
                    $flag = $flag == 'on' || $flag == 'true' ? true : false;
                    $filePath = null;
                    if ($request->hasFile('machine_repair_docdt_file') && $request->file('machine_repair_docdt_file')[$key] ?? false) {
                        $file = $request->file('machine_repair_docdt_file')[$key];
                        if ($file->isValid()) {
                            $filename = "MTN_FILE_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
                            $file->storeAs('machine_repair_img', $filename, 'public');
                            $filePath = 'storage/machine_repair_img/' . $filename;
                        }
                    }
                    if ($docdtId) {
                        MachineRepairDocdt::where('machine_repair_docdt_id', $docdtId)
                            ->update([
                                'machine_repair_docdt_listno' => $listno,
                                'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                                'machine_repair_docdt_cost' => $cost,
                                'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                                'machine_repair_docdt_flag' => $flag,
                                'person_at' => Auth::user()->name,
                                'updated_at' => Carbon::now(),
                                'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                                'machine_repair_docdt_file' => $filePath,
                                'machine_repair_docdt_code' => $request->machine_repair_docdt_code[$key],
                                'machine_repair_docdt_unit' => $request->machine_repair_docdt_unit[$key],
                                'machine_repair_docdt_qty' => $request->machine_repair_docdt_qty[$key],
                                'machine_repair_docdt_price' => $request->machine_repair_docdt_price[$key],
                                'poststock' => "N"
                            ]);
                    } else {
                        MachineRepairDocdt::create([
                            'machine_repair_dochd_id' => $ck->machine_repair_dochd_id,
                            'machine_repair_docdt_listno' => $listno,
                            'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                            'machine_repair_docdt_cost' => $cost,
                            'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                            'machine_repair_docdt_flag' => true,
                            'person_at' => Auth::user()->name,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                            'machine_repair_docdt_file' => $filePath,
                            'machine_repair_docdt_code' => $request->machine_repair_docdt_code[$key],
                            'machine_repair_docdt_unit' => $request->machine_repair_docdt_unit[$key],
                            'machine_repair_docdt_qty' => $request->machine_repair_docdt_qty[$key],
                            'machine_repair_docdt_price' => $request->machine_repair_docdt_price[$key],
                            'poststock' => "N"
                        ]);
                    }
                }
                DB::commit();
                $mc = Machine::where('machine_code',$ck->machine_code)->first();
                $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // 🔹 ใส่ Token ที่ได้จาก BotFather
                $chatId = "-4871539820";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
                $message = "📢 รับงานซ่อมเลขที่ : " . $ck->machine_repair_dochd_docuno . " เครื่อง : " .  $mc->machine_code ."/". $mc->machine_name  ."\n"
                    . "🔹 ชิ้นส่วน  : ". $ck->machine_repair_dochd_part . "\n"
                    . "🔹 รายละเอียด  : ". $ck->machine_repair_dochd_case . "\n"
                    . "📅 วันที่จะซ่อมเสร็จ : " . date("d-m-Y",strtotime($request->accepting_duedate)). "\n"
                    . "👤 ผู้รับงานซ่อม : " . Auth::user()->name . "\n"
                    . "คลิก : " . "https://app.siamfood-beverage.com/machine-repair-docus" . "\n";
                // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
                $this->notifyTelegram($message, $token, $chatId); 
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }  
        }else if($ck->machine_repair_status_id == 2){
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'machine_repair_status_id' => $request->machine_repair_status_id,
                    'approval_at' => Auth::user()->name,
                    'approval_date' =>  Carbon::now(),
                    'approval_note' => $request->approval_note
                ]);
                DB::commit();
                $mc = Machine::where('machine_code',$ck->machine_code)->first();
                $sta = MachineRepairStatus::where('machine_repair_status_id',$request->machine_repair_status_id)->first();
                $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // 🔹 ใส่ Token ที่ได้จาก BotFather
                $chatId = "-4871539820";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
                $message = "📢 ".$sta->machine_repair_status_name. "เลขที่ : " . $ck->machine_repair_dochd_docuno . " เครื่อง : " .  $mc->machine_code ."/". $mc->machine_name  ."\n"
                    . "🔹 ชิ้นส่วน  : ". $ck->machine_repair_dochd_part . "\n"
                    . "🔹 รายละเอียด  : ". $ck->machine_repair_dochd_case . "\n"
                    . "🔹 หมายเหตุ  : ". $request->approval_note . "\n"
                    . "👤 ผู้มีอำนาจ : " . Auth::user()->name . "\n"
                    . "คลิก : " . "https://app.siamfood-beverage.com/machine-repair-docus" . "\n";
                // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
                $this->notifyTelegram($message, $token, $chatId); 
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }  
        }else if($ck->machine_repair_status_id == 3){
            $request->validate([
                'accepting_note' => 'required',
                'repairer_datetime' => 'required',
            ]);
            $datetime = \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $request->repairer_datetime);
            $data = [
                'machine_repair_status_id' => 4,
                'repairer_at' => Auth::user()->name,
                'repairer_date' =>  $datetime->format('Y-m-d'),
                'repairer_note' => $request->repairer_note,
                'repairer_datetime' => $datetime,
                'repairer_type' => $request->repairer_type,
                'repairer_problem' => $request->repairer_problem,
            ];
            if ($request->hasFile('repairer_pic1') && $request->file('repairer_pic1')->isValid()) {
                $filename = "MTN_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('repairer_pic1')->getClientOriginalExtension();
                $request->file('repairer_pic1')->storeAs('machine_repair_img', $filename, 'public');
                $data['repairer_pic1'] = 'storage/machine_repair_img/' . $filename;
            }
            if ($request->hasFile('repairer_pic2') && $request->file('repairer_pic2')->isValid()) {
                $filename = "MTN_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('repairer_pic2')->getClientOriginalExtension();
                $request->file('repairer_pic2')->storeAs('machine_repair_img', $filename, 'public');
                $data['repairer_pic2'] = 'storage/machine_repair_img/' . $filename;
            }  
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)->update($data);
                $mc = Machine::where('machine_code',$ck->machine_code)->update([
                    'last_repair' => $datetime->format('Y-m-d'),
                ]);
                $listnos = $request->machine_repair_docdt_listno ?? [];
                $ids = $request->machine_repair_docdt_id ?? [];
                foreach ($listnos as $key => $listno) {
                    $docdtId = $ids[$key] ?? null;
                    $cost = str_replace(',', '', $request->machine_repair_docdt_cost[$key]);
                    $flag = $request->machine_repair_docdt_flag[$key] ?? false;
                    $flag = $flag == 'on' || $flag == 'true' ? true : false;
                    $filePath = null;
                    if ($request->hasFile('machine_repair_docdt_file') && $request->file('machine_repair_docdt_file')[$key] ?? false) {
                        $file = $request->file('machine_repair_docdt_file')[$key];
                        if ($file->isValid()) {
                            $filename = "MTN_FILE_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
                            $file->storeAs('machine_repair_img', $filename, 'public');
                            $filePath = 'storage/machine_repair_img/' . $filename;
                        }
                    }
                    if ($docdtId) {
                        MachineRepairDocdt::where('machine_repair_docdt_id', $docdtId)
                            ->update([
                                'machine_repair_docdt_listno' => $listno,
                                'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                                'machine_repair_docdt_cost' => $cost,
                                'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                                'machine_repair_docdt_flag' => $flag,
                                'person_at' => Auth::user()->name,
                                'updated_at' => Carbon::now(),
                                'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                                'machine_repair_docdt_file' => $filePath,
                                'machine_repair_docdt_code' => $request->machine_repair_docdt_code[$key],
                                'machine_repair_docdt_unit' => $request->machine_repair_docdt_unit[$key],
                                'machine_repair_docdt_qty' => $request->machine_repair_docdt_qty[$key],
                                'machine_repair_docdt_price' => $request->machine_repair_docdt_price[$key],
                                'poststock' => "N"
                            ]);
                    } else {
                        MachineRepairDocdt::create([
                            'machine_repair_dochd_id' => $ck->machine_repair_dochd_id,
                            'machine_repair_docdt_listno' => $listno,
                            'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                            'machine_repair_docdt_cost' => $cost,
                            'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                            'machine_repair_docdt_flag' => true,
                            'person_at' => Auth::user()->name,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                            'machine_repair_docdt_file' => $filePath,
                            'machine_repair_docdt_code' => $request->machine_repair_docdt_code[$key],
                            'machine_repair_docdt_unit' => $request->machine_repair_docdt_unit[$key],
                            'machine_repair_docdt_qty' => $request->machine_repair_docdt_qty[$key],
                            'machine_repair_docdt_price' => $request->machine_repair_docdt_price[$key],
                            'poststock' => "N"
                        ]);
                    }
                }
                DB::commit();
                $mc = Machine::where('machine_code',$ck->machine_code)->first();
                $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // 🔹 ใส่ Token ที่ได้จาก BotFather
                $chatId = "-4871539820";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
                $message = "📢 ผลการซ่อมเลขที่ : " . $ck->machine_repair_dochd_docuno . " เครื่อง : " .  $mc->machine_code ."/". $mc->machine_name  ."\n"
                    . "🔹 ชิ้นส่วน  : ". $ck->machine_repair_dochd_part . "\n"
                    . "🔹 อาการ  : ". $ck->machine_repair_dochd_case . "\n"
                    . "🔹 รายละเอียดการซ่อม  : ".  $request->repairer_note . "\n"
                    . "👤 ผู้ซ่อม : " . Auth::user()->name . "\n"
                    . "คลิก : " . "https://app.siamfood-beverage.com/machine-repair-docus" . "\n";
                // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
                $this->notifyTelegram($message, $token, $chatId); 
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            }   
        }else if($ck->machine_repair_status_id == 4){
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'machine_repair_status_id' => 5,
                    'inspector_at' => Auth::user()->name,
                    'inspector_date' =>  Carbon::now(),
                    'inspector_note' => $request->inspector_note
                ]);
                DB::commit();
                $mc = Machine::where('machine_code',$ck->machine_code)->first();
                $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // 🔹 ใส่ Token ที่ได้จาก BotFather
                $chatId = "-4871539820";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
                $message = "📢 ตรวจสอบงานซ่อมเลขที่ : " . $ck->machine_repair_dochd_docuno . " เครื่อง : " .  $mc->machine_code ."/". $mc->machine_name  ."\n"
                    . "🔹 ชิ้นส่วน  : ". $ck->machine_repair_dochd_part . "\n"
                    . "🔹 อาการ  : ". $ck->machine_repair_dochd_case . "\n"
                    . "🔹 รายละเอียดการซ่อม  : ".  $ck->repairer_note . "\n"
                    . "👤 ผู้ตรวจสอบ : " . Auth::user()->name . "\n"
                    . "คลิก : " . "https://app.siamfood-beverage.com/machine-repair-docus" . "\n";
                // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
                $this->notifyTelegram($message, $token, $chatId); 
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            } 
        }else if($ck->machine_repair_status_id == 5){ 
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'machine_repair_status_id' => 6,
                    'closing_at' => Auth::user()->name,
                    'closing_date' =>  Carbon::now(),
                    'closing_note' => $request->closing_note
                ]);
                DB::commit();
                $mc = Machine::where('machine_code',$ck->machine_code)->first();
                $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // 🔹 ใส่ Token ที่ได้จาก BotFather
                $chatId = "-4871539820";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
                $message = "📢 ปิดงานซ่อมเลขที่ : " . $ck->machine_repair_dochd_docuno  . " เครื่อง : " .  $mc->machine_code ."/". $mc->machine_name  ."\n"
                    . "🔹 ชิ้นส่วน  : ". $ck->machine_repair_dochd_part . "\n"
                    . "🔹 อาการ  : ". $ck->machine_repair_dochd_case . "\n"
                    . "🔹 รายละเอียดการซ่อม  : ".  $ck->repairer_note . "\n"
                    . "👤 ผู้ปิดงาน : " . Auth::user()->name . "\n"
                    . "คลิก : " . "https://app.siamfood-beverage.com/machine-repair-docus" . "\n";
                // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
                $this->notifyTelegram($message, $token, $chatId); 
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            } 
       }else if($ck->machine_repair_status_id == 6){ 
            try 
            {
                DB::beginTransaction();
                MachineRepairDochd::where('machine_repair_dochd_id',$id)
                ->update([
                    'updated_at' => Carbon::now(),
                ]);
                $listnos = $request->machine_repair_docdt_listno ?? [];
                $ids = $request->machine_repair_docdt_id ?? [];
                foreach ($listnos as $key => $listno) {
                    $docdtId = $ids[$key] ?? null;
                    $cost = str_replace(',', '', $request->machine_repair_docdt_cost[$key]);
                    $flag = $request->machine_repair_docdt_flag[$key] ?? false;
                    $flag = $flag == 'on' || $flag == 'true' ? true : false;
                    $filePath = null;
                    if ($request->hasFile('machine_repair_docdt_file') && $request->file('machine_repair_docdt_file')[$key] ?? false) {
                        $file = $request->file('machine_repair_docdt_file')[$key];
                        if ($file->isValid()) {
                            $filename = "MTN_FILE_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $file->getClientOriginalExtension();
                            $file->storeAs('machine_repair_img', $filename, 'public');
                            $filePath = 'storage/machine_repair_img/' . $filename;
                        }
                    }
                    if ($docdtId) {
                        MachineRepairDocdt::where('machine_repair_docdt_id', $docdtId)
                            ->update([
                                'machine_repair_docdt_listno' => $listno,
                                'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                                'machine_repair_docdt_cost' => $cost,
                                'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                                'machine_repair_docdt_flag' => $flag,
                                'person_at' => Auth::user()->name,
                                'updated_at' => Carbon::now(),
                                'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                                'machine_repair_docdt_file' => $filePath,
                                'machine_repair_docdt_code' => $request->machine_repair_docdt_code[$key],
                                'machine_repair_docdt_unit' => $request->machine_repair_docdt_unit[$key],
                                'machine_repair_docdt_qty' => $request->machine_repair_docdt_qty[$key],
                                'machine_repair_docdt_price' => $request->machine_repair_docdt_price[$key],
                                'poststock' => "N"
                            ]);
                    } else {
                        MachineRepairDocdt::create([
                            'machine_repair_dochd_id' => $ck->machine_repair_dochd_id,
                            'machine_repair_docdt_listno' => $listno,
                            'machine_repair_docdt_remark' => $request->machine_repair_docdt_remark[$key],
                            'machine_repair_docdt_cost' => $cost,
                            'machine_repair_docdt_note' => $request->machine_repair_docdt_note[$key],
                            'machine_repair_docdt_flag' => true,
                            'person_at' => Auth::user()->name,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                            'machine_repair_docdt_vendor' => $request->machine_repair_docdt_vendor[$key] ?? null,
                            'machine_repair_docdt_file' => $filePath,
                            'machine_repair_docdt_code' => $request->machine_repair_docdt_code[$key],
                            'machine_repair_docdt_unit' => $request->machine_repair_docdt_unit[$key],
                            'machine_repair_docdt_qty' => $request->machine_repair_docdt_qty[$key],
                            'machine_repair_docdt_price' => $request->machine_repair_docdt_price[$key],
                            'poststock' => "N"
                        ]);
                    }
                }
                DB::commit();
                return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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

    public function confirmDelMachineRepairHd(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            MachineRepairDochd::where('machine_repair_dochd_id',$id)->update([
                'machine_repair_status_id' => 7,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function confirmDelMachineRepairDt(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            MachineRepairDocdt::where('machine_repair_docdt_id',$id)->update([
                'machine_repair_docdt_flag' => false,
                'person_at' => Auth::user()->name,
                'updated_at'=> Carbon::now(),
            ]);
            DB::commit();
            return response()->json([
                'status' => true,
                'message' => 'ยกเลิกรายการเรียบร้อยแล้ว'
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
    public function updateSafety(Request $request, $id)
    {
        $data = [
            'safety_type' => $request->safety_type,
            'safety_ppe' => $request->safety_ppe,
            'safety_note' => $request->safety_note,
            'safety_at' => Auth::user()->name,
            'safety_date' => Carbon::now(),
        ];

        if ($request->hasFile('safety_pic1') && $request->file('safety_pic1')->isValid()) {
            $filename = "SAFETY1_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('safety_pic1')->getClientOriginalExtension();
            $request->file('safety_pic1')->storeAs('machine_repair_img', $filename, 'public');
            $data['safety_pic1'] = 'storage/machine_repair_img/' . $filename;
        }

        if ($request->hasFile('safety_pic2') && $request->file('safety_pic2')->isValid()) {
            $filename = "SAFETY2_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('safety_pic2')->getClientOriginalExtension();
            $request->file('safety_pic2')->storeAs('machine_repair_img', $filename, 'public');
            $data['safety_pic2'] = 'storage/machine_repair_img/' . $filename;
        }
        try
        {
            DB::beginTransaction();
            MachineRepairDochd::where('machine_repair_dochd_id', $id)->update($data);
            DB::commit();
            return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
        } 
    }
    public function getHistory(Request $request)
    {
        $machine_code = $request->machine_code;
        $history = MachineRepairDochd::leftjoin('machine_repair_statuses','machine_repair_dochds.machine_repair_status_id','=','machine_repair_statuses.machine_repair_status_id')
        ->where('machine_repair_dochds.docutype', 'R')
        ->where('machine_repair_dochds.machine_code',$machine_code)
        ->whereNotIn('machine_repair_dochds.machine_repair_status_id',[7,6])
        ->select('machine_repair_dochds.*','machine_repair_statuses.machine_repair_status_name')
        ->get()
        ->map(function($row) {
            return [
                'status' => $row->machine_repair_status_name,
                'date' => \Carbon\Carbon::parse($row->machine_repair_dochd_date)->format('d/m/Y'),
                'doc_no' => $row->machine_repair_dochd_docuno,
                'type' => $row->machine_repair_dochd_type,
                'problem' => $row->machine_repair_dochd_case,
                'reporter' => $row->person_at,
            ];
        });
        return response()->json($history);
    }

    public function getMachines($groupId)
    {
        $machines = Machine::where('machinegroup_id', $groupId)->get();
        return response()->json($machines);
    }

    public function MachineRepairClose($id)
    {
        $hd = MachineRepairDochd::leftjoin('machine_repair_statuses','machine_repair_dochds.machine_repair_status_id','=','machine_repair_statuses.machine_repair_status_id')
        ->find($id);      
        $machine = Machine::where('machine_flag',true)->get();
        $status = MachineRepairStatus::whereIn('machine_repair_status_id',[3,8,9])->get();
        $stc = DB::table('vw_stc_stockcard')->get();
        return view('docu-machine.issue-machinerepair-docu',compact('hd','machine','status','stc'));
    }
    public function updateIssueStock(Request $request, $id)
    {
        $data = [
            'machine_repair_status_id' => 10,
            'approvedclose_at' => Auth::user()->name,
            'approvedclose_date' => Carbon::now(),
        ];
        try
        {
            DB::beginTransaction();
            MachineRepairDochd::where('machine_repair_dochd_id', $id)->update($data);
            $hd = MachineRepairDochd::find($id);
            $dt = MachineRepairDocdt::where('machine_repair_dochd_id',$id)->where('machine_repair_docdt_flag',true)->get();
            foreach ($dt as $key => $value) {
                DB::table('stc_stockcard')->insert([
                    'stc_stockcard_date' => $hd->machine_repair_dochd_date,
                    'stc_stockcard_docuno' => $hd->machine_repair_dochd_docuno,
                    'stc_stockcard_productcode' => $value->machine_repair_docdt_code,
                    'stc_stockcard_productname' => $value->machine_repair_docdt_remark,
                    'stc_stockcard_productunit' => $value->machine_repair_docdt_unit,
                    'stc_stockcard_productqty' => $value->machine_repair_docdt_qty,
                    'stockflag' => 1,
                    'person_at' => Auth::user()->name,
                    'update_at' => Carbon::now(),
                    'stc_stockcard_productprice' => $value->machine_repair_docdt_price,
                ]);
                MachineRepairDocdt::where('machine_repair_docdt_id',$value->machine_repair_docdt_id)
                ->update([
                    'poststock' => "N"
                ]);
            }
            DB::commit();
            return redirect()->route('machine-repair-docus.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('machine-repair-docus.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
        } 
    }
}
