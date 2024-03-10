<?php
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\ProfileController;
use App\Models\LoanPayment;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminAuth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TreasurerAuth\AuthenticatedSessionController as TreasurerAuthenticatedSessionController;
use App\Http\Controllers\SecretaryAuth\AuthenticatedSessionController as SecretaryAuthenticatedSessionController;
use App\Http\Controllers\OfficerAuth\AuthenticatedSessionController as OfficerAuthenticatedSessionController;
use App\Http\Controllers\MemberAuth\AuthenticatedSessionController as MemberAuthenticatedSessionController;
use App\Http\Controllers\ChairmanAuth\AuthenticatedSessionController as ChairmanAuthenticatedSessionController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\ExampleController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\LoanController;
use App\Http\Controllers\LoanPaymentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OfficerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\SubGroupController;
use App\Http\Controllers\SupplierController;
use App\Models\Setting;

// Default Laravel welcome route
Route::get('/', function () {
    return view('welcome');
});

// Your other routes...

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
require __DIR__.'/auth.php';

//------------------------------------------ Admin Start------------------------------------------------------------------------//
Route::middleware(['auth:admin', 'verified'])->group(function () {
    Route::get('/admin/dashboard', function () {
        // Retrieve the setting from the database
        $settings = Setting::all();

            return view('admin.index', compact('settings'));
    })->name('admin.dashboard');

    // Additional Custom Routes
    Route::get('admin/profile/view', [AdminController::class, 'ProfileView'])->name('admin.profile.view');
    Route::post('admin/profile/store', [AdminController::class, 'StoreProfile'])->name('admin.profile.store');
    Route::post('admin/change/update', [AdminController::class, 'UpdatePassword'])->name('admin.update.password');

    //system
    Route::resource('products', ProductController::class);
    Route::get('admin/products/dashboard', [ProductController::class, 'Dashboard'])->name('products.dashboard');
    Route::resource('suppliers', SupplierController::class);
    Route::resource('members', MemberController::class);
    Route::put('/members/{id}/password-update', [MemberController::class, 'Password_Update'])->name('members.password.update');
    Route::put('/members/{id}/profile-update', [MemberController::class, 'profile_Update'])->name('members.profile.update');
    Route::resource('loans', LoanController::class);
    Route::resource('sub_groups', SubGroupController::class);
    Route::resource('documents', DocumentController::class);

    //Invoice generation
    Route::get('/generate-invoice/{member}', [LoanController::class, 'generateInvoice'])->name('generate.invoice');


    Route::get('admin/Loans/dashboard', [LoanController::class, 'Dashboard'])->name('loans.dashboard');
    Route::get('admin/registration/form/{member}', [LoanController::class, 'printRegistrationForm'])->name('loans.print_registration');
    Route::get('admin/invoice/{member}', [LoanController::class, 'printInvoice'])->name('loans.print_invoice');
    Route::resource('loan_payments', LoanPaymentController::class);
    Route::get('admin/LoansPayments/dashboard', [LoanPaymentController::class, 'Dashboard'])->name('loans.payments.dashboard');
    Route::resource('groups', GroupController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('messages', MessageController::class);
    Route::post('/send-sms', [MessageController::class, 'sendSms'])->name('send.sms');
    Route::resource('emails', EmailController::class);








    Route::post('/admin/logout', [AdminAuthenticatedSessionController::class, 'logout'])->name('admin.logout');
});
require __DIR__.'/adminauth.php';

//--------------------------------------------------Admin End-------------------------------------------------------------------//

Route::middleware(['auth:member', 'verified'])->group(function () {
    Route::get('/member/dashboard', function () {
        return view('member.index');
    })->name('member.dashboard');


    Route::post('/member/logout', [MemberAuthenticatedSessionController::class, 'logout'])->name('member.logout');
});
require __DIR__.'/memberauth.php';

//--------------------------------------------------member End-------------------------------------------------------------------//

Route::middleware(['auth:officer', 'verified'])->group(function () {
    Route::get('/officer/dashboard', function () {
        return view('officer.index');
    })->name('officer.dashboard');


    Route::post('/officer/logout', [OfficerAuthenticatedSessionController::class, 'logout'])->name('officer.logout');
});
require __DIR__.'/officerauth.php';

//--------------------------------------------------officer End-------------------------------------------------------------------//


Route::middleware(['auth:secretary', 'verified'])->group(function () {
    Route::get('/secretary/dashboard', function () {
        return view('secretary.index');
    })->name('secretary.dashboard');


    Route::post('/secretary/logout', [SecretaryAuthenticatedSessionController::class, 'logout'])->name('secretary.logout');
});
require __DIR__.'/secretaryauth.php';

//--------------------------------------------------secretary End-------------------------------------------------------------------//


Route::middleware(['auth:chairman', 'verified'])->group(function () {
    Route::get('/chairman/dashboard', function () {
        return view('chairman.index');
    })->name('chairman.dashboard');


    Route::post('/chairman/logout', [ChairmanAuthenticatedSessionController::class, 'logout'])->name('chairman.logout');
});
require __DIR__.'/chairmanauth.php';

//--------------------------------------------------chairman End-------------------------------------------------------------------//



Route::middleware(['auth:treasurer', 'verified'])->group(function () {
    Route::get('/treasurer/dashboard', function () {
        return view('treasurer.index');
    })->name('treasurer.dashboard');

    Route::post('/treasurer/logout', [TreasurerAuthenticatedSessionController::class, 'logout'])->name('treasurer.logout');
});
require __DIR__.'/treasurerauth.php';
//--------------------------------------------------treasurer End-------------------------------------------------------------------//
