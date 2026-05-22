<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Booking extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'reference_number', 'customer_name', 'customer_email', 'customer_phone', 
        'cottage_id', 'check_in', 'check_out', 'adults', 'children', 'total_price', 'status', 'user_id'
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'total_price' => 'decimal:2',
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            $booking->reference_number = static::generateReferenceNumber();
        });
    }

    public static function generateReferenceNumber()
    {
        do {
            $ref = 'RB-' . strtoupper(Str::random(8));
        } while (static::where('reference_number', $ref)->exists());

        return $ref;
    }

    public function cottage()
    {
        return $this->belongsTo(Cottage::class)->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }
}
