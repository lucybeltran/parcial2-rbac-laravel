<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'user_id',
        'type',
        'quantity',
        'status', 
    ];
}