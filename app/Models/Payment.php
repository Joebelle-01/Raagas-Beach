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
}
