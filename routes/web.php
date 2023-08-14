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

    //Surveys
    Route::get('surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
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

    

    // Porchase Order
    Route::get('order', [PurchaseOrderController::class, 'index'])->name('index');
    Route::get('order', [PurchaseOrderController::class, 'index'])->name('order.index');
    Route::get('order/create/{id?}', [PurchaseOrderController::class, 'create'])->name('order.create');
    Route::post('order/store', [PurchaseOrderController::class, 'store'])->name('order.store');
    Route::get('order/view/{id}', [PurchaseOrderController::class, 'view'])->name('order.view');
    Route::get('order/edit/{id}', [PurchaseOrderController::class, 'edit'])->name('order.edit');
    Route::post('order/update/', [PurchaseOrderController::class, 'update'])->name('order.update');

});
