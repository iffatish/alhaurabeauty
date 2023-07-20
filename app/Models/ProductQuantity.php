<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/*Model for product quantity. 
To save the value of current quantity of items 
in the stock of each product for registered users.*/
class ProductQuantity extends Model
{
    use HasFactory;

    protected $table = "product_quantity";
    protected $fillable = [
        'employeeId'        
    ];
    public $timestamps = false;
}
