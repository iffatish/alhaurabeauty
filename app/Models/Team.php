<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//Model for team. To save team information.
class Team extends Model
{
    use HasFactory;

    protected $table = "team";
    protected $fillable = [
        'teamName',
        'teamLeader',
        'teamDesc',
        'dateCreated',
        'memberNum',
        'teamMember'
    ];
    public $timestamps = false;

    //A funtion to get employee information from employee table
    public function getEmployee() {

        return $this->belongsTo(User::class, 'teamLeader', 'id');

    }

}
