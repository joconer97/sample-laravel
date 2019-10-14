<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryHistory extends Model
{
    //
    protected $fillable = ['item_id','status','quantity'];
}
