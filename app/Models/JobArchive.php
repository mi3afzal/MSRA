<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobArchive extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'jobs';

    public function associatedJobtype()
    {
        return $this->belongsTo('App\Models\Archive\JobType', 'job_type_id')->select("id", "type", "parent_id", "interested");
    }

    public function associatedProfession()
    {
        return $this->belongsTo('App\Models\Archive\Profession', 'professions')->select("id", "name");
    }

    public function associatedSeniority()
    {
        return $this->belongsTo('App\Models\Archive\Seniority', 'seniority_id')->select("id", "name");
    }

    public function associatedSpeciality()
    {
        return $this->belongsTo('App\Models\Archive\Speciality', 'speciality_id')->select("id", "name");
    }

    public function associatedState()
    {
        return $this->belongsTo('App\Models\Archive\State', 'state_id')->select("id", "name", "short_code", "status");
    }

    public function associatedCity()
    {
        return $this->belongsTo('App\Models\Archive\City', 'city')->select("id", "name", "short_code", "latitude", "longitude")->select("id", "name", "latitude", "longitude");
    }

    public function associatedCountry()
    {
        return $this->belongsTo('App\Models\Archive\Country', 'country_id')->select("id", "name", "iso_code_2", "status");
    }
}
