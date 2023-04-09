<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function getEmployee() {

        return $this->belongsTo(User::class, 'teamLeader', 'id');

    }

}
