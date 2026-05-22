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

        $user = $request->user();

        // Process pending booking if exists
        if ($request->session()->has('pending_booking')) {
            $bookingData = $request->session()->get('pending_booking');
            $bookingData['user_id'] = $user->id;
            
            // Keep customer details consistent with logged-in user
            $bookingData['customer_name'] = $user->name;
            $bookingData['customer_email'] = $user->email;

            \App\Models\Booking::create($bookingData);
            $request->session()->forget('pending_booking');

            return redirect()->route('dashboard')
                ->with('success', 'Welcome back! Your cottage reservation has been successfully booked.');
        }

        if ($user->isAdmin()) {
            return redirect()->intended(route('admin.dashboard', absolute: false));
        }

        if ($user->isStaff()) {
            return redirect()->intended(route('staff.dashboard', absolute: false));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
