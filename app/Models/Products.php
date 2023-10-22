<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Получить все заказы, в которых есть этот продукт.
     */
    public function orders()
    {
        return $this->belongsToMany(Orders::class,'order_items','product_id','order_id');
    }

    /**
     * Получить все склады, в которых есть этот продукт.
     */
    public function warehouses()
    {
        return $this->belongsToMany(Warehouses::class,'stocks','product_id','warehouse_id')->withPivot('stock');
    }

}
