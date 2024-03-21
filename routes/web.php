<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealContactController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\DealStageController;
use App\Http\Controllers\DealTaskController;
use App\Http\Controllers\DealTypeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\LeadEmailController;
use App\Http\Controllers\LeadFileController;
use App\Http\Controllers\LeadMeetingController;
use App\Http\Controllers\LeadTaskController;
use App\Http\Controllers\PipelineController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\ProductServiceController;
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



Route::get('/', [DashboardController::class, 'index'])->name('start');
Route::get('/dashboard', [DashboardController::class, 'Dashboard'])->middleware(['auth', 'verified'])->name('dashboard');
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
    Route::post('/leads/{id}/file', [LeadController::class, 'fileUpload'])->name('leads.file.upload');
    Route::resource('leads', LeadController::class);
    // lead call
    Route::get('/leadcallCreate/{id}', [LeadController::class, 'leadcallCreate'])->name('leadcallCreate');
    Route::post('/leadcallStore/{id}', [LeadController::class, 'leadcallStore'])->name('leadcallStore');
    Route::get('/leads/{id}/call/{cid}/edit', [LeadController::class, 'leadcallEdit'])->name('leadcallEdit');
    Route::put('/leads/{id}/call/{cid}', [LeadController::class, 'leadcallUpdate'])->name('leadcallUpdate');
    Route::delete('/leadcallDestroy/{id}/call/{cid}', [LeadController::class, 'leadcallDestroy'])->name('leadcallDestroy');
    Route::get('/leadContactAssign/{id}', [LeadController::class, 'leadContactAssign'])->name('leadContactAssign');
    Route::put('/LeadContactUpdate/{id}', [LeadController::class, 'LeadContactUpdate'])->name('LeadContactUpdate');

    // lead meeting
    Route::get('/leadmeetingCreate/{id}', [LeadMeetingController::class, 'create'])->name('leadmeetingCreate');
    Route::post('/leadmeetingStore/{id}', [LeadMeetingController::class, 'store'])->name('leadmeetingStore');
    Route::get('/leads/{id}/meeting/{cid}/edit', [LeadMeetingController::class, 'edit'])->name('leadmeetingEdit');
    Route::put('/leads/{id}/meeting/{cid}', [LeadMeetingController::class, 'update'])->name('leadmeetingUpdate');
    Route::delete('/leadmeetingDestroy/{id}/meeting/{cid}', [LeadMeetingController::class, 'destroy'])->name('leadmeetingDestroy');

    // Lead task
    Route::get('/lead/{id}/task', [LeadTaskController::class, 'create'])->name('lead.tasks.create');
    Route::post('/lead/{id}/task', [LeadTaskController::class, 'store'])->name('lead.tasks.store');
    Route::get('/lead/{id}/task/{tid}/show', [LeadTaskController::class, 'show'])->name('lead.tasks.show');
    Route::get('/lead/{id}/task/{tid}/edit', [LeadTaskController::class, 'edit'])->name('lead.tasks.edit');
    Route::put('/lead/{id}/task/{tid}', [LeadTaskController::class, 'update'])->name('lead.tasks.update');
    Route::delete('/lead/{id}/task/{tid}', [LeadTaskController::class, 'destroy'])->name('lead.tasks.destroy');
    Route::put('/lead/{id}/task_status/{tid}', [LeadTaskController::class, 'taskUpdateStatus'])->name('lead.tasks.update_status');

    // lead Email
    Route::get('/lead/{id}/email', [LeadEmailController::class, 'emailCreate'])->name('leademailCreate');
    Route::post('/lead/{id}/email', [LeadEmailController::class, 'emailStore'])->name('leademailStore');

    // Lead file
    Route::post('/fileUpload/{id}', [LeadFileController::class, 'fileUpload'])->name('leadfileUpload');
    Route::delete('/lead/{id}/file/delete/{fid}', [LeadFileController::class, 'fileDelete'])->name('leadfileDelete');

    // lead lable
    Route::post('/lead/{id}/labels', [LeadController::class, 'labelStore'])->name('lead.labels.store');
    Route::get('/lead/{id}/labels', [LeadController::class, 'labels'])->name('lead.labels');

    // deal
    Route::resource('deals', DealController::class);
    Route::resource('deal-stages', DealStageController::class);
    Route::post('/deal_stages/order', [DealStageController::class, 'order'])->name('deal-stages.order');
    Route::get('/deals/{id}/task/{tid}/show', [DealController::class, 'taskShow'])->name('deals.tasks.show');
    Route::post('/deals/{id}/note', [DealController::class, 'noteStore'])->name('deals.note.store');
    Route::get('/deals/{id}/discussions', [DealController::class, 'discussionCreate'])->name('deals.discussions.create');
    Route::post('/deals/change-deal-status/{id}', [DealController::class, 'changeStatus'])->name('deals.change.status');
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
    Route::post('/deals/{id}/file', [DealController::class, 'fileUpload'])->name('deals.file.upload');
    Route::delete('/deals/{id}/file/delete/{fid}', [DealController::class, 'fileDelete'])->name('fileDelete');

    // Deal task
    Route::get('/deals/{id}/task', [DealTaskController::class, 'taskCreate'])->name('deals.tasks.create');
    Route::post('/deals/{id}/task', [DealTaskController::class, 'taskStore'])->name('deals.tasks.store');
    Route::get('/deals/{id}/task/{tid}/show', [DealTaskController::class, 'taskShow'])->name('deals.tasks.show');
    Route::get('/deals/{id}/task/{tid}/edit', [DealTaskController::class, 'taskEdit'])->name('deals.tasks.edit');
    Route::put('/deals/{id}/task/{tid}', [DealTaskController::class, 'taskUpdate'])->name('deals.tasks.update');
    Route::delete('/deals/{id}/task/{tid}', [DealTaskController::class, 'taskDestroy'])->name('deals.tasks.destroy');
    Route::put('/deals/{id}/task_status/{tid}', [DealTaskController::class, 'taskUpdateStatus'])->name('deals.tasks.update_status');

    // deal lable
    Route::post('/deals/{id}/labels', [DealController::class, 'labelStore'])->name('deals.labels.store');
    Route::get('/deals/{id}/labels', [DealController::class, 'labels'])->name('deals.labels');
    // labels
    Route::resource('dealcontact', DealContactController::class);
    Route::resource('dealtypes', DealTypeController::class);
    Route::resource('labels', LabelController::class);
    Route::resource('pipelines', PipelineController::class);
    Route::post('/leadnoteStore/{id}', [LeadController::class, 'LeadnoteStore'])->name('leadnoteStore');




    // HRM start
    // branch
    Route::resource('branch', BranchController::class);
    Route::get('branchnameedit', [BranchController::class, 'BranchNameEdit'])->name('branchname.edit');
    Route::post('branch-settings', [BranchController::class, 'saveBranchName'])->name('branchname.update');
    // department
    Route::resource('department', DepartmentController::class);
    Route::get('departmentnameedit', [DepartmentController::class, 'DepartmentNameEdit'])->name('departmentname.edit');
    Route::post('department-settings', [DepartmentController::class, 'saveDepartmentName'])->name('departmentname.update');
    // designation
    Route::resource('designation', DesignationController::class);
    Route::get('designationnameedit', [DesignationController::class, 'DesignationNameEdit'])->name('designationname.edit');
    Route::post('designation-settings', [DesignationController::class, 'saveDesignationName'])->name('designationname.update');
    // employee
    Route::resource('employee', 'EmployeeController');
    Route::post('employee/getdepartment', 'EmployeeController@getDepartment')->name('employee.getdepartment');
    Route::post('employee/getdesignation', 'EmployeeController@getdDesignation')->name('employee.getdesignation');
    // HRM end

    // contacts
    Route::resource('contacts', ContactController::class);

    // contacts
    Route::resource('coupons', CouponController::class);

    // product
    Route::resource('products',ProductServiceController::class);
});

// Route::post('/beauty-spa-pay-with-stripe/{slug?}', [StripePaymentController::class,'BeautySpaPayWithStripe'])->name('beauty.spa.pay.with.stripe');

// Route::post('email-settings', [SettingController::class, 'saveEmailSettings'])->name('email.settings')->middleware(['auth', 'XSS']);

require __DIR__ . '/auth.php';
