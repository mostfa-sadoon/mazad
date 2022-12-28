<?php

namespace App\Models;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    //
    use Translatable;
    public $table='privacycondetions';
    protected $guarded=[];
    protected $translatedAttributes = ['desc'];
    protected $translationForeignKey='term_id';
    public $timestamps = false;

}
