<?php

declare(strict_types=1);

namespace CauriLand\Foundation\DataBags\Contracts;

interface Resolver
{
    /**
     * @return mixed
     */
    public function resolve(array $bags, string $key);
}
