<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CottageImage extends Model
{
    use SoftDeletes;

    protected $fillable = ['cottage_id', 'image_path'];
}
