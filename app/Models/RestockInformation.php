<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Model for restock information. To save restock information.
class RestockInformation extends Model
{
    use HasFactory;

    protected $table = "restock_information";
    protected $fillable = [
        'batchNo',
        'restockFrom',
        'restockPaymentMethod',
        'restockDate',
        'restockPrice',
        'currentPosition',
        'status',
        'employeeId'     
    ];
    public $timestamps = false;

    //A funtion to get employee information from employee table
    public function getEmployee() {

        return $this->belongsTo(User::class, 'employeeId', 'id');

    }
}
