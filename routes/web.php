<?php

use App\Http\Controllers\DashboardController;
<<<<<<< Updated upstream
use App\Http\Controllers\LeadController;
=======
use App\Http\Controllers\DealController;
>>>>>>> Stashed changes
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Models\Setting;
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

Route::get('/cacheclear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('route:cache');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    // dd("Done");
    return response()->json(["message" => "Cache clear", "status" => true]);
});



Route::get('/', [DashboardController::class,'index'])->name('start');
Route::get('/dashboard',[DashboardController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
// Route::get('/dashboard', function () {
//     return view('dashboard');
// });
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // user
    Route::resource('users', UserController::class);

    // settings
    Route::resource('setting', SettingController::class);
    Route::post('email-settings', [SettingController::class, 'SaveEmailSetting'])->name('email.settings');
    Route::post('theme-setting', [SettingController::class, 'ThemeSetting'])->name('theme.setting');


    // role
    Route::resource('roles', RoleController::class);

    // plan
    Route::resource('plans', PlanController::class);
    Route::get('plan-subscribe/{id}', [PlanController::class, 'PlanSubscripe'])->name('plan.subscribe');

    // lead
    Route::get('leads/grid', [LeadController::class, 'GridView'])->name('leads.grid');
    Route::resource('leads', LeadController::class);
    // deal
    Route::resource('deals', DealController::class);


});


// Route::post('email-settings', [SettingController::class, 'saveEmailSettings'])->name('email.settings')->middleware(['auth', 'XSS']);

require __DIR__.'/auth.php';
