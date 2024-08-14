<?php
namespace App\Rules;


use Illuminate\Contracts\Validation\Rule;

class MatchArrayCount implements Rule
{
    protected $otherArray;


    public function __construct($otherArray)
    {
        $this->otherArray = $otherArray;
    }

    public function passes($attribute, $value)
    {
        $otherArray = request($this->otherArray); // Get the other array from the request
        return is_array($value) && is_array($otherArray) && count($value) === count($otherArray);
    }

    public function message()
    {
        return 'The :attribute must have the same number of items as ' . $this->otherArray;
    }
}
