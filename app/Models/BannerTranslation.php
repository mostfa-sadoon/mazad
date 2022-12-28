<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Config;
class BannerTranslation extends Model
{
    //
    protected $guarded=[];
    protected $table='bannerstranslations';
    // public function  getImgAttribute($img)
    // {
    //     if ($img != null) {
    //     return asset('assets/images/banner/'.Config::get('app.locale') .'/'. $img);
    //     } else {
    //     return null;
    //     }
    // }
}
