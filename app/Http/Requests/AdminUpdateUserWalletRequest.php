<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUpdateUserWalletRequest extends FormRequest
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
        return [
            'price' => 'required|numeric',
            'mark' => 'required|in:1,2',
        ];
    }

    public function messages()
    {
        return [
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'يجب ان تكون القيمه رقم',
            'mark.required' => 'يجب تحديد العمليه',
            'mark.in' => 'يجب اختيار اضافه او خصم فقط',
        ];
    }
}
