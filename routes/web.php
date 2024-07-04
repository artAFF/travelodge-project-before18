<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReadController;
use App\Http\Controllers\UpdateController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;




Route::get('/home/main', [ReadController::class, 'NumberOfCurrentStatus'])->name('main');

// Report Issue
Route::get('/reports/reportIssue', [ReadController::class, 'TableReportIssue'])->name("reportIssue");
Route::get('/reports/addIssue', [CreateController::class, 'AddReportIssue']);
Route::post('/insertIssue', [CreateController::class, 'InsertReportIssue']);
Route::delete('/deletereport/{id}', [DeleteController::class, 'DeleteReportIssue'])->name("deletereport");
Route::get('/reports/updateReport/{id}', [UpdateController::class, 'UpdateReportIssue'])->name("updateReport");
Route::post('/reports/updatePreport/{id}', [UpdateController::class, 'UpdateIssue'])->name("updatePreport");
Route::get('/reports/pdf-issue/{id}', [PdfController::class, 'pdfissue'])->name('pdfissue');
Route::get('/reports/pdf-issue-all', [PdfController::class, 'printAllIssues'])->name('pdf-issue-all');
Route::get('/reports/inprocess', [ReadController::class, 'inprocess'])->name('inprocess');
Route::get('/filterDate', [ReadController::class, 'filterDate'])->name('filterDate');

// Internet Speed Checking
Route::get('/netspeed/reportNet', [ReadController::class, 'TableReportNetSpeed'])->name("reportNet");
Route::get('/netspeed/addNetSpeed', [CreateController::class, 'Tlcmn_AddNetSpeed']);
Route::post('/insertNetSpeed', [CreateController::class, 'Tlcmn_InsertNetSpeed']);
Route::get('/netspeed/updateNetSpeed/{id}', [UpdateController::class, 'Tlcmn_UpdateReportNetSpeed'])->name('updateNetSpeed');
Route::post('/updatePNetSpeed/{id}', [UpdateController::class, 'Tlcmn_UpdateReportNetSpeedProcess'])->name('updatePNetSpeed');
Route::delete('/deleteNetSpeed/{id}', [DeleteController::class, 'Tlcmn_DeleteNetSpeed'])->name('deleteNetSpeed');

// Server Room Checking
Route::get('/server/reportServer', [ReadController::class, 'TableReportServer'])->name("reportServer");
Route::get('/server/addServer', [CreateController::class, 'Tlcmn_AddServer'])->name('addServer');
Route::post('/insertServer', [CreateController::class, 'Tlcmn_InsertServer']);
Route::get('/server/updateServer/{id}', [UpdateController::class, 'Tlcmn_UpdateServer'])->name('updateServer');
Route::post('/updatePServer/{id}', [UpdateController::class, 'Tlcmn_UpdateServerProcess'])->name('updatePserver');
Route::delete('/deleteServer/{id}', [DeleteController::class, 'Tlcmn_DeleteServer'])->name('deleteServer');

// Switch Room Checking
Route::get('/switchs/reportSwitch', [ReadController::class, 'TableReportSwitch'])->name("reportSwitch");
Route::get('/switchs/addSwitch', [CreateController::class, 'Tlcmn_AddSwitch'])->name('addSwitch');
Route::post('/insertSwitch', [CreateController::class, 'Tlcmn_InsertSwitch']);
Route::get('/switchs/updateSwitch/{id}', [UpdateController::class, 'Tlcmn_UpdateSwitch'])->name('updateSwitch');
Route::post('/updatePSwitch/{id}', [UpdateController::class, 'Tlcmn_UpdateSwitchProcess'])->name('updatePSwitch');
Route::delete('/deleteSwitch/{id}', [DeleteController::class, 'DeleteSwitch'])->name('deleteSwitch');

// Guest Room Checking
Route::get('/guest/reportGuest', [ReadController::class, 'TableReportGuest'])->name("reportGuest");
Route::get('/guest/addGuest', [CreateController::class, 'Tlcmn_AddGuest'])->name('addGuest');
Route::post('/insertGuest', [CreateController::class, 'Tlcmn_InsertGuest']);
Route::get('/guest/updateGuest/{id}', [UpdateController::class, 'Tlcmn_UpdateGuest'])->name('updateGuest');
Route::post('/updatePGuest/{id}', [UpdateController::class, 'Tlcmn_UpdateGuestProcess'])->name('updatePguest');
Route::delete('/deleteGuest/{id}', [DeleteController::class, 'Tlcmn_DeleteGuest'])->name('deleteGuest');

// Home page s
/* Route::get('/home/itsup_status', [ReadController::class, 'itsup_status']); */
// web.php

Route::get('/home/itsup_status/{department}', [ReadController::class, 'itsup_status'])->name('itsup_status');

Route::get('/home/admin_status', [ReadController::class, 'admin_status']);

// Dasboard
Route::get('/dashboards/dashboardMonth', [ChartController::class, 'MonthChart'])->name('dashboardMonth');
Route::get('/dashboards/dashboardDepartment', [ChartController::class, 'DepartmentChart'])->name('dashboardDepartment');
Route::get('/dashboards/dashboardWeek', [ChartController::class, 'WeekChart'])->name('dashboardWeek');
Route::get('/dashboards/dashboardCategory', [ChartController::class, 'CategoryChart'])->name('dashboardCategory');
Route::get('/dashboards/dashboardHotel', [ChartController::class, 'HotelChart'])->name('dashboardHotel');
Route::get('/dashboards/dashboardStatus', [ChartController::class, 'StatusChart'])->name('dashboardStatus');

Route::get('/tlcmn', [ReadController::class, 'TableReportAll'])->name('TableReportAll');
Route::get('/ehcm', [ReadController::class, 'TableReportAll'])->name('TableReportAll');;
Route::get('/uncm', [ReadController::class, 'TableReportAll'])->name('TableReportAll');;
// routes/web.php
/* Route::get('/tlcmn', [ReadController::class, 'TableReportAll'])->name('table.report.all'); */

Route::get('/filter', [PdfController::class, 'showFilterForm'])->name('filter.form');
Route::post('/filter', [PdfController::class, 'filterData'])->name('filter.data');
Route::get('/download-pdf', [PdfController::class, 'downloadPDF'])->name('download.pdf');


Route::get('/login', function () {
    return view('/login');
})->name('login');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




/* Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard'); */

/* Route::get('/test', function () {
    return view('test');
}); */

/* Route::get('/test', [AdminController::class, 'show'])->name('test'); */
/* Route::get('/user', [AdminController::class, 'tableuser'])->name("user"); */
