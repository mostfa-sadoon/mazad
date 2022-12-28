<?php

namespace App\Models;

// use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    // use Translatable;



    protected $table = 'auctions';
    protected $guarded = [];

    // protected $translatedAttributes = ['name' , 'description'];
    // protected $with = ['translations'];
    // protected $hidden = ['translations'];



    public function  getCoverAttribute($cover)
    {
        if ($cover != null) {
            return asset('assets/images/auctions/' . $cover);
        } else {
            return null;
        }
    }

    public function  getVideoAttribute($video)
    {
        if ($video != null) {
            // $base_url = "https://www.youtube.com/embed/";
            // $video_id = explode('?v=' , $video);
            return "https://www.youtube.com/embed/" . explode('?v=', $video)[1];
        } else {
            return null;
        }
    }

    public function setSlugAttribute($value)
    {
        $this->attributes['slug'] = str_slug($value);
    }



    /////////////// Relations \\\\\\\\\\\\\\\\
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function recognition()
    {
        return $this->belongsTo(Recognition::class, 'recognition_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(AuctionImage::class, 'auction_id', 'id');
    }

    public function bidings()
    {
        return $this->hasMany(Biding::class, 'auction_id', 'id');
    }

    public function features()
    {
        return $this->hasMany(AuctionFeature::class, 'auction_id', 'id');
    }
}
