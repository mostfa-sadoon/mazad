<?php

namespace App\Rules;

use App\Models\Attribute;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CategoryAttributeUniqueName implements Rule
{
    private $name;
    private $category_id;
    private $attribute_id;


    public function __construct($name, $category_id, $attribute_id = 0)
    {
        $this->name = $name;
        $this->category_id = $category_id;
        $this->attribute_id = $attribute_id;
    }


    public function passes($attribute, $value)
    {

        if ($this->attribute_id == 0) {    // Insert
            $cat_count = Attribute::join('attribute_translations', 'attribute_translations.attribute_id', 'attributes.id')
                ->where('attributes.category_id', $this->category_id)
                ->where('attribute_translations.name', $this->name)
                ->count();
        } else {  // Update
            $cat_count = Attribute::join('attribute_translations', 'attribute_translations.attribute_id', 'attributes.id')
                ->where('attributes.category_id', $this->category_id)
                ->where('attributes.id', '<>', $this->attribute_id)
                ->where('attribute_translations.name', $this->name)
                ->count();
        }

        // dd($cat_count);

        if ($cat_count == 0) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'اسم الصفه موجود مسبقا لهذا القسم';
    }
}
