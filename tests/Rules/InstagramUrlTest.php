<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('instagram');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('instagram_url', $url));
})->with([
    'https://instagram.com/__disco__dude',
    'https://instagram.com/disco.dude',
    'https://www.instagr.am/__disco__dude',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('instagram_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/cauriland',
    'cauriland',
    '/cauriland',
    'ftp://www.instagram.com/something',
    'www.instagram.com/cauriland',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.instagram_url'));
});
