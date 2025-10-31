<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\AssetinoutDt;
use App\Models\AssetinoutHd;
use Illuminate\Http\Request;
use App\Models\AssetinoutStatus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OtherAssetinoutForm extends Controller
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
        $hd = AssetinoutHd::leftjoin('assetinout_statuses','assetinout_hds.assetinout_statuses_id','=','assetinout_statuses.assetinout_statuses_id')->get();
        return view('others.list-assetinout',compact('hd'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $docs_last = DB::table('assetinout_hds')
            ->where('assetinout_hd_docuno', 'like', '%' . date('ym') . '%')
            ->orderBy('assetinout_hd_id', 'desc')->first();
        if ($docs_last) {
            $docs = 'TPI' . date('ym')  . str_pad($docs_last->assetinout_hd_docunum + 1, 4, '0', STR_PAD_LEFT);
            $docs_number = $docs_last->assetinout_hd_docunum + 1;
        } else {
            $docs = 'TPI' . date('ym')  . str_pad(1, 4, '0', STR_PAD_LEFT);
            $docs_number = 1;
        }
        return view('others.create-assetinout',compact('docs','docs_number'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $docs_last = DB::table('assetinout_hds')
            ->where('assetinout_hd_docuno', 'like', '%' . date('ym') . '%')
            ->orderBy('assetinout_hd_id', 'desc')->first();
        if ($docs_last) {
            $docs = 'TPI' . date('ym')  . str_pad($docs_last->assetinout_hd_docunum + 1, 4, '0', STR_PAD_LEFT);
            $docs_number = $docs_last->assetinout_hd_docunum + 1;
        } else {
            $docs = 'TPI' . date('ym')  . str_pad(1, 4, '0', STR_PAD_LEFT);
            $docs_number = 1;
        }
        $request->validate([
            'assetinout_hd_date' => 'required',
            'assetinout_hd_docuno' => 'required',
            'assetinout_hd_vendor' => 'required',
        ]);
        $data = [
            'assetinout_statuses_id' => 1,
            'assetinout_hd_date' => $request->assetinout_hd_date,
            'assetinout_hd_docuno' => $docs,
            'assetinout_hd_docunum' => $docs_number,
            'assetinout_hd_vendor' => $request->assetinout_hd_vendor,
            'assetinout_hd_contact' => $request->assetinout_hd_contact,
            'assetinout_hd_tel' => $request->assetinout_hd_tel,
            'assetinout_hd_note' => $request->assetinout_hd_note,
            'person_at' => Auth::user()->name,
            'created_at' => Carbon::now(),  
        ];
        if ($request->hasFile('assetinout_hd_file1') && $request->file('assetinout_hd_file1')->isValid()) {
            $filename = "TPI_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('assetinout_hd_file1')->getClientOriginalExtension();
            $request->file('assetinout_hd_file1')->storeAs('assetinout_img', $filename, 'public');
            $data['assetinout_hd_file1'] = 'storage/assetinout_img/' . $filename;
        }
        if ($request->hasFile('assetinout_hd_file2') && $request->file('assetinout_hd_file2')->isValid()) {
            $filename = "TPI_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('assetinout_hd_file2')->getClientOriginalExtension();
            $request->file('assetinout_hd_file2')->storeAs('assetinout_img', $filename, 'public');
            $data['assetinout_hd_file2'] = 'storage/assetinout_img/' . $filename;
        }
        try 
        {
            DB::beginTransaction();
            $hd = AssetinoutHd::create($data);
            foreach ($request->assetinout_dt_listno as $key => $value) {
                AssetinoutDt::create([
                    'assetinout_hd_id' => $hd->assetinout_hd_id,
                    'assetinout_dt_listno' => $value,
                    'assetinout_dt_name' => $request->assetinout_dt_name[$key],
                    'assetinout_dt_qty' => $request->assetinout_dt_qty[$key],
                    'assetinout_dt_note' => $request->assetinout_dt_note[$key],
                    'assetinout_dt_flag' => true,
                    'person_at' => Auth::user()->name,
                    'created_at' => Carbon::now(),
                ]);
            }
            $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // 🔹 ใส่ Token ที่ได้จาก BotFather
            $chatId = "-4871539820";            // 🔹 ใส่ Chat ID ของกลุ่มหรือผู้ใช้
            $message = "📢 ขอนำทรัพย์สินออกนอกบริษัท : " . $docs ."\n"
                . "🔹 คู่ค้า  : ". $request->assetinout_hd_vendor . "\n"
                . "🔹 หมายเหตุ  : ". $request->assetinout_hd_note . "\n"
                . "📅 วันที่ : " . date("d-m-Y",strtotime($request->assetinout_hd_date)) . "\n"
                . "👤 ผู้ขอ : " . Auth::user()->name . "\n"
                . "คลิก : " . "https://app.siamfood-beverage.com/asset-inout" . "\n";
            // เรียกใช้ฟังก์ชัน notifyTelegram() ภายใน Controller
            $this->notifyTelegram($message, $token, $chatId);    
            DB::commit();
            return redirect()->route('asset-inout.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
        } catch (\Exception $e) {
            DB::rollback();
            $message = $e->getMessage();
            dd($message);
            return redirect()->route('asset-inout.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
        $hd = AssetinoutHd::find($id);
        $dt = AssetinoutDt::where('assetinout_hd_id',$id)->where('assetinout_dt_flag',true)->get();
        $sta = AssetinoutStatus::whereIn('assetinout_statuses_id',[3,4])->get();
        return view('others.update-assetinout',compact('hd','dt','sta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $hd = AssetinoutHd::find($id);
        $dt = AssetinoutDt::where('assetinout_hd_id',$id)->where('assetinout_dt_flag',true)->get();
        return view('others.edit-assetinout',compact('hd','dt'));
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
        if($request->checkdoc == "Edit"){
            $request->validate([
            'assetinout_hd_date' => 'required',
            'assetinout_hd_docuno' => 'required',
            'assetinout_hd_vendor' => 'required',
            ]);
            $data = [
                'assetinout_statuses_id' => 1,
                'assetinout_hd_date' => $request->assetinout_hd_date,
                'assetinout_hd_docuno' => $docs,
                'assetinout_hd_docunum' => $docs_number,
                'assetinout_hd_vendor' => $request->assetinout_hd_vendor,
                'assetinout_hd_contact' => $request->assetinout_hd_contact,
                'assetinout_hd_tel' => $request->assetinout_hd_tel,
                'assetinout_hd_note' => $request->assetinout_hd_note,
                'person_at' => Auth::user()->name,
                'updated_at' => Carbon::now(),  
            ];
            if ($request->hasFile('assetinout_hd_file1') && $request->file('assetinout_hd_file1')->isValid()) {
                $filename = "TPI_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('assetinout_hd_file1')->getClientOriginalExtension();
                $request->file('assetinout_hd_file1')->storeAs('assetinout_img', $filename, 'public');
                $data['assetinout_hd_file1'] = 'storage/assetinout_img/' . $filename;
            }
            if ($request->hasFile('assetinout_hd_file2') && $request->file('assetinout_hd_file2')->isValid()) {
                $filename = "TPI_" . now()->format('YmdHis') . "_" . Str::random(5) . '.' . $request->file('assetinout_hd_file2')->getClientOriginalExtension();
                $request->file('assetinout_hd_file2')->storeAs('assetinout_img', $filename, 'public');
                $data['assetinout_hd_file2'] = 'storage/assetinout_img/' . $filename;
            }
            try 
            {
                DB::beginTransaction();
                $hd = AssetinoutHd::where('assetinout_hd_id',$id)->update($data);
                foreach ($request->assetinout_dt_id as $key => $value) {
                    AssetinoutDt::where('assetinout_dt_id',$value)->update([
                        'assetinout_dt_name' => $request->assetinout_dt_name[$key],
                        'assetinout_dt_qty' => $request->assetinout_dt_qty[$key],
                        'assetinout_dt_note' => $request->assetinout_dt_note[$key],
                        'assetinout_dt_flag' => true,
                        'person_at' => Auth::user()->name,
                        'updated_at' => Carbon::now(),
                    ]);
                }
                foreach ($request->assetinout_dt_listno as $key => $value) {
                    AssetinoutDt::create([
                        'assetinout_hd_id' => $hd->assetinout_hd_id,
                        'assetinout_dt_listno' => $value,
                        'assetinout_dt_name' => $request->assetinout_dt_name[$key],
                        'assetinout_dt_qty' => $request->assetinout_dt_qty[$key],
                        'assetinout_dt_note' => $request->assetinout_dt_note[$key],
                        'assetinout_dt_flag' => true,
                        'person_at' => Auth::user()->name,
                        'created_at' => Carbon::now(),
                    ]);
                }  
                DB::commit();
                return redirect()->route('asset-inout.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('asset-inout.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
            } 
        }elseif($request->checkdoc == "Update"){
            try 
            {
                DB::beginTransaction();
                $hd = AssetinoutHd::where('assetinout_hd_id',$id)->update([
                    'approved_date' => Carbon::now(),
                    'approved_at' => Auth::user()->name,
                    'approved_remark' => $request->approved_remark,
                    'assetinout_statuses_id' => $request->assetinout_statuses_id
                ]);                
                DB::commit();
                return redirect()->route('asset-inout.index')->with('success', 'บันทึกข้อมูลเรียบร้อย');
            } catch (\Exception $e) {
                DB::rollback();
                $message = $e->getMessage();
                dd($message);
                return redirect()->route('asset-inout.index')->with('error', 'บันทึกข้อมูลไม่สำเร็จ');
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
    public function confirmDelAssetinoutHd(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            AssetinoutHd::where('assetinout_hd_id',$id)->update([
                'assetinout_statuses_id' => 2,
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
    public function confirmDelAssetinoutDt(Request $request)
    {
        $id = $request->refid;
        try 
        {
            DB::beginTransaction();
            AssetinoutDt::where('assetinout_dt_id',$id)->update([
                'assetinout_dt_flag' => 0,
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
    public function AssetinoutPrint($id)
    {
        $hd = AssetinoutHd::find($id);
        $dt = AssetinoutDt::where('assetinout_hd_id',$id)->where('assetinout_dt_flag',true)->get();
        return view('others.print-assetinout',compact('hd','dt'));
    }
}
