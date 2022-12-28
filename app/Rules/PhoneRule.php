<?php

namespace App\Rules;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class PhoneRule implements Rule
{
    private $country_code;
    private $phone;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($country_code, $phone)
    {
        $this->country_code = $country_code;
        $this->phone = $phone;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $client = '';
        if (auth('client') && auth('client')->id() != null) {
            $client = Client::where([
                'country_code' => $this->country_code,
                'phone' => $this->phone
            ])->where('id', '<>', auth('client')->id())
                ->first();
        } else {
            $client = Client::where([
                'country_code' => $this->country_code,
                'phone' => $this->phone
            ])->first();
        }

        if ($client)
            return false;
        else {
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'phone number with country code already exists';
    }
}
