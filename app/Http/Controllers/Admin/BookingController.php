<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use App\Traits\LogsActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingNotification;

class BookingController extends Controller
{
    use LogsActivity;

    public function index(Request $request)
    {
        $query = Booking::with(['cottage', 'payments', 'payment'])->latest();

        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'archived') {
                $query = Booking::onlyTrashed()->with(['cottage', 'payments'])->latest();
            } elseif ($request->status === 'payment_pending') {
                $query->whereHas('payments', function ($q) {
                    $q->where('status', 'pending');
                });
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        $bookings = $query->paginate(15);
        return view('admin.bookings.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = Booking::withTrashed()->with(['cottage', 'payments', 'payment'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    public function verifyPayment(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
            'verified_amount' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $verifiedAmount = $request->verified_amount ?? $payment->amount ?? $payment->booking->total_price;

        $payment->update([
            'status' => $request->status,
            'verified_amount' => $verifiedAmount,
        ]);

        // If payment is verified, check if booking should be confirmed
        if ($request->status === 'verified') {
            $booking = $payment->booking;
            // Update booking status if needed, or keep as pending until full payment
            // For now, let's mark booking as confirmed if at least one payment is verified
            $booking->update(['status' => 'confirmed']);
            $booking->cottage->update(['status' => 'booked']);
            
            $this->logActivity('Payment Verified', "Verified payment of {$verifiedAmount} for booking {$booking->reference_number}");

            // Send Email Notification
            Mail::to($booking->customer_email)->send(new BookingNotification(
                $booking,
                'Payment Verified',
                'Your payment has been successfully verified. Your booking is now confirmed.'
            ));
        } else {
            $this->logActivity('Payment Rejected', "Rejected payment for booking {$payment->booking->reference_number}");
            
            // Send Email Notification
            Mail::to($payment->booking->customer_email)->send(new BookingNotification(
                $payment->booking,
                'Payment Rejected',
                'Your payment could not be verified. Please check your payment details or contact support.'
            ));
        }

        return back()->with('success', 'Payment status updated successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::withTrashed()->findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,confirmed,checked_in,cancelled,completed',
        ]);

        $oldStatus = $booking->status;
        $booking->update(['status' => $request->status]);

        // Sync cottage status based on booking status (if not archived)
        if (!$booking->trashed()) {
            if (in_array($request->status, ['confirmed', 'checked_in'])) {
                $booking->cottage->update(['status' => 'booked']);
            } elseif (in_array($request->status, ['completed', 'cancelled'])) {
                $booking->cottage->update(['status' => 'available']);
            }
        }

        $this->logActivity('Booking Status Updated', "Updated booking {$booking->reference_number} status from {$oldStatus} to {$request->status}");

        // Send Email Notification on status change
        $messages = [
            'confirmed' => 'Your booking has been confirmed. We look forward to seeing you!',
            'checked_in' => 'Welcome to Raagas Beach Resort! You have been successfully checked in.',
            'cancelled' => 'Your booking has been cancelled.',
            'completed' => 'Thank you for staying with us! We hope you enjoyed your visit.',
        ];

        if (isset($messages[$request->status])) {
            Mail::to($booking->customer_email)->send(new BookingNotification(
                $booking,
                'Booking ' . ucfirst($request->status),
                $messages[$request->status]
            ));
        }

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        // Free the cottage when archiving/soft-deleting
        $booking->cottage->update(['status' => 'available']);

        $booking->delete();

        $this->logActivity('Booking Archived', "Archived booking {$booking->reference_number}");

        return redirect()->route('admin.bookings.index')->with('success', 'Booking has been successfully archived.');
    }

    public function restore($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);
        $booking->restore();

        // Sync cottage status back if relevant
        if (in_array($booking->status, ['confirmed', 'checked_in'])) {
            $booking->cottage->update(['status' => 'booked']);
        }

        $this->logActivity('Booking Restored', "Restored booking {$booking->reference_number}");

        return redirect()->route('admin.bookings.index')->with('success', 'Booking has been successfully restored.');
    }

    public function forceDelete($id)
    {
        $booking = Booking::onlyTrashed()->findOrFail($id);

        // Delete associated payments first to avoid integrity constraints
        $booking->payments()->delete();
        $booking->forceDelete();

        $this->logActivity('Booking Purged', "Permanently deleted booking {$id}");

        return redirect()->route('admin.bookings.index')->with('success', 'Booking has been permanently deleted.');
    }
}
