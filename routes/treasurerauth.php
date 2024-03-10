<?php

use App\Http\Controllers\TreasurerAuth\AuthenticatedSessionController;
use App\Http\Controllers\TreasurerAuth\ConfirmablePasswordController;
use App\Http\Controllers\TreasurerAuth\EmailVerificationNotificationController;
use App\Http\Controllers\TreasurerAuth\EmailVerificationPromptController;
use App\Http\Controllers\TreasurerAuth\NewPasswordController;
use App\Http\Controllers\TreasurerAuth\PasswordController;
use App\Http\Controllers\TreasurerAuth\PasswordResetLinkController;
use App\Http\Controllers\TreasurerAuth\RegisteredUserController;
use App\Http\Controllers\TreasurerAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:treasurer')->group(function () {

    Route::get('treasurer/login', [AuthenticatedSessionController::class, 'create'])
                ->name('treasurer.login');

    Route::post('treasurer/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('treasurer/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('treasurer.password.request');

    Route::post('treasurer/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('treasurer.password.email');

    Route::get('treasurer/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('treasurer.password.reset');

    Route::post('treasurer/reset-password', [NewPasswordController::class, 'store'])
                ->name('treasurer.password.store');
});

Route::middleware('auth:treasurer')->group(function () {
    Route::get('treasurer/verify-email', EmailVerificationPromptController::class)
                ->name('treasurer.verification.notice');

    Route::get('treasurer/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('treasurer.verification.verify');

    Route::post('treasurer/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('treasurer.verification.send');

    Route::get('treasurer/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('treasurer.password.confirm');

    Route::post('treasurer/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('treasurer/password', [PasswordController::class, 'update'])->name('treasurer.password.update');

    Route::post('treasurer/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('treasurer.logout');
});
