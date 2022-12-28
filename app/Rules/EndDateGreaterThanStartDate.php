<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class EndDateGreaterThanStartDate implements Rule
{
    private $start_work;
    private $end_work;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($start_work)
    {
         $this -> start_work = $start_work;
        //  $this -> end_work = $end_work;
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
        // dd( $value); // end_work
        // dd( $this->start_work); // start_work
           if(Carbon::parse($this->start_work) >= Carbon::parse($value))
               return false;
            else{
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
        return 'يجب ان تكون النهايه اكبر من البدايه';
    }
}
