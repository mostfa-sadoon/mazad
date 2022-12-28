<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{

  protected $table = 'sliders';
  protected $guarded = [];




  public function  getImageAttribute($image)
  {
    if ($image != null) {
      return asset('assets/images/sliders/' . $image);
    } else {
      return null;
    }
  }


  ///////////////// Relations \\\\\\\\\\\\\\\\\\\\\\\\



}
