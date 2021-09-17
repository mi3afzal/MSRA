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
}
