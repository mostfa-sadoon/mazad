<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use Translatable;

    protected $table = 'attributes';
    protected $guarded = [];


    protected $translatedAttributes = ['name'];
    protected $with = ['translations'];
    protected $hidden = ['translations'];





    
    /////////////// Relations \\\\\\\\\\\\\\\\
    
    public function sub_attributes(){
        return $this->hasMany(SubAttribute::class, 'attribute_id');
    }
    
    public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
   
}
