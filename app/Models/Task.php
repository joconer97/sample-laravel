<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    //
    protected $fillable = ['location_id','name','position','duration'];

    public function location(){
        return $this->belongsTo('App\Models\Location');
    }
}
