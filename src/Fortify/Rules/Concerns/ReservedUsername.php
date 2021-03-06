<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Rules\Concerns;

use Illuminate\Support\Str;

class ReservedUsername extends BaseRule
{
    public static function passes(string $attribute, mixed $value): bool
    {
        return ! in_array(Str::lower($value), trans('ui::username_blacklist'), true);
    }

    public static function message(array $attributes = []): string
    {
        return trans('ui::validation.messages.username.blacklisted');
    }
}
