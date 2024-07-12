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
Route::get('/netspeed/addNetSpeed', [CreateController::class, 'AddNetSpeed']);
Route::post('/insertNetSpeed', [CreateController::class, 'InsertNetSpeed']);
Route::get('/{type}/updateNetSpeed/{id}', [UpdateController::class, 'UpdateReportNetSpeed'])->name('updateNetSpeed');
Route::post('/{type}/updatePNetSpeed/{id}', [UpdateController::class, 'UpdateReportNetSpeedProcess'])->name('updatePNetSpeed');
Route::delete('/deleteNetSpeed/{id}', [DeleteController::class, 'Tlcmn_DeleteNetSpeed'])->name('deleteNetSpeed');

// Server Room Checking
Route::get('/server/reportServer', [ReadController::class, 'TableReportServer'])->name("reportServer");
Route::get('/server/addServer', [CreateController::class, 'AddServer'])->name('addServer');
Route::post('/insertServer', [CreateController::class, 'InsertServer']);
Route::get('/{type}/updateServer/{id}', [UpdateController::class, 'UpdateServer'])->name('updateServer');
Route::post('/{type}/updatePServer/{id}', [UpdateController::class, 'UpdateServerProcess'])->name('updatePserver');
Route::delete('/deleteServer/{id}', [DeleteController::class, 'Tlcmn_DeleteServer'])->name('deleteServer');

// Switch Room Checking
Route::get('/switchs/reportSwitch', [ReadController::class, 'TableReportSwitch'])->name("reportSwitch");
Route::get('/switchs/addSwitch', [CreateController::class, 'AddSwitch'])->name('addSwitch');
Route::post('/insertSwitch', [CreateController::class, 'InsertSwitch']);
Route::get('/{type}/updateSwitch/{id}', [UpdateController::class, 'UpdateSwitch'])->name('updateSwitch');
Route::post('/{type}/updatePSwitch/{id}', [UpdateController::class, 'UpdateSwitchProcess'])->name('updatePSwitch');
Route::delete('/deleteSwitch/{id}', [DeleteController::class, 'Tlcmn_DeleteSwitch'])->name('deleteSwitch');

// Guest Room Checking
Route::get('/guest/reportGuest', [ReadController::class, 'TableReportGuest'])->name("reportGuest");
Route::get('/guest/addGuest', [CreateController::class, 'AddGuest'])->name('addGuest');
Route::post('/insertGuest', [CreateController::class, 'InsertGuest']);
Route::get('/{type}/updateGuest/{id}', [UpdateController::class, 'UpdateGuest'])->name('updateGuest');
Route::post('/{type}/updatePGuest/{id}', [UpdateController::class, 'UpdateGuestProcess'])->name('updatePguest');
Route::delete('/deleteGuest/{id}', [DeleteController::class, 'Tlcmn_DeleteGuest'])->name('deleteGuest');

// Home page s
/* Route::get('/home/itsup_status', [ReadController::class, 'itsup_status']); */
// web.php

Route::get('/home/itsup_status/{department}', [ReadController::class, 'itsup_status'])->name('itsup_status');

Route::get('/home/admin_status', [ReadController::class, 'admin_status']);

// Dasboard
Route::get('/dashboards/dashboardMonth', [ChartController::class, 'MonthChart'])->name('month.chart');
Route::get('/dashboards/dashboardDepartment', [ChartController::class, 'DepartmentChart'])->name('department.chart');
Route::get('/dashboards/dashboardWeek', [ChartController::class, 'WeekChart'])->name('week.chart');
Route::get('/dashboards/dashboardCategory', [ChartController::class, 'CategoryChart'])->name('category.chart');
Route::get('/dashboards/dashboardHotel', [ChartController::class, 'HotelChart'])->name('hotel.chart');
Route::get('/dashboards/dashboardStatus', [ChartController::class, 'StatusChart'])->name('dashboardStatus');

Route::get('/{type}', [ReadController::class, 'TableReportAll'])->name('TableReportAll');
// routes/web.php
/* Route::get('/tlcmn', [ReadController::class, 'TableReportAll'])->name('table.report.all'); */

Route::get('/filter/filter-form', [PdfController::class, 'showFilterForm'])->name('filter.form');
Route::post('/filter/filter-data', [PdfController::class, 'filterData'])->name('filter.data');
Route::get('/filter/download-pdf', [PdfController::class, 'downloadPDF'])->name('download.pdf');
Route::get('/reports/preview-issue/{id}', [ReadController::class, 'preview'])->name('preview-issue');


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
