<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    //
    protected $fillable = [
        'employee_id',
        'firstname',
        'middleinitial',
        'lastname',
        'position',
        'email',
        'password',
        'address',
        'city',
        'landmark',
        'zip',
        'profile_pic',
    ];

    protected $primaryKey = 'employee_id';

    public function schedule(){
        return $this->hasOne('App\Models\Schedule');
    }
}
