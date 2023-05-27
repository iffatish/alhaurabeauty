<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $table = "report";
    protected $fillable = [
        'salesReportId',
        'salesReportType',
        'employeeId',
        'reportDate',
        'totalSalesQty',
        'productSold',
        'totalSales',
        'capital',
        'profit',
          
    ];
    public $timestamps = false;

    public function getEmployee() {

        return $this->belongsTo(User::class, 'employeeId', 'id');

    }
}