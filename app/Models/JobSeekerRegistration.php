<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobSeekerRegistration extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'job_seeker_registrations';

    protected $fillable = ['user_id', 'created_at', 'updated_at'];

    public function getFullnameAttribute($value)
    {
        return ucwords($value);
    }

    /**
     * Get the user that owns the record.
     */
    public function user()
    {
        return $this->belongsTo("App\Models\User", "id");
    }

    /**
     * Get the profession details.
     */
    public function profession()
    {
        return $this->belongsTo("App\Models\Profession", "profession", "id")->select("id", "unique_code", "profession");
    }

    /**
     * Get the speciality details.
     */
    public function speciality()
    {
        return $this->belongsTo("App\Models\Specialty", "specialty", "id")->select("id", "unique_code", "specialty");
    }
}
