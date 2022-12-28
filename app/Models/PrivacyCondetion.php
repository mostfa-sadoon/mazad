<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class PrivacyCondetion extends Model
{
    //
    use Translatable;
    public $table='terms';
    protected $guarded=[];
    protected $translatedAttributes = ['desc'];
    protected $translationForeignKey='privecycondetion_id';
    public $timestamps = false;

}
