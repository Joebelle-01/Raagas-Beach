<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->get('year', date('Y'));
        
        $driverName = DB::connection()->getDriverName();
        $monthExpr = $driverName === 'sqlite'
            ? 'cast(strftime("%m", created_at) as integer) as month'
            : 'MONTH(created_at) as month';

        // Monthly Revenue
        $monthlyRevenue = Payment::where('status', 'verified')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw($monthExpr),
                DB::raw('SUM(verified_amount) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // Fill missing months with 0
        $revenueData = [];
        for ($i = 1; $i <= 12; $i++) {
            $revenueData[] = [
                'month' => date('F', mktime(0, 0, 0, $i, 1)),
                'total' => $monthlyRevenue[$i] ?? 0
            ];
        }

        // Booking Stats
        $bookingStats = [
            'total' => Booking::count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'completed' => Booking::where('status', 'completed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
        ];

        // Revenue Summary
        $revenueSummary = [
            'total_lifetime' => Payment::where('status', 'verified')->sum('verified_amount'),
            'this_month' => Payment::where('status', 'verified')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->sum('verified_amount'),
            'last_month' => Payment::where('status', 'verified')
                ->whereMonth('created_at', Carbon::now()->subMonth()->month)
                ->whereYear('created_at', Carbon::now()->subMonth()->year)
                ->sum('verified_amount'),
        ];

        return view('admin.reports.index', compact('revenueData', 'bookingStats', 'revenueSummary', 'year'));
    }
}
