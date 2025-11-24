<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\MachinePlaningdocuHd;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ScheduleController extends Controller
{
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

    public function machineplaning_run()
    {
        $today = Carbon::today();
        $hd = MachinePlaningdocuHd::leftjoin('machine_planingdocu_dts','machine_planingdocu_hds.machine_planingdocu_hd_id','=','machine_planingdocu_dts.machine_planingdocu_hd_id')
            ->leftjoin('machines','machine_planingdocu_dts.machine_code','=','machines.machine_code')
            ->where('machine_planingdocu_hds.machine_planingdocu_hd_flag', true)
            ->where('machine_planingdocu_dts.machine_planingdocu_dt_flag', true)
            ->get();

        foreach ($hd as $key => $value) {
            if ($value->machine_planingdocu_dt_date) {
                $planDate = Carbon::parse($value->machine_planingdocu_dt_date);
                // 🔎 เช็คว่าเหลืออีก 7 วัน (ไม่รวมอดีต)
                if ($planDate->isSameDay($today->copy()->addDays(7))) {
                    $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // Telegram Bot Token
                    $chatId = "-4871539820"; // Chat ID

                    $message = "📢 แจ้งเตือนแผนซ่อมบำรุงอีก 7 วัน : " . $value->machine_code . " " . $value->machine_name . "\n"
                        . "🔹 รายละเอียด  : " . $value->machine_planingdocu_dt_note . "\n"
                        . "📅 วันที่ : " . $planDate->format("d-m-Y") . "\n"
                        . "คลิก : https://app.siamfood-beverage.com/report-calendar-pm";

                    $this->notifyTelegram($message, $token, $chatId);
                }
                // 🔎 เช็คว่าเหลืออีก 5 วัน (ไม่รวมอดีต)
                if ($planDate->isSameDay($today->copy()->addDays(5))) {
                    $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // Telegram Bot Token
                    $chatId = "-4871539820"; // Chat ID

                    $message = "📢 แจ้งเตือนแผนซ่อมบำรุงอีก 5 วัน : " . $value->machine_code . " " . $value->machine_name . "\n"
                        . "🔹 รายละเอียด  : " . $value->machine_planingdocu_dt_note . "\n"
                        . "📅 วันที่ : " . $planDate->format("d-m-Y") . "\n"
                        . "คลิก : https://app.siamfood-beverage.com/report-calendar-pm";

                    $this->notifyTelegram($message, $token, $chatId);
                }
                // 🔎 เช็คว่าเหลืออีก 3 วัน (ไม่รวมอดีต)
                if ($planDate->isSameDay($today->copy()->addDays(3))) {
                    $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // Telegram Bot Token
                    $chatId = "-4871539820"; // Chat ID

                    $message = "📢 แจ้งเตือนแผนซ่อมบำรุงอีก 3 วัน : " . $value->machine_code . " " . $value->machine_name . "\n"
                        . "🔹 รายละเอียด  : " . $value->machine_planingdocu_dt_note . "\n"
                        . "📅 วันที่ : " . $planDate->format("d-m-Y") . "\n"
                        . "คลิก : https://app.siamfood-beverage.com/report-calendar-pm";

                    $this->notifyTelegram($message, $token, $chatId);
                }
                 // 🔎 เช็คว่าเหลืออีก 1 วัน (ไม่รวมอดีต)
                if ($planDate->isSameDay($today->copy()->addDays(1))) {
                    $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // Telegram Bot Token
                    $chatId = "-4871539820"; // Chat ID

                    $message = "📢 แจ้งเตือนแผนซ่อมบำรุงอีก 1 วัน : " . $value->machine_code . " " . $value->machine_name . "\n"
                        . "🔹 รายละเอียด  : " . $value->machine_planingdocu_dt_note . "\n"
                        . "📅 วันที่ : " . $planDate->format("d-m-Y") . "\n"
                        . "คลิก : https://app.siamfood-beverage.com/report-calendar-pm";

                    $this->notifyTelegram($message, $token, $chatId);
                }
            }
        }
    }
    public function machinerepair_run()
    {
        $hd = DB::table('machine_repair_dochds')->where('machine_repair_status_id',2)->get();
        foreach ($hd as $key => $value) {
            $mc = DB::table('machines')->where('machine_code',$value->machine_code)->first();
            $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // Telegram Bot Token
            $chatId = "-4871539820"; // Chat ID
            $message = "📢 แจ้งเตือนใบแจ้งซ่อมรออนุมัติเลขที่ : " . $value->machine_repair_dochd_docuno . " ".$value->machine_code . "/". $mc->machine_name . "\n"
                        . "🔹 รายละเอียด  : " . $value->machine_repair_dochd_case . "(". $value->machine_repair_dochd_type .")". "\n"
                        . "📅 วันที่รับงานซ่อม : " . $value->accepting_date ." โดย " . $value->accepting_at . " (" . $value->accepting_note . ")". "\n"
                        . "คลิก : https://app.siamfood-beverage.com/machine-repair-docus/".$value->machine_repair_dochd_id."/edit";
            $this->notifyTelegram($message, $token, $chatId);
        }        
    }
    public function machinerepair_review()
    {
        $hd1 = DB::table('machine_repair_dochds')->where('machine_repair_status_id',4)->get();
        foreach ($hd1 as $key => $value) {
            $mc = DB::table('machines')->where('machine_code',$value->machine_code)->first();
            $machinename  = "-";
            if($mc){
                 $machinename  = $mc->machine_name;
            }
            $token = "7838547321:AAGz1IcWdMs3aCCSlYwKRdBkm45V7C-yJrA";  // Telegram Bot Token
            $chatId = "-4871539820"; // Chat ID
            $message = "📢 แจ้งเตือนใบแจ้งซ่อมรอตรวจสอบเลขที่ : " . $value->machine_repair_dochd_docuno . " ".$value->machine_code . "/". $machinename . "\n"
                        . "🔹 รายละเอียด  : " . $value->machine_repair_dochd_case . "(". $value->machine_repair_dochd_type .")". "\n"
                        . "📅 วันที่ซ่อมเสร็จ : " . $value->repairer_date ." โดย " . $value->repairer_at . " (" . $value->repairer_note . ")". "\n"
                        . "คลิก : https://app.siamfood-beverage.com/machine-repair-docus/".$value->machine_repair_dochd_id."/edit";
            $this->notifyTelegram($message, $token, $chatId);
        }
    }

}
