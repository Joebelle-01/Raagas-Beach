<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        if (auth()->user()->isStaff()) {
            return redirect()->route('staff.dashboard');
        }
        $stats = [
            'total_bookings' => \App\Models\Booking::count(),
            'total_revenue' => \App\Models\Payment::where('status', 'verified')->sum('verified_amount'),
            'available_cottages' => \App\Models\Cottage::where('status', 'available')->count(),
            'total_cottages' => \App\Models\Cottage::count(),
            'pending_payments' => \App\Models\Payment::where('status', 'pending')->count(),
        ];

        // Only display active bookings (pending, confirmed, checked_in) on the dashboard.
        // Completed and cancelled bookings are archived and can be viewed in the view-all list.
        $recentBookings = \App\Models\Booking::with('cottage')
            ->whereNotIn('status', ['completed', 'cancelled'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentBookings'));
    }

    public function logs()
    {
        $logs = \App\Models\ActivityLog::with('user')->latest()->paginate(20);
        return view('admin.logs.index', compact('logs'));
    }
}
