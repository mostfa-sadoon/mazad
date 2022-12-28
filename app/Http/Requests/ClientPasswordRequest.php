<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientPasswordRequest extends FormRequest
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
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6|max:50',
          ];
    }

    public function messages()
    {
        return [
            'old_password.required' => 'كلمه المرور الحاليه مطلوبه',
            'password.required' => 'كلمه المرور مطلوبه',
            'password.confirmed' => 'كلمه المرور غير متطابقه مع التاكيد',
            'password.max' => 'كلمه المرور يجب الا تزيد عن 50 احرف',
            'password.min' => 'كلمه المرور يجب الا تقل عن 6 احرف',
        ];
    }


}
