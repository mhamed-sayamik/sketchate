<?php

use App\Http\Controllers\Auth\RedirectAuthenticatedUsersController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ProfileController;
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

Route::get("/redirectAuthenticatedUsers", [RedirectAuthenticatedUsersController::class, "home"]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','checkRole:client'])->group(function () {
    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/client/new-project', [ClientController::class, 'newProject'])->name('client.new-project');
    Route::post('/client/new-project', [ClientController::class, 'storeProject']);
    Route::get('/client/projects/{id}', [ClientController::class, 'project'])->name('client.project');
    Route::get('/client/projects/{id}/details', [ClientController::class, 'projectDetails']);
    Route::get('/client/projects/{id}/plot', [ClientController::class, 'downloadPlot']);
    Route::get('/client/projects/{id}/{company_id}/company_file', [ClientController::class, 'downloadCompanyFile']);
    Route::get('/client/projects/{id}/{company_id}/contract_file', [ClientController::class, 'downloadContract'])->name('clientt.contract');
    Route::get('/client/projects/{id}/{company_id}/choose_offer', [ClientController::class, 'chooseOffer']);
    Route::post('/client/new-project', [ClientController::class, 'storeProject']);
});


Route::middleware(['auth','checkRole:company'])->group(function () {
    Route::get('/company/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');
    Route::get('/company/projects', [CompanyController::class, 'projects'])->name('company.projects');
    Route::post('/company/projects', [CompanyController::class, 'buyProject']);
    Route::get('/company/projects/{id}', [CompanyController::class, 'project'])->name('company.project');
    Route::get('/company/projects/{id}/plot', [CompanyController::class, 'downloadPlot']);
    Route::get('/company/projects/{id}/contract_file', [CompanyController::class, 'downloadContract']);
    Route::get('/company/projects/{id}/send-offer', [CompanyController::class, 'sendOfferShow'])->name('company.send-offer');
    Route::post('/company/projects/{id}/send-offer', [CompanyController::class, 'sendOffer']);

});
//to delete
Route::get('/dashboard')->name('register');

require __DIR__.'/auth.php';
