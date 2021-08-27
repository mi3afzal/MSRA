<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $table = 'states';

    protected $fillable = ['user_id', 'created_at', 'updated_at'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    // protected $dates = ['deleted_at'];

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getIso2Attribute($value)
    {
        return strtoupper($value);
    }

    public function cities()
    {
        return $this->hasMany('App\Models\City', 'state_id');
    }

    public function suburbs()
    {
        return $this->hasMany('App\Models\Suburb', 'state_id');
    }
}
