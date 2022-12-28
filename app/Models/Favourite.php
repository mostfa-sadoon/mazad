<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{

    protected $table = 'favourits';
    protected $guarded = [];
    public $timestamps = false;






    ///////////////// Relations \\\\\\\\\\\\\\\\\

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function auction()
    {
        return $this->belongsTo(Auction::class, 'auction_id', 'id');
    }
}
