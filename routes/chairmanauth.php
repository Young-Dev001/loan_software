<?php

use App\Http\Controllers\ChairmanAuth\AuthenticatedSessionController;
use App\Http\Controllers\ChairmanAuth\ConfirmablePasswordController;
use App\Http\Controllers\ChairmanAuth\EmailVerificationNotificationController;
use App\Http\Controllers\ChairmanAuth\EmailVerificationPromptController;
use App\Http\Controllers\ChairmanAuth\NewPasswordController;
use App\Http\Controllers\ChairmanAuth\PasswordController;
use App\Http\Controllers\ChairmanAuth\PasswordResetLinkController;
use App\Http\Controllers\ChairmanAuth\RegisteredUserController;
use App\Http\Controllers\ChairmanAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:chairman')->group(function () {

    Route::get('chairman/login', [AuthenticatedSessionController::class, 'create'])
                ->name('chairman.login');

    Route::post('chairman/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('chairman/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('chairman.password.request');

    Route::post('chairman/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('chairman.password.email');

    Route::get('chairman/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('chairman.password.reset');

    Route::post('chairman/reset-password', [NewPasswordController::class, 'store'])
                ->name('chairman.password.store');
});

Route::middleware('auth:chairman')->group(function () {
    Route::get('chairman/verify-email', EmailVerificationPromptController::class)
                ->name('chairman.verification.notice');

    Route::get('chairman/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('chairman.verification.verify');

    Route::post('chairman/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('chairman.verification.send');

    Route::get('chairman/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('chairman.password.confirm');

    Route::post('chairman/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('chairman/password', [PasswordController::class, 'update'])->name('chairman.password.update');

    Route::post('chairman/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('chairman.logout');
});
