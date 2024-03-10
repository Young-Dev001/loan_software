<?php

namespace App\Http\Controllers\SecretaryAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SecretaryAuth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('secretary.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        $notification = [
            'message' => 'Login Successful, ',
            'alert-type' => 'info'
        ];

        return redirect()->intended(RouteServiceProvider::SECRETARY_DASHBOARD )->with($notification);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $userName = Auth::user()->name;

        Auth::guard('secretary')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Logout successful, ' . $userName, 
            'alert-type' => 'info'
        );

        return redirect('/');
    }
}
