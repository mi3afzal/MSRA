<?php

namespace App\Traits;

use App\Models\Brand;
use App\Models\BrandMedia;
use App\Models\BuySell;
use App\Models\BuySellMedia;

trait BuySellMediaTrait
{
    // associated all media
    public function associatedMedia()
    {
        return $this->hasMany('App\Models\BuySellMedia', 'buysell_id')->where('status', '1');
    }

    // associated images
    public function associatedImages()
    {
        return $this->hasMany('App\Models\BuySellMedia', 'buysell_id')->where('type', '1')->where("status", "1");
    }

    // One logo
    public function associatedLogoFile()
    {
        return $this->hasOne('App\Models\BuySellMedia', 'buysell_id')->where('type', '2')->where("status", "1");
    }

    // One favicon
    public function associatedFaviconFile()
    {
        return $this->hasOne('App\Models\BuySellMedia', 'buysell_id')->where('type', '3')->where("status", "1");
    }

    // One banner
    public function associatedBannerFile()
    {
        return $this->hasOne('App\Models\BuySellMedia', 'buysell_id')->where('type', '4')->where("status", "1");
    }

    public function associatedDocument()
    {
        return $this->hasMany('App\Models\BuySellMedia', 'buysell_id')->where('type', '5')->where("status", "1");
    }

    // One main Image
    public function associatedMainImage()
    {
        return $this->hasOne('App\Models\BuySellMedia', 'buysell_id')->where('type', '6')->where("status", "1");
    }

    public function associatedState()
    {
        return $this->belongsTo('App\Models\State', 'state_id')->select("id", "name", "iso2", "latitude", "longitude");
    }

    public function associatedCity()
    {
        return $this->belongsTo('App\Models\City', 'city_id')->select("id", "name", "latitude", "longitude")->select("id", "name", "latitude", "longitude");
    }

    public function associatedSuburb()
    {
        return $this->belongsTo('App\Models\Suburb', 'suburb_id')->select("id", "suburb", "lat", "lng");
    }
}