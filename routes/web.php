<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Customers_Report;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceArchive;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\Invoices_Report;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\InvoicesDetailsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SectionsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


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

Route::get('/dashboard',[HomeController::class,'index'] )
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::middleware('auth')->group(function () {
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);
});

// Route::resource('invoices', InvoicesController::class);
Route::get('invoices', [InvoicesController::class,'index']);
Route::get('invoices/create', [InvoicesController::class,'create']);
Route::post('invoices/store', [InvoicesController::class,'store'])->name('invoices.store');
Route::get('edit/{id}', [InvoicesController::class,'edit']);
Route::delete('invoices/{invoice}', [InvoicesController::class,'destroy'])->name('invoices.destroy');






Route::resource('archive', InvoiceArchive::class);
Route::resource('sections', SectionsController::class);
Route::resource('products', ProductsController::class);
Route::post('Archive/update', [InvoiceArchive::class,'update']);
Route::get('archiveDetails/{id}', [InvoiceArchive::class,'show']);
Route::get('/section/{id}',[InvoicesController::class,'getproducts']);
Route::get('invoiceDetails/{id}',[InvoicesDetailsController::class,'edit'])->name('invoiceDetails');
Route::get('View_file/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'open_file']);

Route::get('download/{invoice_number}/{file_name}',[InvoicesDetailsController::class,'download']);

Route::post('delete_file',[InvoicesDetailsController::class,'destroy']);
Route::post('Status_Update/{id}',[InvoicesController::class,'Status_Update'])->name('Status_Update');
Route::get('Status_show/{id}',[InvoicesController::class,'show']);
Route::post('InvoiceAttachments',[InvoiceAttachmentsController::class,'store']);
Route::post('update',[InvoicesController::class,'update']);
Route::get('invoices_paid',[InvoicesController::class,'invoices_paid']);
Route::get('invoices_unpaid',[InvoicesController::class,'invoices_unpaid']);
Route::get('invoices_Partial',[InvoicesController::class,'invoices_Partial']);
Route::get('Print_invoice/{id}',[InvoicesController::class,'Print_invoice']);
Route::get('markasRead_all',[InvoicesController::class,'markasRead_all'])->name('markasRead_all');

Route::get('invoices_report',[Invoices_Report::class, 'index']);
Route::post('/Search_invoices',[Invoices_Report::class, 'search']);

Route::get('customer_report',[Customers_Report::class, 'index']);
Route::post('/Search_customers',[Customers_Report::class, 'search']);

require __DIR__.'/auth.php';
Route::get('/{page}', [AdminController::class,'index']);