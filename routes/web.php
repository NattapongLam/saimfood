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
    });
    Route::group([
        'middleware' =>  ['auth','permission:setup-equipment']
    ],function(){
        Route::resource('/equipments' , App\Http\Controllers\EquipmentController::class);
        Route::resource('/equipment-transfer' , App\Http\Controllers\EquipmentTransferController::class);
        Route::post('/confirmDelEquipmentTransfer' , [App\Http\Controllers\EquipmentTransferController::class , 'confirmDelEquipmentTransfer']);
        Route::resource('/customers' , App\Http\Controllers\CustomerController::class);
        Route::resource('/equipment-repair' , App\Http\Controllers\EquipmentRepairController::class);
    });
    Route::group([
        'middleware' =>  ['auth','permission:docu-machine-repair']
    ],function(){ 
        Route::resource('/machine-repair-docus' , App\Http\Controllers\MachineRepairDocuController::class);
        Route::post('/confirmDelMachineRepairHd' , [App\Http\Controllers\MachineRepairDocuController::class , 'confirmDelMachineRepairHd']);
        Route::post('/confirmDelMachineRepairDt' , [App\Http\Controllers\MachineRepairDocuController::class , 'confirmDelMachineRepairDt']);
        Route::put('/machine-repair-docus/{id}/safety-update', [App\Http\Controllers\MachineRepairDocuController::class, 'updateSafety'])->name('machine-repair-docus.safety-update');
        Route::get('/machine/history', [App\Http\Controllers\MachineRepairDocuController::class, 'getHistory'])->name('machine.history');
    });
    Route::group([
        'middleware' =>  ['auth','permission:docu-machine-create']
    ],function(){ 
        Route::resource('/machine-create-docus' , App\Http\Controllers\MachineCreateDocuController::class);
        Route::post('/confirmDelMachineCreateHd' , [App\Http\Controllers\MachineCreateDocuController::class , 'confirmDelMachineCreateHd']);
        Route::post('/confirmDelMachineCreateDt' , [App\Http\Controllers\MachineCreateDocuController::class , 'confirmDelMachineCreateDt']);
        Route::put('/machine-create-docus/{id}/safety-update', [App\Http\Controllers\MachineCreateDocuController::class, 'updateSafety'])->name('machine-create-docus.safety-update');       
    });
     Route::group([
        'middleware' =>  ['auth','permission:docu-equipment-request']
    ],function(){
        Route::resource('/equipment-request' , App\Http\Controllers\EquipmentRequestController::class);
        Route::put('/equipment-request/{id}/approved', [App\Http\Controllers\EquipmentRequestController::class, 'updateApproved'])->name('equipment-request.approved');
        Route::post('/confirmDelEquipmentRequest' , [App\Http\Controllers\EquipmentRequestController::class , 'confirmDelEquipmentRequest']);
    });
});
//QrCodeScan
Route::get('/machine-qrcode/{id}' , [App\Http\Controllers\QrsacnController::class , 'QrcodeScanMachine']);
Route::get('/customer-transfer/{id}' , [App\Http\Controllers\QrsacnController::class , 'QrcodeScanCustomerTransfer']);
Route::resource('/customer-repair' , App\Http\Controllers\CustomerRepairController::class);