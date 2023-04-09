<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "product";
    protected $fillable = [
        'productName',
        'productImage',
        'productSellPrice',
        'priceHQ',
        'priceMasterLeader',
        'priceLeader',
        'priceMasterStockist',
        'priceStockist',
        'priceMasterAgent',
        'priceAgent',
        'priceDropship'
    ];
    public $timestamps = false;
}
