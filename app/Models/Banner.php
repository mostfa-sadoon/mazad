<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

  use Translatable;
  protected $translatedAttributes = ['img'];
  protected $table = 'banners';
  protected $guarded = [];
  // protected $timestamp = false;




  public function  getImageAttribute($image)
  {
    if ($image != null) {
      return asset('assets/images/bannars/' . $image);
    } else {
      return null;
    }
  }


  ///////////////// Relations \\\\\\\\\\\\\\\\\\\\\\\\



}
