<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Model for position discount. To save restock discount for each position.
class PositionDiscount extends Model
{
    use HasFactory;

    protected $table = "position_discount";
    protected $fillable = [
        'discountId',
        'discountHQ',
        'discountMasterLeader',
        'discountLeader',
        'discountMasterStockist',
        'discountStockist',
        'discountMasterAgent',
        'discountAgent', 
        'discountDropship'

    ];
    public $timestamps = false;
}
