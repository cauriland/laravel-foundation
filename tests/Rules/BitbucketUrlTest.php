<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('bitbucket');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('facebook_url', $url));
})->with([
    'https://bitbucket.org/cauriland/socials',
    'https://bitbucket.com/cauriland/socials',
    'http://www.bitbucket.org/cauriland',
    'https://bitbucket.org/cauriland',
    'https://bitbucket.org/cauriland?somethig=1',
    'https://bitbucket.org/cauriland/',
    'https://bitbucket.org/cauriland/dailytask-15-07-2020/src/master/',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('bitbucket_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/cauriland',
    'cauriland',
    '/cauriland',
    'ftp://www.bitbucket.com/something',
    'www.bitbucket.com/cauriland',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.bitbucket_url'));
});
