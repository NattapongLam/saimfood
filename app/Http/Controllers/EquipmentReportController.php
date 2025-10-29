<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EquipmentReportController extends Controller
{
    public function ReportEquipment(Request $request){

        // แปลงวันสิ้นสุดให้เป็นวันสุดท้ายของเดือน
        $dateend = $request->dateend
            ? Carbon::parse($request->dateend)->endOfMonth()
            : Carbon::now()->endOfMonth();

        // แปลงวันเริ่มต้นให้เป็นวันที่ 1 ของเดือนย้อนหลัง 6 เดือนจาก dateend
        $datestart = $request->datestart
            ? Carbon::parse($request->datestart)->startOfMonth()
            : $dateend->copy()->subMonths(6)->startOfMonth();
        $hd1 = DB::table('equipment_transfer_hds')
        ->leftJoin('equipment_transfer_dts', 'equipment_transfer_hds.equipment_transfer_hd_id', '=', 'equipment_transfer_dts.equipment_transfer_hd_id')
        ->leftJoin('equipment_transfer_statuses', 'equipment_transfer_hds.equipment_transfer_status_id', '=', 'equipment_transfer_statuses.equipment_transfer_status_id')
        ->leftJoin('equipment', 'equipment_transfer_dts.equipment_id', '=', 'equipment.equipment_id')
        ->leftJoin('customers', 'equipment_transfer_hds.customer_id', '=', 'customers.customer_id')
        ->leftJoin('tg_employee_list', function($join) {
            $join->on(DB::raw('customers.salecode COLLATE Thai_CI_AS'), '=', DB::raw('tg_employee_list.personcode COLLATE Thai_CI_AS'));
        })
        ->leftJoin('vw_customerrepair_cost', function($join) {
            $join->on('equipment.equipment_id', '=', 'vw_customerrepair_cost.equipment_id')
                ->on('customers.customer_id', '=', 'vw_customerrepair_cost.customer_id');
        })
        ->whereBetween('equipment_transfer_hds.equipment_transfer_hd_date', [$datestart, $dateend])
        ->select(
            'customers.customer_code',
            'customers.customer_name',
            'customers.customer_zone',
            'tg_employee_list.personfullname',
            'customers.salecode',
            'vw_customerrepair_cost.repair_cost',
            DB::raw('COUNT(DISTINCT equipment_transfer_dts.equipment_code) as total_qty'),
            DB::raw('SUM(equipment.equipment_cost) as total_cost')
        )
        ->groupBy('customers.customer_code', 'customers.customer_name','customers.customer_zone','tg_employee_list.personfullname','customers.salecode','vw_customerrepair_cost.repair_cost')
        ->orderBy('customers.customer_code')
        ->get();
        $detail = DB::table('equipment_transfer_hds')
        ->leftJoin('equipment_transfer_dts', 'equipment_transfer_hds.equipment_transfer_hd_id', '=', 'equipment_transfer_dts.equipment_transfer_hd_id')
        ->leftJoin('equipment_transfer_statuses', 'equipment_transfer_hds.equipment_transfer_status_id', '=', 'equipment_transfer_statuses.equipment_transfer_status_id')
        ->leftJoin('equipment', 'equipment_transfer_dts.equipment_id', '=', 'equipment.equipment_id')
        ->leftJoin('customers', 'equipment_transfer_hds.customer_id', '=', 'customers.customer_id')
        ->leftJoin('tg_employee_list', function($join) {
            $join->on(DB::raw('customers.salecode COLLATE Thai_CI_AS'), '=', DB::raw('tg_employee_list.personcode COLLATE Thai_CI_AS'));
        })
        ->leftJoin('vw_customerrepair_cost', function($join) {
            $join->on('equipment.equipment_id', '=', 'vw_customerrepair_cost.equipment_id')
                ->on('customers.customer_id', '=', 'vw_customerrepair_cost.customer_id');
        })
        ->whereBetween('equipment_transfer_hds.equipment_transfer_hd_date', [$datestart, $dateend])
        ->select(
            'equipment_transfer_hds.equipment_transfer_hd_date',
            'equipment_transfer_hds.equipment_transfer_hd_docuno',
            'tg_employee_list.personfullname',
            'customers.customer_code',
            'equipment_transfer_statuses.equipment_transfer_status_name',
            'equipment_transfer_dts.equipment_code',
            'equipment_transfer_dts.equipment_name',
            'equipment.equipment_cost',
            'customers.salecode',
            'vw_customerrepair_cost.repair_cost',
        )
        ->get();
        return view('report-equipment.report-equipmentall', compact(
            'dateend', 'datestart','hd1','detail'
        ));
    }
}
