<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Picasso;

use mersenne_twister\twister;

final class Mersenne
{
    private twister $twister;

    public function __construct(int $seed)
    {
        ini_set('precision', '16');

        $this->twister = new twister($seed);
    }

    public function random(): float
    {
        return $this->twister->real_halfopen();
    }
}
