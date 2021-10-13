<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class About extends Model
{
    use HasFactory;

    /**
     * Function for return url of aboutus image.
     * 
     * @return "returns base_url for aboutus image"
     */
    public function imageurl()
    {
        return url('/images/aboutus/') . "/";
    }
}
