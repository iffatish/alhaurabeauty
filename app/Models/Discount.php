<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $table = "discount";
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
