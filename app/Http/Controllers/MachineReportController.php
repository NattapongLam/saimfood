<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\MachineRepairDochd;
use Illuminate\Support\Facades\DB;

class MachineReportController extends Controller
{
    public function ReportMachine(Request $request)
    {
        // แปลงวันสิ้นสุดให้เป็นวันสุดท้ายของเดือน
        $dateend = $request->dateend
            ? Carbon::parse($request->dateend)->endOfMonth()
            : Carbon::now()->endOfMonth();

        // แปลงวันเริ่มต้นให้เป็นวันที่ 1 ของเดือนย้อนหลัง 6 เดือนจาก dateend
        $datestart = $request->datestart
            ? Carbon::parse($request->datestart)->startOfMonth()
            : $dateend->copy()->subMonths(6)->startOfMonth();

        // Query หลัก
        $hd = MachineRepairDochd::whereBetween('machine_repair_dochd_date', [$datestart, $dateend]);
        // สำเนา query ไปใช้งานในแต่ละเงื่อนไข
        $hd1 = (clone $hd)->where('docutype', 'C')->count(); // งานแจ้งซ่อม
        $hd2 = (clone $hd)->where('docutype', 'R')->count(); // งานร้องขอ
        $hd3 = (clone $hd)->where('machine_repair_dochd_type', 'ด่วน')->count();
        $hd4 = (clone $hd)->where('machine_repair_dochd_type', 'ปกติ')->count();
        $hd5 = (clone $hd)->count(); // รวมทั้งหมด
        $hd6 = (clone $hd)->whereIn('machine_repair_status_id', [1, 2, 9])->count();
        $hd7 = (clone $hd)->whereIn('machine_repair_status_id', [3, 4, 5])->count();
        $hd8 = (clone $hd)->whereIn('machine_repair_status_id', [6])->count();
        $hd9 = (clone $hd)->whereIn('machine_repair_status_id', [7, 8])->count();
        // ✅ รวมค่าใช้จ่ายรายเดือน โดยใช้ Query Builder เพื่อประสิทธิภาพ
        $cost = DB::table('machine_repair_dochds as hd')
            ->join('machine_repair_docdts as dt', 'hd.machine_repair_dochd_id', '=', 'dt.machine_repair_dochd_id')
            ->whereBetween('hd.machine_repair_dochd_date', [
                $datestart->format('Y-m-d'),
                $dateend->format('Y-m-d')
            ])
            ->where('dt.machine_repair_docdt_flag', 1)
            ->whereNotIn('hd.machine_repair_status_id', [7,8])
            ->selectRaw("FORMAT(hd.machine_repair_dochd_date, 'yyyy-MM') as month, SUM(dt.machine_repair_docdt_cost) as total_cost")
            ->groupByRaw("FORMAT(hd.machine_repair_dochd_date, 'yyyy-MM')")
            ->orderBy('month')
            ->pluck('total_cost', 'month'); // ได้ผลลัพธ์เป็น key => value (month => cost)
        $totalCost = $cost->sum();
        $mc = DB::table('machine_repair_dochds as hd')
            ->join('machine_repair_docdts as dt', 'hd.machine_repair_dochd_id', '=', 'dt.machine_repair_dochd_id')
            ->join('machines as m', 'hd.machine_code', '=', 'm.machine_code')
            ->whereBetween('hd.machine_repair_dochd_date', [
                $datestart->format('Y-m-d'),
                $dateend->format('Y-m-d')
            ])
            ->where('dt.machine_repair_docdt_flag', 1)
            ->whereNotIn('hd.machine_repair_status_id', [7,8])
            ->where('hd.docutype', "R")
            ->select(
                'hd.machine_code as code',
                'm.machine_name as name',
                'm.machine_pic1 as pic1',
                DB::raw('SUM(dt.machine_repair_docdt_cost) as mc_cost'),
                DB::raw("SUM(CASE WHEN hd.repairer_type = N'หยุดเครื่อง' THEN DATEDIFF(MINUTE, hd.machine_repair_dochd_datetime, hd.repairer_datetime) ELSE 0 END) as mc_time"),
                DB::raw('COUNT(DISTINCT hd.machine_repair_dochd_docuno) as mc_qty'),
                DB::raw("SUM(CASE WHEN hd.machine_repair_dochd_type = N'ด่วน' THEN 1 ELSE 0 END) as qty_urgent")
            )
            ->groupBy('hd.machine_code', 'm.machine_name', 'm.machine_pic1')
            ->orderBy('code')
            ->get();
        $gpCost = DB::table('machine_repair_dochds as hd')
            ->join('machine_repair_docdts as dt', 'hd.machine_repair_dochd_id', '=', 'dt.machine_repair_dochd_id')
            ->join('machines as m', 'hd.machine_code', '=', 'm.machine_code')
            ->join('machine_groups as g', 'm.machinegroup_id', '=', 'g.machinegroup_id')
            ->whereBetween('hd.machine_repair_dochd_date', [
                $datestart->format('Y-m-d'),
                $dateend->format('Y-m-d')
            ])
            ->where('dt.machine_repair_docdt_flag', 1)
            ->whereNotIn('hd.machine_repair_status_id', [7,8])
             ->where('hd.docutype', "R")
            ->selectRaw("g.machinegroup_name as groups, SUM(dt.machine_repair_docdt_cost) as total_cost")
            ->groupByRaw("g.machinegroup_name")
            ->orderBy('groups')
            ->pluck('total_cost', 'groups');
        $totalSum = $gpCost->sum();
        $empQty = DB::table('machine_repair_dochds as hd')
            ->whereBetween('hd.machine_repair_dochd_date', [
                $datestart->format('Y-m-d'),
                $dateend->format('Y-m-d')
            ])
            ->whereNotIn('hd.machine_repair_status_id', [7,8])
            ->where('hd.docutype', "R")
            ->select(
                'hd.repairer_at as code',
                DB::raw('COUNT(DISTINCT hd.machine_repair_dochd_docuno) as qty_total'),
                DB::raw("SUM(CASE WHEN hd.machine_repair_dochd_type = N'ด่วน' THEN 1 ELSE 0 END) as qty_urgent"),
                DB::raw("SUM(CASE WHEN hd.machine_repair_dochd_type = N'ปกติ' THEN 1 ELSE 0 END) as qty_normal")
            )
            ->groupBy('hd.repairer_at')
            ->orderBy('code')
            ->get();
       $cost1 = DB::table('machine_repair_dochds as hd')
            ->join('machine_repair_docdts as dt', 'hd.machine_repair_dochd_id', '=', 'dt.machine_repair_dochd_id')
            ->where('dt.machine_repair_docdt_flag', 1)
            ->whereNotIn('hd.machine_repair_status_id', [7,8])
            ->where('hd.docutype', "C")
            ->selectRaw("SUM(dt.machine_repair_docdt_cost) as total_cost")
            ->value('total_cost'); 
        $cost2 = DB::table('machine_repair_dochds as hd')
            ->join('machine_repair_docdts as dt', 'hd.machine_repair_dochd_id', '=', 'dt.machine_repair_dochd_id')
            ->where('dt.machine_repair_docdt_flag', 1)
            ->whereNotIn('hd.machine_repair_status_id', [7,8])
            ->where('hd.docutype', "R")
            ->selectRaw("SUM(dt.machine_repair_docdt_cost) as total_cost")
            ->value('total_cost');
        $cost3 = DB::table('machine_repair_dochds as hd')
            ->join('machine_repair_docdts as dt', 'hd.machine_repair_dochd_id', '=', 'dt.machine_repair_dochd_id')
            ->where('dt.machine_repair_docdt_flag', 1)
            ->whereNotIn('hd.machine_repair_status_id', [7,8])
            ->where('machine_repair_dochd_type', 'ด่วน')
            ->selectRaw("SUM(dt.machine_repair_docdt_cost) as total_cost")
            ->value('total_cost');
        $cost4 = DB::table('machine_repair_dochds as hd')
            ->join('machine_repair_docdts as dt', 'hd.machine_repair_dochd_id', '=', 'dt.machine_repair_dochd_id')
            ->where('dt.machine_repair_docdt_flag', 1)
            ->whereNotIn('hd.machine_repair_status_id', [7,8])
            ->where('machine_repair_dochd_type', 'ปกติ')
            ->selectRaw("SUM(dt.machine_repair_docdt_cost) as total_cost")
            ->value('total_cost');
        $pendingJobs = (clone $hd)->whereIn('machine_repair_status_id', [1, 2, 9])->get();
        // ส่งค่าไปยัง view
        return view('report-machine.report-machineall', compact(
            'dateend', 'datestart',
            'hd1', 'hd2', 'hd3', 'hd4', 'hd5', 'hd6', 'hd7', 'hd8', 'hd9', 'cost', 'totalCost', 'mc','gpCost','totalSum','empQty','cost1','cost2','cost3','cost4','pendingJobs'
        ));
    }

    public function ReportMachineCreate(Request $request)
    {
        $hd = MachineRepairDochd::leftJoin('machine_repair_statuses','machine_repair_statuses.machine_repair_status_id','=','machine_repair_dochds.machine_repair_status_id')
        ->where('machine_repair_dochds.docutype', 'C')
        ->select(
            'machine_repair_dochds.*',
            'machine_repair_statuses.machine_repair_status_name',
            DB::raw('(SELECT SUM(d.machine_repair_docdt_cost) 
                    FROM machine_repair_docdts d 
                    WHERE d.machine_repair_dochd_id = machine_repair_dochds.machine_repair_dochd_id) as total_cost')
        )
        ->get();
        return view('report-machine.report-machine-createall', compact('hd'));
    }

    public function ReportMachineRepair(Request $request)
    {
        $hd = MachineRepairDochd::leftJoin('machine_repair_statuses','machine_repair_statuses.machine_repair_status_id','=','machine_repair_dochds.machine_repair_status_id')
        ->where('machine_repair_dochds.docutype', 'R')
        ->select(
            'machine_repair_dochds.*',
            'machine_repair_statuses.machine_repair_status_name',
            DB::raw('(SELECT SUM(d.machine_repair_docdt_cost) 
                    FROM machine_repair_docdts d 
                    WHERE d.machine_repair_dochd_id = machine_repair_dochds.machine_repair_dochd_id) as total_cost')
        )
        ->get();
        return view('report-machine.report-machine-repairall', compact('hd'));
    }

    public function ReportMachineUrgent(Request $request)
    {
        $hd = MachineRepairDochd::leftJoin('machine_repair_statuses','machine_repair_statuses.machine_repair_status_id','=','machine_repair_dochds.machine_repair_status_id')
        ->where('machine_repair_dochds.machine_repair_dochd_type', 'ด่วน')
        ->select(
            'machine_repair_dochds.*',
            'machine_repair_statuses.machine_repair_status_name',
            DB::raw('(SELECT SUM(d.machine_repair_docdt_cost) 
                    FROM machine_repair_docdts d 
                    WHERE d.machine_repair_dochd_id = machine_repair_dochds.machine_repair_dochd_id) as total_cost')
        )
        ->get();
        return view('report-machine.report-machine-urgentall', compact('hd'));
    }

    public function ReportMachineNormal(Request $request)
    {
        $hd = MachineRepairDochd::leftJoin('machine_repair_statuses','machine_repair_statuses.machine_repair_status_id','=','machine_repair_dochds.machine_repair_status_id')
        ->where('machine_repair_dochds.machine_repair_dochd_type', 'ปกติ')
        ->select(
            'machine_repair_dochds.*',
            'machine_repair_statuses.machine_repair_status_name',
            DB::raw('(SELECT SUM(d.machine_repair_docdt_cost) 
                    FROM machine_repair_docdts d 
                    WHERE d.machine_repair_dochd_id = machine_repair_dochds.machine_repair_dochd_id) as total_cost')
        )
        ->get();
        return view('report-machine.report-machine-normalall', compact('hd'));
    }
}

