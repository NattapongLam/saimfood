<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MachineRepairDochd;

class MachineReportController extends Controller
{
    public function ReportMachine(Request $request)
    {
        $dateend = $request->dateend ? $request->dateend : date("Y-m-d");
        $datestart = $request->datestart ? $request->datestart : date("Y-m-d", strtotime("-6 month", strtotime($dateend)));
        $hd = MachineRepairDochd::whereBetween('machine_repair_dochd_date', [$datestart, $dateend]);
        $hd1 = (clone $hd)->where('docutype', 'C')->count();
        $hd2 = (clone $hd)->where('docutype', 'R')->count();
        $hd3 = (clone $hd)->where('machine_repair_dochd_type', 'ด่วน')->count();
        $hd4 = (clone $hd)->where('machine_repair_dochd_type', 'ปกติ')->count();
        $hd5 = (clone $hd)->count();
        $hd6 = (clone $hd)->whereIn('machine_repair_status_id',[1,2,9])->count();
        $hd7 = (clone $hd)->whereIn('machine_repair_status_id',[3,4,5])->count();
        $hd8 = (clone $hd)->whereIn('machine_repair_status_id',[6])->count();
        $hd9 = (clone $hd)->whereIn('machine_repair_status_id',[7,8])->count();
        return view('report-machine.report-machineall', compact('dateend','datestart','hd1','hd2','hd3','hd4','hd5','hd6','hd7','hd8','hd9'));
    }
}

