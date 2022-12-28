<?php

namespace App\Http\Requests;

use App\Rules\PhoneRule;
use Illuminate\Foundation\Http\FormRequest;

class ClientEditPasswordRequest extends FormRequest
{
    
    
    public function authorize()
    {
        return true;
    }

   
    
    public function rules()
    {
        return [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6|max:191',
          ];
    }


}
