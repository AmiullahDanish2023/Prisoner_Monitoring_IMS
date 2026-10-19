<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ReleaseController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\LivelihoodPlanController;
use App\Http\Controllers\ReleaseSourceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\suspectController;
use App\Http\Controllers\BillController;

use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

// Route::get('/',  [WelcomeController::class, 'welcome'])->middleware(['setlocale'])->name('welcome');

Route::get('/', function () {
    return view('auth.login');
})->name('login');


Auth::routes();

Route::get('en', [LanguageController::class, 'en'])->name('en');
Route::get('fa', [LanguageController::class, 'fa'])->name('fa');
Route::get('pa', [LanguageController::class, 'pa'])->name('pa');

// Change the Landing page Localization
Route::get('site/en', [WelcomeController::class, 'en'])->name('site.en');
Route::get('site/fa', [WelcomeController::class, 'fa'])->name('site.fa');
Route::get('site/pa', [WelcomeController::class, 'pa'])->name('site.pa');



Route::get('/home', [HomeController::class, 'index'])->middleware(['auth', 'setlocale'])->name('home');
// Route::get('/home', [HomeController::class, 'indexe'])->name('homee');

Route::get('/get-referring-authorities', [SuspectController::class, 'getAuthorities']);


# --------------------------------- Users Routes -------------------------------------------------------------------
Route::get('users', [UserController::class, 'index'])->middleware(['auth', 'setlocale'])->name('users.index');
Route::post('users-store', [UserController::class, 'store'])->middleware(['auth', 'setlocale'])->name('users.store');
Route::post('users-update', [UserController::class, 'update'])->middleware(['auth', 'setlocale'])->name('users.update');
Route::get('user-delete/{id}', [UserController::class, 'destroy'])->middleware(['auth', 'setlocale'])->name('users.delete');
Route::get('profile', [UserController::class, 'profile'])->middleware(['auth', 'setlocale'])->name('profile');
Route::post('update/profile', [UserController::class, 'update_profile'])->middleware(['auth', 'setlocale'])->name('update.profile');
Route::post('change_password', [UserController::class, 'change_password'])->middleware(['auth', 'setlocale'])->name('change-user-password');
Route::get('users/roles', [UserController::class, 'roles'])->middleware(['auth', 'setlocale'])->name('user.roles');
Route::post('users/role-store', [UserController::class, 'role_store'])->middleware(['auth', 'setlocale'])->name('role.store');
Route::get('users/role-edit', [UserController::class, 'role_edit'])->middleware(['auth', 'setlocale'])->name('role.edit');
Route::post('users/role-update', [UserController::class, 'role_update'])->middleware(['auth', 'setlocale'])->name('role.update');
# --------------------------------- End Users Routes ------------------------------------------------------------------


Route::get('/suspects/{id}/files', [SuspectController::class, 'showFiles'])->name('suspects.files');
Route::get('/suspects/{id}/release-files', [SuspectController::class, 'releaseFiles'])->name('suspects.release.files');



# --------------------------------- suspects Routes -------------------------------------------------------------------
route::get('suspects', [suspectController::class, 'index'])->middleware(['auth', 'setlocale'])->name('suspects.index');
route::post('suspects/store', [suspectController::class, 'store'])->middleware(['auth', 'setlocale'])->name('suspects.store');
Route::get('suspects/list', [SuspectController::class, 'show'])->name('suspects.list')->middleware(['auth', 'setlocale']);
Route::get('suspects/edit/{id}', [SuspectController::class, 'edit'])->name('suspects.edit')->middleware(['auth', 'setlocale']);
Route::post('suspects/update/{id}', [SuspectController::class, 'update'])->name('suspects.update')->middleware(['auth', 'setlocale']);
Route::get('suspects/destroy/{id}', [SuspectController::class, 'destroy'])->name('suspects.destroy')->middleware(['auth', 'setlocale']);
Route::get('/suspects/details/{id}', [SuspectController::class, 'details'])->name('details')->middleware(['auth', 'setlocale']);

Route::get('/suspects/{id}/notes-pdf', [SuspectController::class, 'notesPdf'])->name('suspects.notes.pdf');
Route::get('/suspects/{id}/release/notes-pdf', [SuspectController::class, 'releaseNotesPdf'])->name('suspects.release.notes.pdf');


//Release Routes
Route::get('/suspects/release', [ReleaseController::class, 'releaseSuspect'])->name('suspects.release')->middleware(['auth', 'setlocale']);
Route::get('release/list', [ReleaseController::class, 'show'])->name('release.list')->middleware(['auth', 'setlocale']);
Route::post('/suspects/release/store', [ReleaseController::class, 'release'])->name('release.store')->middleware(['auth', 'setlocale']);
Route::get('release/destroy/{id}', [ReleaseController::class, 'destroy'])->name('release.destroy')->middleware(['auth', 'setlocale']);
Route::get('/release/details/{id}', [ReleaseController::class, 'details'])->name('release_details')->middleware(['auth', 'setlocale']);




//Release Source Routes
Route::middleware(['auth'])->group(function () {

    Route::resource('release-sources', ReleaseSourceController::class)->only(['index', 'create', 'store']);
});

Route::get('release-sources/show', [ReleaseSourceController::class, 'show'])->name('release-sources.show');
Route::get('release-sources/delete/{id}', [ReleaseSourceController::class, 'deleteSource'])->name('release-sources.delete');
Route::post('/release-sources/update/{id}', [ReleaseSourceController::class, 'updateSource'])->name('release-sources.update');



//------------------------------------ Start Report Routes ------------------------------------------------------------------
//general report routes 
Route::get('general/report', [ReportController::class, 'generalReport'])->middleware(['auth', 'setlocale'])->name('report.general');

// Generate PDF of the report
Route::post('general/report/pdf', [ReportController::class, 'createGeneralReport'])->middleware(['auth', 'setlocale'])->name('report.general.pdf');

//Existing suspects PDF Report
Route::get('reports/existing-suspects/pdf', [ReportController::class, 'existingSuspectPdf'])->name('reports.existing.pdf');

//released suspects route
Route::get('released/suspects', [ReportController::class, 'releasedSuspectReport'])->name('release.suspect.report');

//release\transferred suspects PDF Report
Route::post('reports/released-suspects/pdf', [ReportController::class, 'releasedSuspectPdf'])->name('reports.released.pdf');

// monthly suspects PDF Report
Route::get('reports/monthly-suspects/pdf', [ReportController::class, 'monthlySuspectPdf'])->name('reports.monthly.pdf');
//monthly suspects create report
Route::get('reports/monthly-suspects', [ReportController::class, 'monthlySuspectReport'])->name('reports.monthly');
# --------------------------------- End suspects Routes ------------------------------------------------------------------


#--------------------------------- livelihood plan Routes -------------------------------------------------------------------
Route::middleware(['auth', 'setlocale'])->group(function () {

    Route::get('livelihood/plan', [LivelihoodPlanController::class, 'livelihoodPlan'])->name('livelihood.plan');
    Route::post('livelihood/store', [LivelihoodPlanController::class, 'store'])->name('livelihood.store');
    Route::get('livelihood/show', [LivelihoodPlanController::class, 'livelihoodShow'])->name('livelihood.list.show');
    // Livelihood List (DataTable)
    Route::get('livelihood/monthly/report', [LivelihoodPlanController::class, 'monthlyReport'])
        ->name('livelihood.monthly.report');
    //livelihood weekly report
    Route::get(
        'livelihood/weekly/report/{id}',
        [LivelihoodPlanController::class, 'weeklyReportPdf']
    )->name('livelihood.weekly.report.pdf');


    Route::get(
        '/livelihood/month/{month}',
        [LivelihoodPlanController::class, 'monthlyDetails']
    )->name('livelihood.month.details');

    Route::delete('/livelihood/month/{month}', [LivelihoodPlanController::class, 'deleteMonth']);

    // Edit single livelihood record
    Route::get(
        'livelihood/{id}/edit',
        [LivelihoodPlanController::class, 'edit']
    )->name('livelihood.edit');

    Route::put(
        'livelihood/{id}',
        [LivelihoodPlanController::class, 'update']
    )->name('livelihood.update');

    Route::get(
        '/livelihood/month/{month}/pdf',
        [LivelihoodPlanController::class, 'monthlyLivelihoodPdf']
    )->name('livelihood.month.pdf');
});
#--------------------------------- End livelihood plan Routes -------------------------------------------------------------------


// د بیلونو لیست
Route::get('bills', [BillController::class, 'index'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.index');

// د بیل ذخیره کول
Route::post('bills/store', [BillController::class, 'store'])->middleware(['auth', 'setlocale'])->name('bills.store');



// د بیل تفصیلات (AJAX)
Route::get('bills/show/{id}', [BillController::class, 'show'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.show');

// د بیل لیست (AJAX)
Route::get('bills/list', [BillController::class, 'list'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.list');

// د بیل سمول (Edit form)
Route::get('bills/edit/{id}', [BillController::class, 'edit'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.edit');

// د بیل تازه کول

Route::put('bills/update/{id}', [BillController::class, 'update'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.update');

// د بیل حذف کول 
Route::get('bills/destroy/{id}', [BillController::class, 'destroy'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.destroy');


// د عکس حذف کول
Route::get('bills/image/destroy/{id}', [BillController::class, 'deleteImage'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.image.destroy');

// د بیل حالت بدلول
Route::get('bills/status/{id}/{status}', [BillController::class, 'changeStatus'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.change-status');
// --------------------------------- Reports Routes -------------------------------------------------------------------
// ==========================================
// د بیل راپور روټونه
// ==========================================

// د راپور لومړنی صفحه
Route::get('bills/reports', [BillController::class, 'reports'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.reports');

// د راپور ډاټا (AJAX)
Route::get('bills/reports/data', [BillController::class, 'reportsData'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.reports.data');

// د راپور ایکسپورټ (Excel/PDF)
Route::get('bills/reports/export', [BillController::class, 'exportReport'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.reports.export');

// د راپور چاپ
Route::get('bills/reports/print', [BillController::class, 'printReport'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.reports.print');

// د جنسونو لیست (د فلتر لپاره)
Route::get('bills/reports/items-list', [BillController::class, 'itemsList'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.reports.items-list');

// د دوکانونو لیست (د فلتر لپاره)
Route::get('bills/reports/shops-list', [BillController::class, 'shopsList'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.reports.shops-list');
// د راپور چاپ - د براوزر لپاره (HTML)
Route::get('bills/reports/print', [BillController::class, 'printReport'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.reports.print');

// د بیل لیست - د DataTables لپاره (AJAX)
Route::get('bills/list', [BillController::class, 'list'])
    ->middleware(['auth', 'setlocale'])
    ->name('bills.list');
