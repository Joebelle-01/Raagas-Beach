<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Cottage;
use App\Models\Payment;

class StaffController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $stats = [
            'total_bookings' => Booking::count(),
            'today_checkins' => Booking::whereDate('check_in', $today)->where('status', '!=', 'cancelled')->count(),
            'today_checkouts' => Booking::whereDate('check_out', $today)->where('status', '!=', 'cancelled')->count(),
            'currently_in_house' => Booking::where('status', 'checked_in')->count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
            'total_cottages' => Cottage::count(),
            'available_cottages' => Cottage::where('status', 'available')->count(),
        ];

        // Calculate occupancy rate
        $occupiedCount = Cottage::where('status', 'occupied')->count();
        $stats['occupancy_rate'] = $stats['total_cottages'] > 0 
            ? round(($occupiedCount / $stats['total_cottages']) * 100) 
            : 0;

        $recentBookings = Booking::with('cottage')->latest()->take(5)->get();

        return view('staff.dashboard', compact('stats', 'recentBookings'));
    }
}
