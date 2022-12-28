<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    //
    public $guarded=[];
    public function  getLogoAttribute($logo)
    {
        if ($logo != null) {
            return asset('assets/images/logo/' . $logo);
        } else {
            return null;
        }
    }
}
