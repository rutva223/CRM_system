<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealContactController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DealStageController;
use App\Http\Controllers\DealTaskController;
use App\Http\Controllers\DealTypeController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\StripePaymentController;
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
    Route::post('change-password', [UserController::class, 'updatePassword'])->name('update.password');

    // settings
    Route::resource('setting', SettingController::class);
    Route::post('email-settings', [SettingController::class, 'SaveEmailSetting'])->name('email.settings');
    Route::post('payment.settings', [SettingController::class, 'PaymentSetting'])->name('payment.settings');
    Route::post('theme-setting', [SettingController::class, 'ThemeSetting'])->name('theme.setting');


    // role
    Route::resource('roles', RoleController::class);

    // plan
    Route::resource('plans', PlanController::class);
    // Route::get('plan-subscribe/{id}', [PlanController::class, 'PlanSubscripe'])->name('plan.subscribe');

    // stripe
    Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');
    Route::get('/stripe-payment-status', [StripePaymentController::class, 'planGetStripePaymentStatus'])->name('stripe.payment.status');

    // contacts
    Route::resource('contacts', ContactController::class);

    // contacts
    Route::resource('coupons', CouponController::class);

    // lead
    Route::get('leads/grid', [LeadController::class, 'GridView'])->name('leads.grid');
    Route::resource('leads', LeadController::class);

    // deal
    Route::resource('deals', DealController::class);
    Route::resource('deal-stages', DealStageController::class);
    Route::post('/deal_stages/order', [DealStageController::class, 'order'])->name('deal-stages.order');
    Route::get('/deals/{id}/task/{tid}/show', [DealController::class, 'taskShow'])->name('deals.tasks.show');
    Route::post('/deals/{id}/file', [DealController::class, 'fileUpload'])->name('deals.file.upload');
    Route::post('/deals/{id}/note', [DealController::class, 'noteStore'])->name('deals.note.store');
    Route::get('/deals/{id}/discussions', [DealController::class, 'discussionCreate'])->name('deals.discussions.create');
    Route::post('/deals/change-deal-status/{id}', [DealController::class, 'changeStatus'])->name('deals.change.status');
    Route::get('/deals/{id}/task', [DealController::class, 'taskCreate'])->name('deals.tasks.create');
    Route::get('/deals/{id}/users', [DealController::class, 'userEdit'])->name('deals.users.edit');
    Route::delete('/deals/{id}/users/{uid}', [DealController::class, 'userDestroy'])->name('deals.users.destroy');
    Route::get('/deals/{id}/products', [DealController::class, 'productEdit'])->name('deals.products.edit');
    Route::get('/deals/{id}/sources', [DealController::class, 'sourceEdit'])->name('deals.sources.edit');
    Route::get('/deals/{id}/clients', [DealController::class, 'clientEdit'])->name('deals.clients.edit');
    Route::delete('/deals/{id}/clients/{uid}', [DealController::class, 'clientDestroy'])->name('deals.clients.destroy');
    Route::post('/deals/change-pipeline', [DealController::class, 'changePipeline'])->name('deals.change.pipeline');
    Route::post('/deals/order', [DealController::class, 'order'])->name('deals.order');
    Route::post('deal/import/export', [DealController::class, 'fileImportExport'])->name('deal.file.import');
    Route::post('/stages/json', [DealStageController::class, 'json'])->name('stages.json');
    Route::get('/ContactAssign/{id}', [DealController::class, 'ContactAssign'])->name('ContactAssign');
    Route::put('/DealContactUpdate/{id}', [DealController::class, 'DealContactUpdate'])->name('DealContactUpdate');
    Route::post('/noteStore/{id}', [DealController::class, 'noteStore'])->name('noteStore');
    // deal call
    Route::get('/callCreate/{id}', [DealController::class, 'callCreate'])->name('callCreate');
    Route::post('/callStore/{id}', [DealController::class, 'callStore'])->name('callStore');
    Route::get('/deals/{id}/call/{cid}/edit', [DealController::class, 'callEdit'])->name('callEdit');
    Route::put('/deals/{id}/call/{cid}', [DealController::class, 'callUpdate'])->name('callUpdate');
    Route::delete('/callDestroy/{id}/call/{cid}', [DealController::class, 'callDestroy'])->name('callDestroy');

    // deal meeting
    Route::get('/meetingCreate/{id}', [DealController::class, 'meetingCreate'])->name('meetingCreate');
    Route::post('/meetingStore/{id}', [DealController::class, 'meetingStore'])->name('meetingStore');
    Route::get('/deals/{id}/meeting/{cid}/edit', [DealController::class, 'meetingEdit'])->name('meetingEdit');
    Route::put('/deals/{id}/meeting/{cid}', [DealController::class, 'meetingUpdate'])->name('meetingUpdate');
    Route::delete('/meetingDestroy/{id}/meeting/{cid}', [DealController::class, 'meetingDestroy'])->name('meetingDestroy');
    // Deal Email
    Route::get('/deals/{id}/email', [DealController::class, 'emailCreate'])->name('emailCreate');
    Route::post('/deals/{id}/email', [DealController::class, 'emailStore'])->name('emailStore');
    // Deal file
    Route::post('/fileUpload/{id}', [DealController::class, 'fileUpload'])->name('fileUpload');
    Route::delete('/deals/{id}/file/delete/{fid}', [DealController::class, 'fileDelete'])->name('fileDelete');

    // Deal task
    Route::get('/deals/{id}/task',[DealTaskController::class,'taskCreate'])->name('deals.tasks.create');
    Route::post('/deals/{id}/task',[DealTaskController::class,'taskStore'])->name('deals.tasks.store');
    Route::get('/deals/{id}/task/{tid}/show',[DealTaskController::class,'taskShow'])->name('deals.tasks.show');
    Route::get('/deals/{id}/task/{tid}/edit',[DealTaskController::class,'taskEdit'])->name('deals.tasks.edit');
    Route::put('/deals/{id}/task/{tid}',[DealTaskController::class,'taskUpdate'])->name('deals.tasks.update');
    Route::put('/deals/{id}/task_status/{tid}',[DealTaskController::class,'taskUpdateStatus'])->name('deals.tasks.update_status');
    // labels
    Route::resource('dealcontact', DealContactController::class);
    Route::resource('dealtypes', DealTypeController::class);
    Route::resource('labels', LabelController::class);
    Route::resource('pipelines', PipelineController::class);

    // contacts
    Route::resource('contacts', ContactController::class);

    // contacts
    Route::resource('coupons', CouponController::class);
});

// Route::post('/beauty-spa-pay-with-stripe/{slug?}', [StripePaymentController::class,'BeautySpaPayWithStripe'])->name('beauty.spa.pay.with.stripe');

// Route::post('email-settings', [SettingController::class, 'saveEmailSettings'])->name('email.settings')->middleware(['auth', 'XSS']);

require __DIR__.'/auth.php';
