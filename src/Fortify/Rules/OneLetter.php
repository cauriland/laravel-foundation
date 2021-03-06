<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;

final class OneLetter implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // At least one (unicode) letter
        $regex = '/^.*\p{L}.*$/u';

        return preg_match($regex, $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('ui::validation.messages.include_letters');
    }
}
