<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biding extends Model
{
    
    protected $table = 'bidings';
    protected $guarded = [];





    /////////////// Relations \\\\\\\\\\\\\\\\
    public function client(){
        return $this->belongsTo(Client::class , 'client_id', 'id');
    }
}
