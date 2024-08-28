<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CreateController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ReadController;
use App\Http\Controllers\StructureController;
use App\Http\Controllers\UpdateController;
use App\Http\Controllers\UserController;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;




Route::get('/home/main', [ReadController::class, 'NumberOfCurrentStatus'])->name('main');
Route::get('/', [ReadController::class, 'NumberOfCurrentStatus'])->name('main');

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
Route::get('/reports/preview-issue/{id}', [ReadController::class, 'preview'])->name('preview-issue');

// For All Daily Report
Route::get('/daily/hotels/{type}', [ReadController::class, 'TableReportAll'])->name('TableReportAll');
/* Route::get('/tlcmn', [ReadController::class, 'TableReportAll'])->name('table.report.all'); */

// Internet Speed Checking
Route::get('/netspeed/reportNet', [ReadController::class, 'TableReportNetSpeed'])->name("reportNet");
Route::get('/netspeed/addNetSpeed', [CreateController::class, 'AddNetSpeed']);
Route::post('/insertNetSpeed', [CreateController::class, 'InsertNetSpeed']);
Route::get('/daily/hotels/{type}/updateNetSpeed/{id}', [UpdateController::class, 'UpdateReportNetSpeed'])->name('updateNetSpeed');
Route::post('/daily/hotels/{type}/updatePNetSpeed/{id}', [UpdateController::class, 'UpdateReportNetSpeedProcess'])->name('updatePNetSpeed');
Route::delete('/daily/hotels/{type}/deleteNetSpeed/{id}', [DeleteController::class, 'DeleteNetSpeed'])->name('deleteNetSpeed');

// Server Room Checking
Route::get('/server/reportServer', [ReadController::class, 'TableReportServer'])->name("reportServer");
Route::get('/server/addServer', [CreateController::class, 'AddServer'])->name('addServer');
Route::post('/insertServer', [CreateController::class, 'InsertServer']);
Route::get('/daily/hotels/{type}/updateServer/{id}', [UpdateController::class, 'UpdateServer'])->name('updateServer');
Route::post('/daily/hotels/{type}/updatePServer/{id}', [UpdateController::class, 'UpdateServerProcess'])->name('updatePserver');
Route::delete('/daily/hotels/{type}/deleteServer/{id}', [DeleteController::class, 'DeleteServer'])->name('deleteServer');

// Switch Room Checking
Route::get('/switchs/reportSwitch', [ReadController::class, 'TableReportSwitch'])->name("reportSwitch");
Route::get('/switchs/addSwitch', [CreateController::class, 'AddSwitch'])->name('addSwitch');
Route::post('/insertSwitch', [CreateController::class, 'InsertSwitch']);
Route::get('/daily/hotels/{type}/updateSwitch/{id}', [UpdateController::class, 'UpdateSwitch'])->name('updateSwitch');
Route::post('/daily/hotels/{type}/updatePSwitch/{id}', [UpdateController::class, 'UpdateSwitchProcess'])->name('updatePSwitch');
Route::delete('/daily/hotels/deleteSwitch/{id}', [DeleteController::class, 'DeleteSwitch'])->name('deleteSwitch');

// Guest Room Checking
Route::get('/guest/reportGuest', [ReadController::class, 'TableReportGuest'])->name("reportGuest");
Route::get('/guest/addGuest', [CreateController::class, 'AddGuest'])->name('addGuest');
Route::post('/insertGuest', [CreateController::class, 'InsertGuest']);
Route::get('/daily/hotels/updateGuest/{id}', [UpdateController::class, 'UpdateGuest'])->name('updateGuest');
Route::post('/daily/hotels/{type}/updatePGuest/{id}', [UpdateController::class, 'UpdateGuestProcess'])->name('updatePguest');
Route::delete('/daily/hotels/{type}/deleteGuest/{id}', [DeleteController::class, 'DeleteGuest'])->name('deleteGuest');

Route::get('/home/itsup_status/{department}', [ReadController::class, 'itsup_status'])->name('itsup_status');

// Dasboard
Route::get('/dashboards/dashboardMonth', [ChartController::class, 'MonthChart'])->name('month.chart');
Route::get('/dashboards/dashboardDepartment', [ChartController::class, 'DepartmentChart'])->name('department.chart');
Route::get('/dashboards/dashboardWeek', [ChartController::class, 'WeekChart'])->name('week.chart');
Route::get('/dashboards/dashboardCategory', [ChartController::class, 'CategoryChart'])->name('category.chart');
Route::get('/dashboards/dashboardHotel', [ChartController::class, 'HotelChart'])->name('hotel.chart');
Route::get('/dashboards/dashboardStatus', [ChartController::class, 'StatusChart'])->name('dashboardStatus');

Route::get('/filter/filter-form', [PdfController::class, 'showFilterForm'])->name('filter.form');
Route::post('/filter/filter-data', [PdfController::class, 'filterData'])->name('filter.data');
Route::get('/filter/download-pdf', [PdfController::class, 'downloadPDF'])->name('download.pdf');

// Structure
Route::get('/structure/buildings', [StructureController::class, 'buildings'])->name('structure.buildings');
Route::post('/structure/buildings', [StructureController::class, 'storeBuilding'])->name('structure.buildings.store');

Route::get('/structure/categories', [StructureController::class, 'categories'])->name('structure.categories');
Route::post('/structure/categories', [StructureController::class, 'storeCategory'])->name('structure.categories.store');

Route::get('/structure/departments', [StructureController::class, 'departments'])->name('structure.departments');
Route::post('/structure/departments', [StructureController::class, 'storeDepartment'])->name('structure.departments.store');

Auth::routes();

Route::get('/daily/search', [PdfController::class, 'search'])->name('search');
Route::get('/daily/download-pdf', [PdfController::class, 'downloadPdfDaily'])->name('download.pdfdaily');

Route::get('/users/index', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
