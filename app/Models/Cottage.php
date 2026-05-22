<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cottage extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'slug', 'description', 'capacity', 'price', 'status'];

    public function images()
    {
        return $this->hasMany(CottageImage::class);
    }

    public function inclusions()
    {
        return $this->hasMany(CottageInclusion::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
