<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('twitter');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('twitter_url', $url));
})->with([
    'http://twitter.com/#!/cauriland',
    'http://twitter.com/cauriland',
    'https://twitter.com/cauriland',
    'http://www.twitter.com/cauriland',
    'https://www.twitter.com/cauriland',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('twitter_url', $url))->toBeFalse();
})->with([
    'http://twiter.com/cauriland',
    'www.twiter.com/cauriland',
    'http://facebook.com/cauriland',
    'http://facebook.com/cauriland',
    '@cauriland',
    'cauriland',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.twitter_url'));
});
