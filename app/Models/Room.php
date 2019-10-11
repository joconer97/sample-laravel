<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    //
    protected $fillable = ['room_name','room_details','price','capacity'];

    public function beds()
    {
        return $this->belongsToMany('App\Models\Bed')->withPivot('quantity');
    }
}
