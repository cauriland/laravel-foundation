<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('telegram');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('telegram_url', $url));
})->with([
    'https://t.me/cauriland',
    'http://t.me/cauriland',
    'http://telegram.org/cauriland',
    'http://telegram.me/cauriland',
    'http://telegram.me/arkeco.system',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('telegram_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/cauriland',
    'cauriland',
    '/cauriland',
    'ftp://www.telegram.com/something',
    'www.telegram.com/cauriland',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.telegram_url'));
});
