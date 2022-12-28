<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Quetion extends Model  implements TranslatableContract
{
    //
    use Translatable;
    protected  $table='quetions';
    protected $guarded=[];
    protected $translatedAttributes=['quetion','answer'];
    public $timestamps = false;
}
