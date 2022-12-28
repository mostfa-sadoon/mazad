<?php

namespace App\Rules;

use App\Models\Attribute;
use App\Models\Category;
use App\Models\SubAttribute;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AttributeSubAttributeUniqueName implements Rule
{
    private $name;
    private $attribute_id;
    private $sub_attribute_id;


    public function __construct($name, $attribute_id, $sub_attribute_id = 0)
    {
        $this->name = $name;
        $this->attribute_id = $attribute_id;
        $this->sub_attribute_id = $sub_attribute_id;
    }


    public function passes($attribute, $value)
    {

        if ($this->sub_attribute_id == 0) {    // Insert
            $cat_count = SubAttribute::join('sub_attribute_translations', 'sub_attribute_translations.sub_attribute_id', 'sub_attributes.id')
                ->where('sub_attributes.attribute_id', $this->attribute_id)
                ->where('sub_attribute_translations.name', $this->name)
                ->count();
        } else {  // Update
            $cat_count = SubAttribute::join('sub_attribute_translations', 'sub_attribute_translations.sub_attribute_id', 'sub_attributes.id')
                ->where('sub_attributes.attribute_id', $this->attribute_id)
                ->where('sub_attributes.id', '<>', $this->sub_attribute_id)
                ->where('sub_attribute_translations.name', $this->name)
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
        return 'اسم الصفه الفرعيه موجود مسبقا لهذه الصفه';
    }
}
