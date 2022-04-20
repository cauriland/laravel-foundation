<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Support\Facades;

use CauriLand\Foundation\Support\Services\Visitor as Service;
use Illuminate\Support\Facades\Facade;

/**
 * @method static self isEuropean()
 *
 * @see \CauriLand\Foundation\Support\Services\Visitor
 */
class Visitor extends Facade
{
    protected static function getFacadeAccessor()
    {
        return Service::class;
    }
}
