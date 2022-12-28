<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    protected $table = 'categories';
    protected $guarded = [];


    protected $translatedAttributes = ['name'];
    protected $with = ['translations'];
    protected $hidden = ['translations'];



    public function  getImageAttribute($image)
    {
        if ($image != null) {
            return asset('assets/images/categories/' . $image);
        } else {
            return null;
        }
    }


    public function scopeParent($query){
        return $query -> whereNull('parent_id');
    }
    public function scopeChild($query){
        return $query -> whereNotNull('parent_id');
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }



    
    /////////////// Relations \\\\\\\\\\\\\\\\
    
    public function _parent(){
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function childrens(){
        return $this->hasMany(self::class, 'parent_id');
    }
    
    public function attributes(){
        return $this->hasMany(Attribute::class, 'category_id');
    }
}
