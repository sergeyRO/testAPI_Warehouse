<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'customer',
        'created_at',
        'completed_at',
        'warehouse_id',
        'status'
    ];

    public $timestamps = false;

    /**
     * Получить все продукты заказа.
     */
    public function products()
    {
        return $this->belongsToMany(Products::class,'order_items','order_id','product_id')->withPivot('id','count');
    }
}
