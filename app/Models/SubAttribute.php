<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class SubAttribute extends Model
{
    use Translatable;

    protected $table = 'sub_attributes';
    protected $guarded = [];


    protected $translatedAttributes = ['name'];
    protected $with = ['translations'];
    protected $hidden = ['translations'];





    
    /////////////// Relations \\\\\\\\\\\\\\\\
    
    public function attribute(){
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
   
}
