<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Author implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $number = preg_match('@[0-9]@', $value);
        return $number;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'La :attribute debe tener al menos 8 caracteres y debe incluir al menos una letra mayúscula, un número y un carácter especial.';
    }
}
