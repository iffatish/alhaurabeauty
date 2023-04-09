<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'employeeId'     
    ];
    public $timestamps = false;

    public function getEmployee() {

        return $this->belongsTo(User::class, 'employeeId', 'id');

    }
}
