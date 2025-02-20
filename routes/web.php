<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\StocCategoryController;
use App\Http\Controllers\StocksController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PoPsController;
use App\Http\Controllers\IPAddressController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\RevocationController;
use App\Http\Controllers\StockReportController;
use App\Http\Controllers\DepartementController;
use App\Http\Controllers\StaffController;

use Illuminate\Support\Facades\Artisan;
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

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/clear', function () {
//     Artisan::call('config:cache');
//     Artisan::call('config:clear');
//     Artisan::call('cache:clear');
//     Artisan::call('key:generate');
//     Artisan::call('migrate');
//     return 'Cleared!!!';
// });
// Route::get('/migrate', function () {
//     Artisan::call('cache:clear');
//     Artisan::call('migrate');
//     return 'Migrate Success!!!';
// });
// Route::get('/generate', function () {
//     $user = new App\Models\User();
//     $user->password = Hash::make('123456');
//     $user->email = 'oka.rjw@gmail.com';
//     $user->username = 'administrator';
//     $user->first_name = 'Administrator';
//     $user->last_name = 'Systems';
//     $user->save();
//     return " username = 'administrator';<br> password = Hash::make('123456');<br>
//     email = 'oka.rjw@gmail.com';<br>
//     first_name = 'Administrator';<br>
//     last_name = 'Systems';<br>
//     ";
// });
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::get('actionlogin', [AuthController::class, 'login'])->name('login');
Route::post('actionlogin', [AuthController::class, 'actionlogin'])->name('actionlogin');


Route::group(['middleware' => 'auth'], function () {
    Route::get('home', [AuthController::class, 'index'])->name('home');//Dashboard
    Route::get('actionlogout', [AuthController::class, 'actionlogout'])->name('actionlogout');//Logouts

    //Leads Part
    Route::get('leads', [LeadController::class, 'index'])->name('index');
    Route::get('leads', [LeadController::class, 'index'])->name('leads.index');
    Route::get('leads/create', [LeadController::class, 'create'])->name('create');
    Route::post('leads/store', [LeadController::class, 'store'])->name('leads.store');
    Route::get('leads/view/{id}', [LeadController::class, 'view'])->name('view');
    Route::get('leads/edit/{id}', [LeadController::class, 'edit'])->name('edit');
    Route::post('leads/update/', [LeadController::class, 'update'])->name('leads.update');
    Route::get('leads/convert/{id}', [LeadController::class, 'convert'])->name('convert');
    Route::get('leads/getquote/{id}', [LeadController::class, 'getquote'])->name('leads.getquote');
    Route::get('leads/getsurvey/{id}', [LeadController::class, 'getsurvey'])->name('leads.getsurvey');
    Route::get('leads/autocomplete', [LeadController::class, 'autocomplete'])->name('leads.autocomplete');
    // Route::get('leads/view/{id}', [LeadController::class, 'contact'])->name('leads.contact');
    // Route::get('leads/contact/{id}', [LeadController::class, 'contact'])->name('leads.contact');
    
    //Account Part
    Route::get('accounts', [AccountsController::class, 'index'])->name('index');
    Route::get('accounts', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('accounts/contact/{id}', [AccountsController::class, 'contact'])->name('accounts.contact');
    Route::get('accounts/create', [AccountsController::class, 'create'])->name('create');
    Route::post('accounts/store', [AccountsController::class, 'store'])->name('accounts.store');
    Route::get('accounts/view/{id}', [AccountsController::class, 'view'])->name('view');
    //Route::get('accounts/view/{id}', [AccountsController::class, 'contact'])->name('accounts.contact');
    Route::get('accounts/edit/{id}', [AccountsController::class, 'edit'])->name('edit');
    Route::post('accounts/update/', [AccountsController::class, 'update'])->name('accounts.update');
    
    //Contacts
    Route::get('contacts', [LeadController::class, 'cindex'])->name('contacts.index');
    Route::get('contacts/create/{id?}', [LeadController::class, 'ccreate'])->name('leads.ccreate');
    //Route::get('contacts/store', [LeadController::class, 'cstore'])->name('leads.cstore');
    Route::post('contacts/store', [LeadController::class, 'cstore'])->name('leads.cstore');
    Route::get('contacts/view/{id}', [LeadController::class, 'cview'])->name('contacts.view');
    Route::get('contacts/edit/{id}', [LeadController::class, 'cedit'])->name('contacts.edit');
    Route::post('contacts/update/', [LeadController::class, 'cupdate'])->name('contacts.update');
    Route::get('contacts/getquote/{id}', [LeadController::class, 'getquote'])->name('leads.getquote');
    Route::get('contacts/getsurvey/{id}', [LeadController::class, 'getsurvey'])->name('leads.getsurvey');
    
    // Quotes
    Route::get('quotes', [QuoteController::class, 'index'])->name('index');
    Route::get('quotes', [QuoteController::class, 'index'])->name('quotes.index');
    Route::get('quotes/create/{id?}', [QuoteController::class, 'create'])->name('quotes.create');
    Route::post('quotes/store', [QuoteController::class, 'store'])->name('quotes.store');
    Route::get('quotes/view/{id}', [QuoteController::class, 'view'])->name('quotes.view');
    Route::get('quotes/edit/{id}', [QuoteController::class, 'edit'])->name('quotes.edit');
    Route::post('quotes/update/', [QuoteController::class, 'update'])->name('quotes.update');
    Route::get('quotes/approve/{id}', [QuoteController::class, 'approve'])->name('quotes.approve');
    Route::get('quotes/reject/{id}', [QuoteController::class, 'reject'])->name('quotes.reject');


    //Vendors
    Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('vendors/create', [VendorController::class, 'create'])->name('vendors.create');
    Route::post('vendors/store', [VendorController::class, 'store'])->name('vendors.store');
    Route::get('vendors/view/{id}', [VendorController::class, 'view'])->name('vendors.view');
    Route::get('vendors/edit/{id}', [VendorController::class, 'edit'])->name('edit');
    Route::post('vendors/update/', [VendorController::class, 'update'])->name('vendors.update');

    //POPs
    Route::get('pops', [PoPsController::class, 'index'])->name('pops.index');
    Route::get('pops/create', [PoPsController::class, 'create'])->name('pops.create');
    Route::post('pops/store', [PoPsController::class, 'store'])->name('pops.store');
    Route::get('pops/view/{id}', [PoPsController::class, 'view'])->name('pops.view');
    Route::get('pops/edit/{id}', [PoPsController::class, 'edit'])->name('edit');
    Route::post('pops/update/', [PoPsController::class, 'update'])->name('pops.update');

    //IP Address
    Route::get('ipaddress/{id}', [IPAddressController::class, 'index'])->name('ipaddress.index');
    Route::get('netid', [IPAddressController::class, 'netid'])->name('ipaddress.netid');
    Route::get('ipaddress/checkip/{id}', [IPAddressController::class, 'checkip'])->name('ipaddress.checkip');
    Route::get('ipaddress/create', [IPAddressController::class, 'create'])->name('ipaddress.create');
    Route::post('ipaddress/store', [IPAddressController::class, 'store'])->name('ipaddress.store');
    Route::get('ipaddress/view/{id}', [IPAddressController::class, 'view'])->name('ipaddress.view');
    Route::get('ipaddress/edit/{id}', [IPAddressController::class, 'edit'])->name('edit');
    Route::post('ipaddress/update/', [IPAddressController::class, 'update'])->name('ipaddress.update');

    //Surveys
    Route::get('surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('surveys/create/{id?}', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('surveys/store', [SurveyController::class, 'store'])->name('surveys.store');
    Route::get('surveys/view/{id}', [SurveyController::class, 'view'])->name('surveys.view');
    Route::get('surveys/edit/{id}', [SurveyController::class, 'edit'])->name('edit');
    Route::post('surveys/update/', [SurveyController::class, 'update'])->name('surveys.update');

    // Meetings
    Route::get('meetings', [MeetingController::class, 'index'])->name('index');
    Route::get('meetings', [MeetingController::class, 'index'])->name('meetings.index');
    Route::get('meetings/create/{id?}', [MeetingController::class, 'create'])->name('meetings.create');
    Route::post('meetings/store', [MeetingController::class, 'store'])->name('meetings.store');
    Route::get('meetings/view/{id}', [MeetingController::class, 'view'])->name('meetings.view');
    Route::get('meetings/edit/{id}', [MeetingController::class, 'edit'])->name('meetings.edit');
    Route::post('meetings/update/', [MeetingController::class, 'update'])->name('meetings.update');

    //Services
    Route::get('services', [ServicesController::class, 'index'])->name('services.index');
    Route::get('services/create', [ServicesController::class, 'create'])->name('services.create');
    Route::post('services/store', [ServicesController::class, 'store'])->name('services.store');
    Route::get('services/view/{id}', [ServicesController::class, 'view'])->name('services.view');
    Route::get('services/edit/{id}', [ServicesController::class, 'edit'])->name('edit');
    Route::post('services/update/', [ServicesController::class, 'update'])->name('services.update');

    //StockCategories
    Route::get('category', [StocCategoryController::class, 'index'])->name('category.index');
    Route::get('category/create', [StocCategoryController::class, 'create'])->name('category.create');
    Route::post('category/store', [StocCategoryController::class, 'store'])->name('category.store');
    Route::get('category/view/{id}', [StocCategoryController::class, 'view'])->name('category.view');
    Route::get('category/edit/{id}', [StocCategoryController::class, 'edit'])->name('edit');
    Route::post('category/update/', [StocCategoryController::class, 'update'])->name('category.update');

    //stocks/Product
    Route::get('product', [StocksController::class, 'index'])->name('stocks.index');
    Route::get('product/create', [StocksController::class, 'create'])->name('product.create');
    Route::post('product/store', [StocksController::class, 'store'])->name('product.store');
    Route::get('product/view/{id}', [StocksController::class, 'view'])->name('product.view');
    Route::get('product/edit/{id}', [StocksController::class, 'edit'])->name('edit');
    Route::post('product/update/', [StocksController::class, 'update'])->name('product.update');
    Route::get('product/getstock/{id}', [StocksController::class, 'getStock'])->name('product.getstock');

    

    // TransferIN By Order
    Route::get('order', [PurchaseOrderController::class, 'index'])->name('index');
    Route::get('order', [PurchaseOrderController::class, 'index'])->name('order.index');
    Route::get('order/create', [PurchaseOrderController::class, 'create'])->name('order.create');
    Route::post('order/store', [PurchaseOrderController::class, 'store'])->name('order.store');
    Route::get('order/view/{id}', [PurchaseOrderController::class, 'view'])->name('order.view');
    Route::get('order/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('order.edit');
    Route::post('order/update/', [PurchaseOrderController::class, 'update'])->name('order.update');

    //Transfer In
    Route::get('transfer_in', [TransferController::class, 'iindex'])->name('iindex');
    Route::get('transfer_in', [TransferController::class, 'iindex'])->name('transfer_in.iindex');
    Route::get('transfer_in/create', [TransferController::class, 'icreate'])->name('transfer_in.icreate');
    Route::post('transfer_in/icheckExist', [TransferController::class, 'icheckExist'])->name('transfer_in.icheckExist');    
    Route::post('transfer_in/store', [TransferController::class, 'istore'])->name('transfer_in.istore');
    Route::get('transfer_in/view/{id}', [TransferController::class, 'iview'])->name('transfer_in.iview');
    Route::get('transfer_in/edit/{id}', [TransferController::class, 'iedit'])->name('transfer_in.iedit');
    Route::post('transfer_in/update/', [TransferController::class, 'iupdate'])->name('transfer_in.iupdate');

    //Transfer Out
    Route::get('transfer_out', [TransferController::class, 'oindex'])->name('oindex');
    Route::get('transfer_out', [TransferController::class, 'oindex'])->name('transfer_out.oindex');
    Route::get('transfer_out/create', [TransferController::class, 'ocreate'])->name('transfer_out.ocreate');
    Route::post('transfer_out/ocheckExist', [TransferController::class, 'ocheckExist'])->name('transfer_out.ocheckExist');    
    Route::post('transfer_out/store', [TransferController::class, 'ostore'])->name('transfer_out.ostore');
    Route::get('transfer_out/view/{id}', [TransferController::class, 'oview'])->name('transfer_out.oview');
    Route::get('transfer_out/edit/{id}', [TransferController::class, 'oedit'])->name('transfer_out.oedit');
    Route::post('transfer_out/update/', [TransferController::class, 'oupdate'])->name('transfer_out.oupdate');

    //Installation
    Route::get('installasi', [InstallController::class, 'index'])->name('installasi');
    Route::get('installasi', [InstallController::class, 'index'])->name('installasi.index');
    Route::get('installasi/create/{id?}', [InstallController::class, 'create'])->name('installasi.create');  
    Route::post('installasi/store', [InstallController::class, 'store'])->name('installasi.store');
    Route::get('installasi/view/{id}', [InstallController::class, 'view'])->name('installasi.view');
    Route::get('installasi/edit/{id}', [InstallController::class, 'edit'])->name('installasi.edit');
    Route::post('installasi/update/', [InstallController::class, 'update'])->name('installasi.update');
    Route::get('installasi/process/{id}', [InstallController::class, 'process'])->name('installasi.process');
    Route::post('installasi/reprocess/', [InstallController::class, 'reprocess'])->name('installasi.reprocess');
    Route::get('installasi/finish/{id}', [InstallController::class, 'finish'])->name('installasi.finish');
    Route::post('installasi/refinish/', [InstallController::class, 'refinish'])->name('installasi.refinish');
    Route::get('installasi/printjo/{id}', [InstallController::class, 'printjo'])->name('installasi.printjo');
    Route::get('installasi/installed/{id}', [InstallController::class, 'installed'])->name('installasi.installed');
    Route::get('installasi/cancel/{id}', [InstallController::class, 'cancel'])->name('installasi.cancel');

    //Maintenance
    Route::get('maintenance', [MaintenanceController::class, 'index'])->name('maintenance');
    Route::get('maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('maintenance/create/{id?}', [MaintenanceController::class, 'create'])->name('maintenance.create');  
    Route::post('maintenance/store', [MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('maintenance/view/{id}', [MaintenanceController::class, 'view'])->name('maintenance.view');
    Route::get('maintenance/edit/{id}', [MaintenanceController::class, 'edit'])->name('maintenance.edit');
    Route::post('maintenance/update/', [MaintenanceController::class, 'update'])->name('maintenance.update');
    Route::get('maintenance/process/{id}', [MaintenanceController::class, 'process'])->name('maintenance.process');
    Route::post('maintenance/reprocess/', [MaintenanceController::class, 'reprocess'])->name('maintenance.reprocess');
    Route::get('maintenance/finish/{id}', [MaintenanceController::class, 'finish'])->name('maintenance.finish');
    Route::post('maintenance/refinish/', [MaintenanceController::class, 'refinish'])->name('maintenance.refinish');
    Route::get('maintenance/printjo/{id}', [MaintenanceController::class, 'printjo'])->name('maintenance.printjo');
    Route::get('maintenance/installed/{id}', [MaintenanceController::class, 'installed'])->name('maintenance.installed');
    Route::get('maintenance/cancel/{id}', [MaintenanceController::class, 'cancel'])->name('maintenance.cancel');

    //Revocation
    Route::get('revocation', [RevocationController::class, 'index'])->name('revocation');
    Route::get('revocation', [RevocationController::class, 'index'])->name('revocation.index');
    Route::get('revocation/create/{id?}', [RevocationController::class, 'create'])->name('revocation.create');  
    Route::post('revocation/store', [RevocationController::class, 'store'])->name('revocation.store');
    Route::get('revocation/view/{id}', [RevocationController::class, 'view'])->name('revocation.view');
    Route::get('revocation/edit/{id}', [RevocationController::class, 'edit'])->name('revocation.edit');
    Route::post('revocation/update/', [RevocationController::class, 'update'])->name('revocation.update');
    Route::get('revocation/process/{id}', [RevocationController::class, 'process'])->name('revocation.process');
    Route::post('revocation/reprocess/', [RevocationController::class, 'reprocess'])->name('revocation.reprocess');
    Route::get('revocation/finish/{id}', [RevocationController::class, 'finish'])->name('revocation.finish');
    Route::post('revocation/refinish/', [RevocationController::class, 'refinish'])->name('revocation.refinish');
    Route::get('revocation/printjo/{id}', [RevocationController::class, 'printjo'])->name('revocation.printjo');
    Route::get('revocation/installed/{id}', [RevocationController::class, 'installed'])->name('revocation.installed');
    Route::get('revocation/cancel/{id}', [RevocationController::class, 'cancel'])->name('revocation.cancel');
    Route::get('revocation/checkCustomer/{id}', [RevocationController::class, 'checkCustomer'])->name('revocation.checkCustomer');

    //Inventory Report
    Route::get('invreport', [StockReportController::class, 'invreport'])->name('report.invreport');//All Stock Position



    //Departement

    Route::get('departement', [DepartementController::class, 'index'])->name('departement.index');
    Route::get('departement/create', [DepartementController::class, 'create'])->name('departement.create');
    Route::post('departement/store', [DepartementController::class, 'store'])->name('departement.store');
    Route::get('departement/view/{id}', [DepartementController::class, 'view'])->name('departement.view');
    Route::get('departement/edit/{id}', [DepartementController::class, 'edit'])->name('edit');
    Route::post('departement/update/', [DepartementController::class, 'update'])->name('departement.update');

    //Staff
    Route::get('staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('staff/store', [StaffController::class, 'store'])->name('staff.store');
    Route::get('staff/view/{id}', [StaffController::class, 'view'])->name('staff.view');
    Route::get('staff/edit/{id}', [StaffController::class, 'edit'])->name('edit');
    Route::post('staff/update/', [StaffController::class, 'update'])->name('staff.update');
});
