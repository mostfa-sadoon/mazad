<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class HomeSection extends Model
{
    //
    use Translatable;
    public $table='home_sections';
    protected $guarded=[];
    protected $translatedAttributes = ['name','desc'];
    public $timestamps = false;

    public function  getLogoAttribute($logo)
    {
        if ($logo != null) {
            return asset('assets/images/homesection/' . $logo);
        } else {
            return null;
        }
    }
}
