<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suburb extends Model
{
    use HasFactory;

    public function state()
    {
        return $this->belongsTo('App\Models\State', 'state_id', 'id');
    }
}
