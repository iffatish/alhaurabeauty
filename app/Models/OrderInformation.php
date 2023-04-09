<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderInformation extends Model
{
    use HasFactory;

    protected $table = "order_information";
    protected $fillable = [
        'custName',
        'custPhoneNum',
        'deliveryAddress',
        'deliveryMethod',
        'paymentMethod',
        'additionalCost',
        'orderPrice',
        'orderDate',
        'employeeId'         
    ];
    public $timestamps = false;
}
