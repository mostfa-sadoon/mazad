<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientRegisterRequest extends FormRequest
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
    //    $phone = explode($this->country_code, $this->phone)[1];
        return [
            'f_name' => ['required', 'string', 'min:3', 'max:40'],
            'l_name' => ['required', 'string', 'min:3', 'max:40'],
            'country_code' => 'required',
    //        'phone' => ['required','min:10','max:20' , new PhoneRule($this->country_code, $phone) ],
            'phone' => ['required','min:10','max:20'],
            'email' => 'required|email|unique:clients,email',
            'country_id' => 'required|numeric|exists:countries,id',
            'city_id' => 'required|numeric|exists:cities,id',
            'password' => ['required', 'string', 'min:6' , 'max:50'],
            'accept_terms' => ['required'],
          ];
    }

    // public function messages()
    // {
    //     return [
    //         'name.required' => 'الاسم مطلوب',
    //         'name.string' => 'الاسم يجب ان يكون نص',
    //         'name.min' => 'الاسم يجب الا ينقص عن 3 احرف',
    //         'name.max' => 'الاسم يجب الا يزيد عن 40 احرف',
    //         'phone.required' => 'رقم الهاتف مطلوب',
    //         'phone.unique' => 'رقم الهاتف موجود مسبقا',
    //         'level_id.required' => 'المستوى مطلوب',
    //         'level_id.numeric' => 'المستوى يجب ان يكون رقم',
    //         'level_id.exists' => 'المستوى غير صحيح',
    //         'date_year.required' => 'السنه مطلوبه',
    //         'date_year.numeric' => 'السنه يجب ان تكون رقم',
    //         'date_month.required' => 'الشهر مطلوب',
    //         'date_month.numeric' => 'الشهر يجب ان تكون رقم',
    //         'date_day.required' => 'اليوم مطلوب',
    //         'date_day.numeric' => 'اليوم يجب ان تكون رقم',
    //         'gender.required' => 'النوع مطلوب',
    //         'gender.string' => 'النوع يجب ان يكون نص',
    //         'password.required' => 'كلمه المرور مطلوبه',
    //         'password.string' => 'كلمه المرور يجب ان تكون نص',
    //         'password.min' => 'كلمه المرور يجب الا تنقص عن 6 احرق',
    //         'password.max' => 'كلمه المرور يجب الا تزيد عن 50 احرف',
    //     ];
    // }


}
