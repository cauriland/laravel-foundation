<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('reddit');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('reddit_url', $url));
})->with([
    'https://old.reddit.com/user/cauri',
    'https://reddit.com/u/cauri',
    'https://www.reddit.com/r/Ripple',
    'https://www.reddit.com/user/nvok/',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('reddit_url', $url))->toBeFalse();
})->with([
    'http://reddit.com/cauriland',
    'www.reddit.com/cauriland',
    '@cauriland',
    'cauriland',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.reddit_url'));
});
