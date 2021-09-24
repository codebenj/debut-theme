<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Http;

class RecaptchaValidator implements Rule
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
        $verifyResponse = Http::asForm()->post(config('services.recaptcha.api'), [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
        ])->json();
        
        return $verifyResponse['success'] ?? false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid reCAPTCHA. Please try again later.';
    }
}
