<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('gitlab');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('gitlab_url', $url));
})->with([
    'https://gitlab.com/cauriland/socials',
    'http://gitlab.com/cauriland/socials',
    'https://gitlab.com/a',
    'https://gitlab.com/a/c6',
    'http://www.gitlab.com/cauriland',
    'https://gitlab.com/cauriland',
    'https://gitlab.com/cauriland?somethig=1',
    'https://gitlab.com/cauriland/',
    'https://gitlab.com/cauriland/marketsquare.io',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('gitlab_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/cauriland',
    'cauriland',
    '/cauriland',
    'ftp://www.gitlab.com/something',
    'www.gitlab.com/cauriland',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.gitlab_url'));
});
