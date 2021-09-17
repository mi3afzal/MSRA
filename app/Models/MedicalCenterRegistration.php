<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MedicalCenterRegistration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'medical_center_registrations';

    protected $fillable = ['user_id', 'created_at', 'updated_at'];

    public function statedetails()
    {
        return $this->belongsTo('App\Models\State', 'state')->select("id", "name", "iso2", "latitude", "longitude", "timezone");
    }

    public function citydetails()
    {
        return $this->belongsTo('App\Models\City', 'state')->select("id", "name", "postcode", "latitude", "longitude");
    }

    public function suburbdetails()
    {
        return $this->belongsTo('App\Models\Suburb', 'state')->select("id", "suburb", "postcode", "state", "lat", "lng", "timezone");
    }
}