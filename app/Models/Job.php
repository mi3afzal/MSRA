<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\StatusTrait;
use App\Traits\JobModelTrait;
use Illuminate\Pipeline\Pipeline;
use Session;

class Job extends Model
{
    use HasFactory;
    use SoftDeletes;
    use StatusTrait;
    use JobModelTrait;

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

    public static function searchResult()
    {

        $jobs = app(Pipeline::class)
            ->send(\App\Models\Job::query()->active()->with("createdby:id,name,email", "associatedJobtype:id,jobtype", "jobcategory:id,name", "medicalcenter:id,name,email", "associatedProfession:id,profession", "associatedSpeciality:id,specialty", "associatedState:id,name,iso2,latitude,longitude", "associatedCity:id,name,latitude,longitude", "associatedSuburb:id,suburb,lat,lng"))
            ->through([
                \App\QueryFilters\JobType::class,
                \App\QueryFilters\Profession::class,
                \App\QueryFilters\Specialty::class,
                \App\QueryFilters\State::class,
                \App\QueryFilters\City::class,
                \App\QueryFilters\Suburb::class,
            ])
            ->thenReturn()
            ->get();

        return $jobs;
    }
}
