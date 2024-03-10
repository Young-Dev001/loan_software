<?php

use App\Http\Controllers\MemberAuth\AuthenticatedSessionController;
use App\Http\Controllers\MemberAuth\ConfirmablePasswordController;
use App\Http\Controllers\MemberAuth\EmailVerificationNotificationController;
use App\Http\Controllers\MemberAuth\EmailVerificationPromptController;
use App\Http\Controllers\MemberAuth\NewPasswordController;
use App\Http\Controllers\MemberAuth\PasswordController;
use App\Http\Controllers\MemberAuth\PasswordResetLinkController;
use App\Http\Controllers\MemberAuth\RegisteredUserController;
use App\Http\Controllers\MemberAuth\VerifyEmailController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest:member')->group(function () {

    Route::get('member/login', [AuthenticatedSessionController::class, 'create'])
                ->name('member.login');

    Route::post('member/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('member/forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('member.password.request');

    Route::post('member/forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('member.password.email');

    Route::get('member/reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('member.password.reset');

    Route::post('member/reset-password', [NewPasswordController::class, 'store'])
                ->name('member.password.store');
});

Route::middleware('auth:member')->group(function () {
    Route::get('member/verify-email', EmailVerificationPromptController::class)
                ->name('member.verification.notice');

    Route::get('member/verify-email/{id}/{hash}', VerifyEmailController::class)
                ->middleware(['signed', 'throttle:6,1'])
                ->name('member.verification.verify');

    Route::post('member/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('member.verification.send');

    Route::get('member/confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('member.password.confirm');

    Route::post('member/confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('member/password', [PasswordController::class, 'update'])->name('member.password.update');

    Route::post('member/logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('member.logout');
});
