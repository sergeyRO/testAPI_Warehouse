<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouses extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Получить все продукты склада.
     */
    public function products()
    {
        return $this->belongsToMany(Products::class,'stocks','warehouse_id','product_id');
    }
}
