<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientProfileRequest extends FormRequest
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
        $phone = explode($this->country_code, $this->phone)[1];
        // dd($phone);
        return [
            'f_name' => ['required', 'string', 'min:3', 'max:40'],
            'l_name' => ['required', 'string', 'min:3', 'max:40'],
            'country_code' => 'required',
            'phone' => ['required','min:10','max:20' , new PhoneRule($this->country_code, $phone) ],
            'email' => 'required|email|unique:clients,email,'.auth('client')->id(),
            'country_id' => 'required|numeric|exists:countries,id',
            'photo' => 'nullable|image',
          ];
    }


}
