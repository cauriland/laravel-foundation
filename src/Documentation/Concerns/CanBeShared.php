<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Documentation\Concerns;

use CauriLand\Foundation\UserInterface\Support\Share;

trait CanBeShared
{
    public function urlFacebook(): string
    {
        return Share::facebook($this->url());
    }

    public function urlReddit(): string
    {
        return Share::reddit($this->url());
    }

    public function urlTwitter(): string
    {
        return Share::twitter($this->url());
    }
}
