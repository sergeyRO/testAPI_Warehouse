<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Motion extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'warehouse_id',
        'action',
        'remain',
        'created_at'
    ];

    public $timestamps = false;
}
