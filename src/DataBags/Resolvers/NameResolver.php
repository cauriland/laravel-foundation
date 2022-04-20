<?php

declare(strict_types=1);

namespace CauriLand\Foundation\DataBags\Resolvers;

use CauriLand\Foundation\DataBags\Contracts\Resolver;
use Illuminate\Support\Facades\Route;

class NameResolver implements Resolver
{
    use Concerns\InteractsWithBag;

    public function resolve(array $bags, string $key)
    {
        return $this->resolveFromBag($bags, $key, Route::current()->getName());
    }
}
