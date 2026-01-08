<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WelcomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function () {
    return view('auth.login');
});
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'role:superadmin'])->name('dashboard');
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });
require __DIR__.'/auth.php';
Route::get('/home', [WelcomeController::class, 'index'])->name('home');
Route::group([
    'middleware' =>  ['auth','role:superadmin|admin|user']
],function(){
Route::resource('/persons' , App\Http\Controllers\PersonController::class);
    Route::group([
        'middleware' =>  ['auth','role:superadmin']
    ],function(){       
        Route::resource('/permissions' , App\Http\Controllers\PermissionController::class);
    });
    Route::group([
        'middleware' =>  ['auth','permission:setup-machinegroup']
    ],function(){
        Route::resource('/machine-groups' , App\Http\Controllers\MachineGroupController::class);
    });
    Route::group([
        'middleware' =>  ['auth','permission:setup-machine']
    ],function(){
        Route::resource('/machines' , App\Http\Controllers\MachineController::class);
        Route::get('/report-machine' , [App\Http\Controllers\MachineReportController::class , 'ReportMachine']);
        Route::get('/report-machine-createall' , [App\Http\Controllers\MachineReportController::class , 'ReportMachineCreate']);
        Route::get('/report-machine-repairall' , [App\Http\Controllers\MachineReportController::class , 'ReportMachineRepair']);
        Route::get('/report-machine-urgentall' , [App\Http\Controllers\MachineReportController::class , 'ReportMachineUrgent']);
        Route::get('/report-machine-normalall' , [App\Http\Controllers\MachineReportController::class , 'ReportMachineNormal']);
    });
    Route::group([
        'middleware' =>  ['auth','permission:setup-machineplaning']
    ],function(){ 
        Route::resource('/machine-planings' , App\Http\Controllers\MachinePlaningController::class);
        Route::post('/confirmDelMachinePlaning' , [App\Http\Controllers\MachinePlaningController::class , 'confirmDelMachinePlaning']);
        Route::post('/confirmDelMachinePlaningHd' , [App\Http\Controllers\MachinePlaningController::class , 'confirmDelMachinePlaningHd']);
        Route::resource('/machine-planing-docus' , App\Http\Controllers\MachinePlaningDocuController::class);
        Route::post('/confirmDelMachinePlaningDocuDt' , [App\Http\Controllers\MachinePlaningDocuController::class , 'confirmDelMachinePlaningDocuDt']);
        Route::get('/api/machines-by-group', [App\Http\Controllers\MachinePlaningDocuController::class, 'getMachinesByGroup']);
        Route::get('/report-calendar-pm' , [App\Http\Controllers\MachinePlaningDocuController::class , 'CalendarPm']);
        Route::put('/machine-planing-docus/{id}/review-update', [App\Http\Controllers\MachinePlaningDocuController::class, 'updateReview'])->name('machine-planing-docus.review-update');
    });
    Route::group([
        'middleware' =>  ['auth','permission:setup-machinechecksheet']
    ],function(){
        Route::resource('/machine-checksheets' , App\Http\Controllers\MachineChecksheetController::class);
        Route::post('/confirmDelMachineChecksheet' , [App\Http\Controllers\MachineChecksheetController::class , 'confirmDelMachineChecksheet']);
        Route::post('/confirmDelMachineChecksheetHd' , [App\Http\Controllers\MachineChecksheetController::class , 'confirmDelMachineChecksheetHd']);
        Route::resource('/machine-checksheet-docus' , App\Http\Controllers\MachineChecksheetDocuController::class);
        Route::post('/confirmDelMachineChecksheetDocuHd' , [App\Http\Controllers\MachineChecksheetDocuController::class , 'confirmDelMachineChecksheetDocuHd']);
        Route::get('/get-machine-checkdetails/{id}', [App\Http\Controllers\MachineChecksheetDocuController::class, 'getCheckDetails']);
        Route::get('/machine-checksheet-docus-print/{id}', [App\Http\Controllers\MachineChecksheetDocuController::class, 'MachineChecksheetPrint'])->name('machine-checksheet-docus.print');
        Route::post('/confirmApprovedMachineChecksheetDocuHd' , [App\Http\Controllers\MachineChecksheetDocuController::class , 'confirmApprovedMachineChecksheetDocuHd']);
    });
    Route::group([
        'middleware' =>  ['auth','permission:setup-equipment']
    ],function(){
        Route::resource('/equipments' , App\Http\Controllers\EquipmentController::class);
        Route::resource('/equipment-transfer' , App\Http\Controllers\EquipmentTransferController::class);
        Route::post('/confirmDelEquipmentTransfer' , [App\Http\Controllers\EquipmentTransferController::class , 'confirmDelEquipmentTransfer']);
        Route::resource('/customers' , App\Http\Controllers\CustomerController::class);
        Route::resource('/equipment-repair' , App\Http\Controllers\EquipmentRepairController::class);
        Route::get('/report-equipment' , [App\Http\Controllers\EquipmentReportController::class , 'ReportEquipment']);
    });
    Route::group([
        'middleware' =>  ['auth','permission:docu-machine-repair']
    ],function(){ 
        Route::resource('/machine-repair-docus' , App\Http\Controllers\MachineRepairDocuController::class);
        Route::post('/confirmDelMachineRepairHd' , [App\Http\Controllers\MachineRepairDocuController::class , 'confirmDelMachineRepairHd']);
        Route::post('/confirmDelMachineRepairDt' , [App\Http\Controllers\MachineRepairDocuController::class , 'confirmDelMachineRepairDt']);
        Route::put('/machine-repair-docus/{id}/safety-update', [App\Http\Controllers\MachineRepairDocuController::class, 'updateSafety'])->name('machine-repair-docus.safety-update');
        Route::get('/machine/history', [App\Http\Controllers\MachineRepairDocuController::class, 'getHistory'])->name('machine.history');
        Route::get('/get-machines/{groupId}', [App\Http\Controllers\MachineRepairDocuController::class, 'getMachines']);
        Route::get('/machine-repair-close/{id}' , [App\Http\Controllers\MachineRepairDocuController::class , 'MachineRepairClose']);
        Route::put('/machine-repair-docus/{id}/issuestock-update', [App\Http\Controllers\MachineRepairDocuController::class, 'updateIssueStock'])->name('machine-repair-docus.issuestock-update');
    });
    Route::group([
        'middleware' =>  ['auth','permission:docu-machine-create']
    ],function(){ 
        Route::resource('/machine-create-docus' , App\Http\Controllers\MachineCreateDocuController::class);
        Route::post('/confirmDelMachineCreateHd' , [App\Http\Controllers\MachineCreateDocuController::class , 'confirmDelMachineCreateHd']);
        Route::post('/confirmDelMachineCreateDt' , [App\Http\Controllers\MachineCreateDocuController::class , 'confirmDelMachineCreateDt']);
        Route::put('/machine-create-docus/{id}/safety-update', [App\Http\Controllers\MachineCreateDocuController::class, 'updateSafety'])->name('machine-create-docus.safety-update');   
        Route::get('/machine-create-close/{id}' , [App\Http\Controllers\MachineCreateDocuController::class , 'MachineCreateClose']);    
        Route::put('/machine-create-docus/{id}/issuestock-update', [App\Http\Controllers\MachineCreateDocuController::class, 'updateIssueStock'])->name('machine-create-docus.issuestock-update');
    });
    Route::group([
        'middleware' =>  ['auth','permission:docu-equipment-request']
    ],function(){
        Route::resource('/equipment-request' , App\Http\Controllers\EquipmentRequestController::class);
        Route::put('/equipment-request/{id}/approved', [App\Http\Controllers\EquipmentRequestController::class, 'updateApproved'])->name('equipment-request.approved');
        Route::post('/confirmDelEquipmentRequest' , [App\Http\Controllers\EquipmentRequestController::class , 'confirmDelEquipmentRequest']);
        Route::resource('/customer-transfer' , App\Http\Controllers\CustomerTransfer::class);
    });
    Route::group([
        'middleware' =>  ['auth','permission:docu-machine-issuestock']
    ],function(){
        Route::resource('/machine-issue-docus' , App\Http\Controllers\MachineIssueStockController::class);
        Route::post('/confirmDelMachineIssueStock' , [App\Http\Controllers\MachineIssueStockController::class , 'confirmDelMachineIssueStock']);
        Route::post('/confirmDelMachineIssueStockDt' , [App\Http\Controllers\MachineIssueStockController::class , 'confirmDelMachineIssueStockDt']);
        Route::get('/stockcardlist', [App\Http\Controllers\MachineIssueStockController::class, 'stockcardlist'])->name('stockcardlist');
    });
    Route::group([
        'middleware' =>  ['auth','permission:iso-masterlist']
    ],function(){
        Route::resource('/iso-masterlist' , App\Http\Controllers\IsoMasterListController::class);
        Route::post('/confirmDelMasterlist' , [App\Http\Controllers\IsoMasterListController::class , 'confirmDelMasterlist']);
    });
     Route::group([
        'middleware' =>  ['auth','permission:iso-distributionlist']
    ],function(){
        Route::resource('/iso-distributionlist' , App\Http\Controllers\IsoDistributionListController::class);
        Route::post('/confirmDelDistributionlist' , [App\Http\Controllers\IsoDistributionListController::class , 'confirmDelDistributionlist']);
        Route::post('/approvedDistributionlist' , [App\Http\Controllers\IsoDistributionListController::class , 'approvedDistributionlist']);
    });
    Route::group([
        'middleware' =>  ['auth','permission:iso-ncrlist']
    ],function(){
        Route::resource('/iso-ncrlist' , App\Http\Controllers\IsoNcrListController::class);
    });
    Route::resource('/asset-inout' , App\Http\Controllers\OtherAssetinoutForm::class);
    Route::post('/confirmDelAssetinoutHd' , [App\Http\Controllers\OtherAssetinoutForm::class , 'confirmDelAssetinoutHd']);
    Route::post('/confirmDelAssetinoutDt' , [App\Http\Controllers\OtherAssetinoutForm::class , 'confirmDelAssetinoutDt']);
    Route::get('/asset-inout-print/{id}', [App\Http\Controllers\OtherAssetinoutForm::class, 'AssetinoutPrint'])->name('asset-inout.print');
    Route::resource('/employees' , App\Http\Controllers\EmployeeList::class);
});
//QrCodeScan
Route::get('/machine-qrcode/{id}' , [App\Http\Controllers\QrsacnController::class , 'QrcodeScanMachine']);
Route::get('/equipment-qrcode/{id}' , [App\Http\Controllers\QrsacnController::class , 'QrcodeScanEquipment']);
Route::get('/customer-transfers/{id}' , [App\Http\Controllers\QrsacnController::class , 'QrcodeScanCustomerTransfer']);
Route::resource('/customer-repair' , App\Http\Controllers\CustomerRepairController::class);


Route::get('/run-machineplaning/{token}', function ($token) {
    if ($token !== env('SCHEDULE_TOKEN')) {
        abort(403, 'Unauthorized');
    }
    app(\App\Http\Controllers\ScheduleController::class)->machineplaning_run();
    return 'OK';
});
Route::get('/run-machinerepair/{token}', function ($token) {
    if ($token !== env('SCHEDULE_TOKEN')) {
        abort(403, 'Unauthorized');
    }
    app(\App\Http\Controllers\ScheduleController::class)->machinerepair_run();
    return 'OK';
});
Route::get('/review-machinerepair/{token}', function ($token) {
    if ($token !== env('SCHEDULE_TOKEN')) {
        abort(403, 'Unauthorized');
    }
    app(\App\Http\Controllers\ScheduleController::class)->machinerepair_review();
    return 'OK';
});