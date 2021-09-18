<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

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
}
