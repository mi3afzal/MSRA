<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suburb extends Model
{
    use HasFactory;
    public $timestamps = false;

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id', 'id');
    }
}
