<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Models\User;

class Testimonial extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'testimonials';

    protected $fillable = ['slug', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $slug = Str::slug($value, '-');
        $this->attributes['slug'] = strtolower($slug) . "-" . time();
    }

    public function userdetails()
    {
        return $this->belongsTo('App\Models\User', 'user_id')->select("id", "name", "email");
    }

    public function usermoredetails()
    {
        return $this->belongsTo('App\Models\JobSeekerRegistration', 'user_id');
    }
}
