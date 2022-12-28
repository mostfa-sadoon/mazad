<?php

namespace App\Http\Requests;

use App\Rules\AuctionAttrsRule;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class AuctionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if ($this->features && count($this->features) != 0) {
            return [
                'name' => 'required|string|min:2|max:191',
                // 'slug' => 'required|unique:auctions,slug|string|min:2|max:191',

                'description' => 'required|string|min:2',
                'start_date' => 'required|after_or_equal:' . Carbon::now()->subHour(),
                'end_date' => 'required|after:' . $this->start_date,
                'min_price' => 'required|numeric',
                'max_price' => 'required|numeric|gt:min_price',
                'country_id' => 'required|exists:countries,id',
                'city_id' => 'required|exists:cities,id',
                'category_id' => 'required|exists:categories,id',
                'cover' => 'required|image',
                'video' => 'nullable|string|min:2|max:191',
                'images' => 'nullable',
                'features' => [new AuctionAttrsRule($this->features) ],
                // 'features' => 'required|array|min:'.count(explode('-', $this->attributes_ids)).'|max:'.count(explode('-', $this->attributes_ids)),
                // 'features.*' => 'required',
            ];
        }
        
        return [
            'name' => 'required|string|min:2|max:191',
            // 'slug' => 'required|unique:auctions,slug|string|min:2|max:191',

            'description' => 'required|string|min:2',
            'start_date' => 'required|after_or_equal:' . Carbon::now()->subHour(),
            'end_date' => 'required|after:' . $this->start_date,
            'min_price' => 'required|numeric',
            'max_price' => 'required|numeric|gt:min_price',
            'city_id' => 'required|exists:cities,id',
            'category_id' => 'required|exists:categories,id',
            'cover' => 'required|image',
            'video' => 'nullable|string|min:2|max:191',
            'images' => 'nullable'
        ];
    }
}
