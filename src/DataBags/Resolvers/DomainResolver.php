<?php

declare(strict_types=1);

namespace CauriLand\Foundation\DataBags\Resolvers;

use CauriLand\Foundation\DataBags\Contracts\Resolver;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;

class DomainResolver implements Resolver
{
    public function resolve(array $bags, string $key)
    {
        $path = Route::current()->getDomain();

        if (! empty($bags[$key][$path])) {
            return $bags[$key][$path];
        }

        return Arr::get($bags, "$key.*");
    }
}
