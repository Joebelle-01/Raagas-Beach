<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['booking_id', 'amount', 'verified_amount', 'payment_method', 'proof_path', 'status', 'transaction_id'];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Get the URL for the payment proof, falling back to a custom placeholder receipt if the physical file does not exist.
     */
    public function getProofUrlAttribute()
    {
        if ($this->proof_path && \Storage::disk('public')->exists($this->proof_path)) {
            return \Storage::url($this->proof_path);
        }

        return asset('assets/images/placeholder-receipt.png');
    }

    /**
     * Check if the proof file is missing/mocked.
     */
    public function getIsMockProofAttribute()
    {
        if (!$this->proof_path) {
            return true;
        }

        return !\Storage::disk('public')->exists($this->proof_path);
    }
}
