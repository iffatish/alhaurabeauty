<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
