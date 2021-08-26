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
}
