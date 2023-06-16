<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AccountsController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\QuoteController;
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
    // Route::get('leads/view/{id}', [LeadController::class, 'contact'])->name('leads.contact');
    // Route::get('leads/contact/{id}', [LeadController::class, 'contact'])->name('leads.contact');
    
    //Account Part
    Route::get('accounts', [AccountsController::class, 'index'])->name('index');
    Route::get('accounts', [AccountsController::class, 'index'])->name('accounts.index');
    Route::get('accounts/contact/{id}', [AccountsController::class, 'contact'])->name('accounts.contact');
    Route::get('accounts/create', [AccountsController::class, 'create'])->name('create');
    Route::post('accounts/store', [AccountsController::class, 'store'])->name('accounts.store');
    Route::get('accounts/view/{id}', [AccountsController::class, 'view'])->name('view');
    Route::get('accounts/view/{id}', [AccountsController::class, 'contact'])->name('accounts.contact');
    Route::get('accounts/edit/{id}', [AccountsController::class, 'edit'])->name('edit');
    Route::post('accounts/update/', [AccountsController::class, 'update'])->name('accounts.update');
    
    //Contacts
    Route::get('contacts', [LeadController::class, 'cindex'])->name('contacts.cindex');
    Route::get('contacts/view/{id}', [LeadController::class, 'cview'])->name('contacts.cview');
    Route::get('contacts/edit/{id}', [LeadController::class, 'cedit'])->name('edit');
    Route::post('contacts/update/', [LeadController::class, 'cupdate'])->name('contacts.cupdate');

    // Quotes
    Route::get('quotes', [QuoteController::class, 'index'])->name('index');
    Route::get('quotes', [QuoteController::class, 'index'])->name('quotes.index');
    Route::get('quotes/create/{id?}', [QuoteController::class, 'create'])->name('quotes.create');
    Route::post('quotes/store', [QuoteController::class, 'store'])->name('quotes.store');
    Route::get('quotes/view/{id}', [QuoteController::class, 'view'])->name('quotes.view');
    Route::get('quotes/edit/{id}', [QuoteController::class, 'edit'])->name('quotes.edit');
    Route::post('quotes/update/', [QuoteController::class, 'update'])->name('quotes.update');
});
