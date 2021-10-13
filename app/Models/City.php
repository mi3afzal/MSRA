<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns relation between state"
     */
    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id', 'id');
    }
}
