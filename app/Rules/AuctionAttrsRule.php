<?php

namespace App\Rules;

use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AuctionAttrsRule implements Rule
{
    private $features;


    public function __construct($features)
    {
        $this->features = $features;
    }


    public function passes($attribute, $value)
    {
        
        foreach ($this->features as $key => $item) {
            if ($item == null) return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'You must enter a value for each attribute';
    }
}
