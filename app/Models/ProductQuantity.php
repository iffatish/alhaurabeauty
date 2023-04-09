<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductQuantity extends Model
{
    use HasFactory;

    protected $table = "product_quantity";
    protected $fillable = [
        'employeeId'        
    ];
    public $timestamps = false;
}