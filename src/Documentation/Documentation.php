<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Documentation;

use CauriLand\Foundation\Documentation\Concerns\CanBeShared;
use Illuminate\Database\Eloquent\Model;
use Sushi\Sushi;

class Documentation extends Model
{
    use CanBeShared;
    use Sushi;

    public function url(): string
    {
        return route('documentation', $this->slug);
    }
}
