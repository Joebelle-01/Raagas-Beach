<?php

namespace App\Http\Controllers;

use App\Models\Cottage;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index()
    {
        $cottages = Cottage::where('status', 'available')->with('images')->get();
        return view('cottages.index', compact('cottages'));
    }

    public function show(Cottage $cottage)
    {
        return view('cottages.show', compact('cottage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'cottage_id' => 'required|exists:cottages,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
        ]);

        $cottage = Cottage::findOrFail($request->cottage_id);

        // Check for double booking
        $exists = Booking::where('cottage_id', $request->cottage_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('check_in', '<', $request->check_out)
                      ->where('check_out', '>', $request->check_in);
                });
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['check_in' => 'Sorry, this cottage is already booked for the selected dates.'])
                         ->withInput();
        }
        
        // Calculate days
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $days = $checkIn->diffInDays($checkOut);
        if ($days == 0) $days = 1; // Minimum 1 day charge

        $totalPrice = $cottage->price * $days;

        $bookingData = [
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'cottage_id' => $request->cottage_id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'adults' => $request->adults,
            'children' => $request->children ?? 0,
            'total_price' => $totalPrice,
            'status' => 'pending',
        ];

        if (auth()->check()) {
            $user = auth()->user();
            $bookingData['user_id'] = $user->id;
            // Keep customer details consistent with logged-in user
            $bookingData['customer_name'] = $user->name;
            $bookingData['customer_email'] = $user->email;

            Booking::create($bookingData);

            return redirect()->route('dashboard')
                ->with('success', 'Booking submitted successfully!');
        }

        // Save to session and redirect to register
        session(['pending_booking' => $bookingData]);

        return redirect()->route('register')
            ->with('info', 'Please register or log in to confirm and save your cottage reservation.');
    }

    public function payment(Request $request, $reference)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $booking = Booking::where('reference_number', $reference)->firstOrFail();

        // Security check: ensure current user owns the booking
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payments', 'public');
            
            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'payment_method' => 'GCash/Bank Transfer', // Default fallback for guest proof uploads
                'proof_path' => $path,
                'status' => 'pending',
            ]);

            return redirect()->route('dashboard')
                ->with('success', 'Done submitting receipt! We will review and verify your payment shortly.');
        }

        return back()->with('error', 'Failed to upload payment proof.');
    }
}
