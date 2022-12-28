<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Translatable;



    protected $table = 'cities';
    protected $guarded = [];

    protected $translatedAttributes = ['name'];
    protected $with = ['translations'];
    protected $hidden = ['translations'];


    ///////////////////// Relations ///////////////////////

    public function country(){
        return $this->belongsTo(Country::class , 'country_id' , 'id');
    }

   
}
