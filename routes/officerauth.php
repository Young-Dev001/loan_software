<?php

use App\Http\Controllers\OfficerAuth\AuthenticatedSessionController;
use App\Http\Controllers\OfficerAuth\ConfirmablePasswordController;
use App\Http\Controllers\OfficerAuth\EmailVerificationNotificationController;
use App\Http\Controllers\OfficerAuth\EmailVerificationPromptController;
use App\Http\Controllers\OfficerAuth\NewPasswordController;
use App\Http\Controllers\OfficerAuth\PasswordController;
use App\Http\Controllers\OfficerAuth\PasswordResetLinkController;
use App\Http\Controllers\OfficerAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:officer')->group(function () {

    Route::get('officer/login', [AuthenticatedSessionController::class, 'create'])
                ->name('officer.login');

    Route::post('officer/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('officer/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('officer.password.request');

    Route::post('officer/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('officer.password.email');

    Route::get('officer/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('officer.password.reset');

    Route::post('officer/reset-password', [NewPasswordController::class, 'store'])
                ->name('officer.password.store');
});

Route::middleware('auth:officer')->group(function () {
    Route::get('officer/verify-email', EmailVerificationPromptController::class)
                ->name('officer.verification.notice');

    Route::get('officer/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('officer.verification.verify');

    Route::post('officer/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('officer.verification.send');

    Route::get('officer/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('officer.password.confirm');

    Route::post('officer/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('officer/password', [PasswordController::class, 'update'])->name('officer.password.update');

    Route::post('officer/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('officer.logout');
});
