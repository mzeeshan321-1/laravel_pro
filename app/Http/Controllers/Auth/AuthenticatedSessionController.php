<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
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
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();
        $user = Auth::user();
        $user->userInfo()->updateOrCreate(
            ['user_id' => $user->id],
            ['last_login' => now()]
        );
        $authUser = $user->role;
        flash()->options(['timeout' => 3000, // 3 seconds
            'position' => 'bottom-right',])->success('You are logged-In Successfully!');
        return match ($authUser) {
            1 => redirect()->intended(route('admin.dashboard')),
            2 => redirect()->intended(route('hr_manager.dashboard')),
            3 => redirect()->intended(route('employee.dashboard')),
            default => redirect()->route('login'),
        };
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        flash()->success("You are logged out successfully!");
        return redirect()->route('login');
    }
}
