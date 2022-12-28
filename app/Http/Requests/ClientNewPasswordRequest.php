<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientNewPasswordRequest extends FormRequest
{
    
    
    public function authorize()
    {
        return true;
    }

   
    
    public function rules()
    {
        return [
            'password' => 'required|confirmed|min:6|max:191',
          ];
    }


}
