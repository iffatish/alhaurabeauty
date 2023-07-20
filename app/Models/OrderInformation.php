<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Model for order. To save order information.
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
        'totalItems',
        'status',
        'employeeId'         
    ];
    public $timestamps = false;
}
