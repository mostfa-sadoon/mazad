<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionImage extends Model
{

    protected $table = 'auction_images';
    protected $guarded = [];
    public $timestamps = false;




    public function  getImageAttribute($image)
    {
        if ($image != null) {
            return asset('assets/images/auctions/' . $image);
        } else {
            return null;
        }
    }
}
