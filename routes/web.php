<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\isAdmin;


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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::get('/', [App\Http\Controllers\Front\FrontController::class, 'index'])->name('home');
Route::get('/job', [App\Http\Controllers\Front\JobController::class, 'index'])->name('job');
// Route::get('/jobdetails', [App\Http\Controllers\Front\JobDetailController::class, 'index'])->name('jobdetails');

Route::get('/jobdetails/{slug}', [App\Http\Controllers\Front\JobDetailController::class, 'show'])->name('jobdetails');

Route::get('/job-search', [App\Http\Controllers\Front\JobController::class, 'search'])->name("front.job.search");
Route::get('/job-clearsearch', [App\Http\Controllers\Front\JobController::class, 'clearsearch'])->name("front.job.clearsearch");

// Route::get('/job/{id}', [App\Http\Controllers\Front\JobDetailController::class, 'index'])->name('job');

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/jobseeker-register', [App\Http\Controllers\Front\JobSeekerRegistrationController::class, 'index'])->name('jobseeker.register');
Route::post('/jobseeker-register-store', [App\Http\Controllers\Front\JobSeekerRegistrationController::class, 'store'])->name('jobseeker.register.store');

/** 
 * Authentication routes
 */

// Login route
Route::get(
    'login',
    [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']
)->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);

// Registeration route
Route::get(
    'register',
    [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm']
)->name('register');
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

// Logout Route
Route::post(
    'logout',
    [App\Http\Controllers\Auth\LoginController::class, 'logout']
)->name('logout');

// Register the typical reset password routes for an application.
Route::get(
    'password/reset',
    [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm']
)->name('password.request');
Route::post(
    'password/email',
    [App\Http\Controllers\Auth\ForgotPasswordController::class, 'sendResetLinkEmail']
)->name('password.email');
Route::get(
    'password/reset/{token}',
    [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm']
)->name('password.reset');
Route::post(
    'password/reset',
    [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset']
)->name('password.update');


// Register the typical confirm password routes for an application.
Route::get(
    'password/confirm',
    [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'showConfirmForm']
)->name('password.confirm');
Route::post(
    'password/confirm',
    [App\Http\Controllers\Auth\ConfirmPasswordController::class, 'confirm']
)->name('password.update');

// Register the typical email verification routes for an application.
Route::get(
    'email/verify',
    [App\Http\Controllers\Auth\VerificationController::class, 'show']
)->name('verification.notice');
Route::get(
    'email/verify/{id}/{hash}',
    [App\Http\Controllers\Auth\VerificationController::class, 'verify']
)->name('verification.verify');
Route::post(
    'email/resend',
    [App\Http\Controllers\Auth\VerificationController::class, 'resend']
)->name('verification.resend');



// Route::middleware([EnsureTokenIsValid::class])->group(function () {
//     Route::get('/', function () {
//         //
//     });

//     Route::get('/profile', function () {
//         //
//     })->withoutMiddleware([EnsureTokenIsValid::class]);
// });
// Admin route for dashboard
Route::get('admin/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.dashboard');

Route::prefix('admin')->middleware([isAdmin::class])->group(function () {

    /**
     * Admin Panel Routes
     */

    // // Admin route for dashboard
    // Route::get('/dashboard', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.dashboard');

    // Social Link
    Route::get('/sociallink', [App\Http\Controllers\Admin\SocialLinkController::class, 'edit'])->name('admin.sociallink.edit');
    Route::put('/sociallink/update/{id}', [App\Http\Controllers\Admin\SocialLinkController::class, 'update'])->name('admin.sociallink.update');


    // Profession Module
    Route::get('/profession', [App\Http\Controllers\Admin\ProfessionController::class, 'create'])->name('admin.profession.create');
    Route::post('/profession-store', [App\Http\Controllers\Admin\ProfessionController::class, 'store'])->name('admin.profession.store');
    Route::get('/profession/list', [App\Http\Controllers\Admin\ProfessionController::class, 'lists'])->name('admin.profession.list')->withoutMiddleware([isAdmin::class]);

    Route::get('/profession/enable/{id}', [App\Http\Controllers\Admin\ProfessionController::class, 'enable'])->name('admin.profession.enable');
    Route::get('/profession/disable/{id}', [App\Http\Controllers\Admin\ProfessionController::class, 'disable'])->name('admin.profession.disable');

    Route::get(
        '/profession/datatable',
        [App\Http\Controllers\Admin\ProfessionController::class, 'datatable']
    )->name('profession.datatables')->withoutMiddleware([isAdmin::class]);

    Route::get(
        '/profession/delete/{id}',
        [App\Http\Controllers\Admin\ProfessionController::class, 'destroy']
    )->name('profession.delete');



    // Speciality  Module
    Route::get('/specialty', [App\Http\Controllers\Admin\SpecialtyController::class, 'create'])->name('admin.specialty.create');
    Route::post('/specialty-store', [App\Http\Controllers\Admin\SpecialtyController::class, 'store'])->name('admin.specialty.store');
    Route::get('/specialty/list', [App\Http\Controllers\Admin\SpecialtyController::class, 'lists'])->name('admin.specialty.list')->withoutMiddleware([isAdmin::class]);

    Route::get('/specialty/enable/{id}', [App\Http\Controllers\Admin\SpecialtyController::class, 'enable'])->name('admin.specialty.enable');
    Route::get('/specialty/disable/{id}', [App\Http\Controllers\Admin\SpecialtyController::class, 'disable'])->name('admin.specialty.disable');

    Route::get(
        '/specialty/datatable',
        [App\Http\Controllers\Admin\SpecialtyController::class, 'datatable']
    )->name('specialty.datatables')->withoutMiddleware([isAdmin::class]);

    Route::get(
        '/specialty/delete/{id}',
        [App\Http\Controllers\Admin\SpecialtyController::class, 'destroy']
    )->name('specialty.delete');



    // Job Module
    Route::get('/job', [App\Http\Controllers\Admin\JobController::class, 'create'])->name('admin.job.create');
    Route::post('/job-store', [App\Http\Controllers\Admin\JobController::class, 'store'])->name('admin.job.store');
    Route::get('/job/list', [App\Http\Controllers\Admin\JobController::class, 'lists'])->name('admin.job.list')->withoutMiddleware([isAdmin::class]);
    Route::get('/job-details/{id}', [App\Http\Controllers\Admin\JobController::class, 'show'])->name('admin.job.show');

    Route::get('/job/enable/{id}', [App\Http\Controllers\Admin\JobController::class, 'enable'])->name('admin.job.enable');
    Route::get('/job/disable/{id}', [App\Http\Controllers\Admin\JobController::class, 'disable'])->name('admin.job.disable');

    Route::get(
        '/job/datatable',
        [App\Http\Controllers\Admin\JobController::class, 'datatable']
    )->name('job.datatables')->withoutMiddleware([isAdmin::class]);

    Route::get(
        '/job/delete/{id}',
        [App\Http\Controllers\Admin\JobController::class, 'destroy']
    )->name('job.delete');



    // Job Type Module
    Route::get('/jobtype', [App\Http\Controllers\Admin\JobTypeController::class, 'create'])->name('admin.jobtype.create');
    Route::post('/jobtype-store', [App\Http\Controllers\Admin\JobTypeController::class, 'store'])->name('admin.jobtype.store');
    Route::get('/jobtype/list', [App\Http\Controllers\Admin\JobTypeController::class, 'lists'])->name('admin.jobtype.list')->withoutMiddleware([isAdmin::class]);

    Route::get('/jobtype/enable/{id}', [App\Http\Controllers\Admin\JobTypeController::class, 'enable'])->name('admin.jobtype.enable');
    Route::get('/jobtype/disable/{id}', [App\Http\Controllers\Admin\JobTypeController::class, 'disable'])->name('admin.jobtype.disable');

    Route::get(
        '/jobtype/datatable',
        [App\Http\Controllers\Admin\JobTypeController::class, 'datatable']
    )->name('jobtype.datatables')->withoutMiddleware([isAdmin::class]);

    Route::get(
        '/jobtype/delete/{id}',
        [App\Http\Controllers\Admin\JobTypeController::class, 'destroy']
    )->name('jobtype.delete');


    // Job Category Module
    Route::get('/jobcategory', [App\Http\Controllers\Admin\JobCategoryController::class, 'create'])->name('admin.jobcategory.create');
    Route::post('/jobcategory-store', [App\Http\Controllers\Admin\JobCategoryController::class, 'store'])->name('admin.jobcategory.store');
    Route::get('/jobcategory/list', [App\Http\Controllers\Admin\JobCategoryController::class, 'lists'])->name('admin.jobcategory.list')->withoutMiddleware([isAdmin::class]);

    Route::get('/jobcategory/enable/{id}', [App\Http\Controllers\Admin\JobCategoryController::class, 'enable'])->name('admin.jobcategory.enable');
    Route::get('/jobcategory/disable/{id}', [App\Http\Controllers\Admin\JobCategoryController::class, 'disable'])->name('admin.jobcategory.disable');

    Route::get(
        '/jobcategory/datatable',
        [App\Http\Controllers\Admin\JobCategoryController::class, 'datatable']
    )->name('jobcategory.datatables')->withoutMiddleware([isAdmin::class]);

    Route::get(
        '/jobcategory/delete/{id}',
        [App\Http\Controllers\Admin\JobCategoryController::class, 'destroy']
    )->name('jobcategory.delete');


    // States Module
    Route::get('/state', [App\Http\Controllers\Admin\StateController::class, 'create'])->name('admin.state.create');
    Route::post('/state-store', [App\Http\Controllers\Admin\StateController::class, 'store'])->name('admin.state.store');
    Route::get('/state/list', [App\Http\Controllers\Admin\StateController::class, 'lists'])->name('admin.state.list')->withoutMiddleware([isAdmin::class]);;

    Route::get('/state/enable/{id}', [App\Http\Controllers\Admin\StateController::class, 'enable'])->name('admin.state.enable');
    Route::get('/state/disable/{id}', [App\Http\Controllers\Admin\StateController::class, 'disable'])->name('admin.state.disable');

    Route::get(
        '/state/datatable',
        [App\Http\Controllers\Admin\StateController::class, 'datatable']
    )->name('state.datatables')->withoutMiddleware([isAdmin::class]);

    Route::get(
        '/state/delete/{id}',
        [App\Http\Controllers\Admin\StateController::class, 'destroy']
    )->name('state.delete');


    // Cities Module
    Route::get('/city', [App\Http\Controllers\Admin\CityController::class, 'create'])->name('admin.city.create');
    Route::post('/city-store', [App\Http\Controllers\Admin\CityController::class, 'store'])->name('admin.city.store');
    Route::get('/city/list', [App\Http\Controllers\Admin\CityController::class, 'lists'])->name('admin.city.list')->withoutMiddleware([isAdmin::class]);;

    Route::get('/city/enable/{id}', [App\Http\Controllers\Admin\CityController::class, 'enable'])->name('admin.city.enable');
    Route::get('/city/disable/{id}', [App\Http\Controllers\Admin\CityController::class, 'disable'])->name('admin.city.disable');

    Route::get(
        '/city/datatable',
        [App\Http\Controllers\Admin\CityController::class, 'datatable']
    )->name('city.datatables')->withoutMiddleware([isAdmin::class]);

    Route::get(
        '/city/delete/{id}',
        [App\Http\Controllers\Admin\CityController::class, 'destroy']
    )->name('city.delete');





    // Ajax Route
    Route::post('getcities', [App\Http\Controllers\Admin\StateController::class, 'getcities'])->name('getcities')->withoutMiddleware([isAdmin::class]);;
    Route::post('getasuburbs', [App\Http\Controllers\Admin\StateController::class, 'getasuburbs'])->name('getasuburbs')->withoutMiddleware([isAdmin::class]);;
});
