<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    protected $fillable = [
        'product_id',
        'status',
        'confirmed_at'
    ];
}