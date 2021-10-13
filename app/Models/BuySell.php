<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Traits\BuySellMediaTrait;


class BuySell extends Model
{
    use HasFactory;
    use SoftDeletes;

    // Relation belongs to Buy Sell Media are in this trait.
    use BuySellMediaTrait;

    protected $table = 'buy_sells';

    // const EXCERPT_LENGTH = 250;

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
     * Function for return base_url buysell image.
     * 
     * @return "returns excerpt for given text"
     */
    public function imageurl()
    {
        return url('/images/buysell/') . "/";
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
}
