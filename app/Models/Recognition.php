<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Recognition extends Model
{
    use Translatable;



    protected $table = 'recognitions';
    protected $guarded = [];

    protected $translatedAttributes = ['name'];
    protected $with = ['translations'];
    protected $hidden = ['translations'];





    /////////////// Relations \\\\\\\\\\\\\\\\
    
    public function features(){
        return $this->hasMany(Auction::class , 'recognition_id', 'id');
    }

   
}
