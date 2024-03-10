<?php

use App\Http\Controllers\SecretaryAuth\AuthenticatedSessionController;
use App\Http\Controllers\SecretaryAuth\ConfirmablePasswordController;
use App\Http\Controllers\SecretaryAuth\EmailVerificationNotificationController;
use App\Http\Controllers\SecretaryAuth\EmailVerificationPromptController;
use App\Http\Controllers\SecretaryAuth\NewPasswordController;
use App\Http\Controllers\SecretaryAuth\PasswordController;
use App\Http\Controllers\SecretaryAuth\PasswordResetLinkController;
use App\Http\Controllers\SecretaryAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:secretary')->group(function () {

    Route::get('secretary/login', [AuthenticatedSessionController::class, 'create'])
                ->name('secretary.login');

    Route::post('secretary/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('secretary/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('secretary.password.request');

    Route::post('secretary/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('secretary.password.email');

    Route::get('secretary/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('secretary.password.reset');

    Route::post('secretary/reset-password', [NewPasswordController::class, 'store'])
                ->name('secretary.password.store');
});

Route::middleware('auth:secretary')->group(function () {
    Route::get('secretary/verify-email', EmailVerificationPromptController::class)
                ->name('secretary.verification.notice');

    Route::get('secretary/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('secretary.verification.verify');

    Route::post('secretary/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('secretary.verification.send');

    Route::get('secretary/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('secretary.password.confirm');

    Route::post('secretary/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('secretary/password', [PasswordController::class, 'update'])->name('secretary.password.update');

    Route::post('secretary/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('secretary.logout');
});
