<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuctionFeature extends Model
{
    
    protected $table = 'auction_features';
    protected $guarded = [];
    public $timestamps = false;

    /////////////// Relations \\\\\\\\\\\\\\\\
    public function auction(){
        return $this->belongsTo(Auction::class , 'auction_id', 'id');
    }

    public function attribute(){
        return $this->belongsTo(Attribute::class , 'attribute_id', 'id');
    }

    public function sub_attribute(){
        return $this->belongsTo(SubAttribute::class , 'sub_attribute_id', 'id');
    }
}
