<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'jobs';

    const EXCERPT_LENGTH = 250;

    protected $fillable = ['description', 'user_id', 'created_at', 'updated_at'];

    public function excerpt()
    {
        return Str::limit($this->description, env('EXCERPT_LENGTH', 250));
        // return Str::limit($this->description, BuySell::EXCERPT_LENGTH);
    }

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $slug = Str::slug($value, '-');
        $this->attributes['slug'] = strtolower($slug) . "-" . time();
    }

    public function createdby()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->select("name", "email", "id");
    }

    public function associatedJobtype()
    {
        return $this->belongsTo('App\Models\JobType', 'job_type')->select("id", "jobtype");
    }

    public function jobcategory()
    {
        return $this->belongsTo('App\Models\JobCategory', 'job_category')->select("id", "name");
    }

    public function medicalcenter()
    {
        return $this->belongsTo('App\Models\User', 'medical_center')->select("id", "name", "email");
    }

    public function associatedProfession()
    {
        return $this->belongsTo('App\Models\Profession', 'profession')->select("id", "profession");
    }

    public function associatedSpeciality()
    {
        return $this->belongsTo('App\Models\Specialty', 'speciality')->select("id", "specialty");
    }

    public function associatedState()
    {
        return $this->belongsTo('App\Models\State', 'state')->select("id", "name", "iso2", "latitude", "longitude");
    }

    public function associatedCity()
    {
        return $this->belongsTo('App\Models\City', 'city')->select("id", "name", "latitude", "longitude")->select("id", "name", "latitude", "longitude");
    }

    public function associatedSuburb()
    {
        return $this->belongsTo('App\Models\Suburb', 'suburb')->select("id", "suburb", "lat", "lng");
    }
}
