<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Spam implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        preg_match('#<a[\s]+([^>]+)>((?:.(?!\<\/a\>))*.)</a>#',$value,$a);
            if($a)
                $fail('The :attribute contains unwanted data.');
            else
            {
                $bHasLink = strpos($value, 'http') !== false || strpos($value, 'www.') !== false;
                if($bHasLink)
                    $fail('The :attribute contains unwanted data.');
            }
    }
}
