<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Model for product discount. To save product discount information.
class ProductDiscount extends Model
{
    use HasFactory;

    protected $table = "product_discount";
    protected $fillable = [
        'productDiscount',
        'discountName',
        'status'
    ];
    public $timestamps = false;
}
