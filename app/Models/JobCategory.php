<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobCategory extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'job_categories';

    protected $fillable = ['user_id', 'created_at', 'updated_at'];

    /**
     * Accessor function 
     * 
     * @return "returns applied ucwords function text"
     */
    public function getNameAttribute($value)
    {
        return ucwords($value);
    }
}
