<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDiscount extends Model
{
    use HasFactory;

    protected $table = "ProductDiscount";
    protected $fillable = [
        'productDiscount',
        'discountName',
        'status'
    ];
    public $timestamps = false;
}
