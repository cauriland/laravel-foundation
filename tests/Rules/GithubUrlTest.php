<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('github');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('github_url', $url));
})->with([
    'https://github.com/cauriland/socials',
    'http://github.com/cauriland/socials',
    'http://www.github.com/cauriland',
    'https://github.com/cauriland',
    'https://github.com/cauriland?somethig=1',
    'https://github.com/cauriland/',
    'https://github.com/cauriland/marketsquare.io',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('github_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/cauriland',
    'cauriland',
    '/cauriland',
    'ftp://www.github.com/something',
    'www.github.com/cauriland',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.github_url'));
});
