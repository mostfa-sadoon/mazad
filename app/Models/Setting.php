<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
  use Translatable;


  protected $table = 'settings';
  protected $fillable = ['page', 'what', 'value', 'image'];
  protected $translatedAttributes = ['content'];
  protected $with = ['translations'];
  protected $hidden = ['translations'];





  // Get Cover Path
  // protected $append = ['image_cover ,image_path'];
  public function  getImagePathAttribute()
  {
    if ($this->image != null) {
      return asset('assets/images/settings/' . $this->image);
    } else {
      return null;
    }
  }

  //////////// Relations \\\\\\\\\\\\

}
