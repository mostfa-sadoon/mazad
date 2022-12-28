<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model implements TranslatableContract
{
    //
    use Translatable;
    public $table='aboutus';
    protected $guarded=[];
    protected $translatedAttributes = ['name'];
    // protected $with = ['translations'];
    // protected $hidden = ['translations'];
    public $timestamps = false;
}
