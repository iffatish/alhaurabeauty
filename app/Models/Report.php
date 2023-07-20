<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Model for report. To save report information.
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
        'quantitySold',
        'productSold',
        'totalSales',
        'capital',
        'profit',
          
    ];
    public $timestamps = false;

    //A funtion to get employee information from employee table
    public function getEmployee() {

        return $this->belongsTo(User::class, 'employeeId', 'id');

    }
}
