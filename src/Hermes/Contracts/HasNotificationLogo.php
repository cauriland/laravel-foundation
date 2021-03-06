<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Hermes\Contracts;

use Spatie\MediaLibrary\MediaCollections\Models\Media;

interface HasNotificationLogo
{
    public function logo(): ?Media;

    public function fallbackIdentifier(): ?string;
}
