<?php

namespace App\Http\Controllers\MemberAuth;

use App\Http\Controllers\Controller;
use App\Http\Requests\MemberAuth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Member;
class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('member.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
    
        $request->session()->regenerate();
    
        // Retrieve the admin's name from the database
        $memberName = Member::where('email', $request->email)->value('name');
    
        $notification = [
            'message' => "Login Successful, $memberName",
            'alert-type' => 'success'
        ];
    
        return redirect()->intended(RouteServiceProvider::MEMBER_DASHBOARD)->with($notification);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {

        $userName = Auth::user()->name;

        Auth::guard('member')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $notification = array(
            'message' => 'Logout successful, ' . $userName, 
            'alert-type' => 'info'
        );

        return redirect('/')->with($notification);
    }
}
