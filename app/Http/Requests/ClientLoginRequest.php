<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientLoginRequest extends FormRequest
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
            'phone' => 'required',
            'password' => ['required', 'max:50'],
          ];
    }

    public function messages()
    {
        return [
            'phone.required' => 'رقم الهاتف مطلوب',
            'password.required' => 'كلمه المرور مطلوبه',
            'password.max' => 'كلمه المرور يجب الا تزيد عن 50 احرف',
        ];
    }


}
