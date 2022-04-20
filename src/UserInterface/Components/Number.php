<?php

declare(strict_types=1);

namespace CauriLand\Foundation\UserInterface\Components;

use CauriLand\Foundation\NumberFormatter\NumberFormatter;
use Closure;
use Illuminate\View\Component;

final class Number extends Component
{
    public function render(): Closure
    {
        return function (array $data): string {
            return NumberFormatter::new()->formatWithDecimal((float) trim((string) $data['slot']));
        };
    }
}
