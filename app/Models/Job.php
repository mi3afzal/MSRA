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
    protected $guarded = [];

    const EXCERPT_LENGTH = 250;

    protected $fillable = ['description', 'user_id', 'created_at', 'updated_at'];

    /**
     * Function for return excerpt of given text.
     * 
     * @return "returns excerpt for given text"
     */
    public function excerpt()
    {
        return Str::limit($this->description, env('EXCERPT_LENGTH', 250));
        // return Str::limit($this->description, BuySell::EXCERPT_LENGTH);
    }

    /**
     * Mutator function for creating slug from title.
     * 
     * @return "returns slug for given title."
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $slug = Str::slug($value, '-');
        $this->attributes['slug'] = strtolower($slug) . "-" . time();
    }


    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function createdby()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->select("name", "email", "id");
    }

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function associatedJobtype()
    {
        return $this->belongsTo('App\Models\JobType', 'job_type')->select("id", "jobtype");
    }

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function jobcategory()
    {
        return $this->belongsTo('App\Models\JobCategory', 'job_category')->select("id", "name");
    }

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function medicalcenter()
    {
        return $this->belongsTo('App\Models\User', 'medical_center')->select("id", "name", "email");
    }

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function associatedProfession()
    {
        return $this->belongsTo('App\Models\Profession', 'profession')->select("id", "profession");
    }

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function associatedSpeciality()
    {
        return $this->belongsTo('App\Models\Specialty', 'speciality')->select("id", "specialty");
    }

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function associatedState()
    {
        return $this->belongsTo('App\Models\State', 'state')->select("id", "name", "iso2", "latitude", "longitude");
    }

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function associatedCity()
    {
        return $this->belongsTo('App\Models\City', 'city')->select("id", "name", "latitude", "longitude");
    }

    /**
     * Function for eloquent relationship.
     * 
     * @return "returns eloquent relationship"
     */
    public function associatedSuburb()
    {
        return $this->belongsTo('App\Models\Suburb', 'suburb')->select("id", "suburb", "lat", "lng");
    }
}
