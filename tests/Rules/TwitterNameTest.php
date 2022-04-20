<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceName;

beforeEach(function (): void {
    $this->subject = new ServiceName('twitter');
});

it('validates a valid name', function ($name) {
    $this->assertTrue($this->subject->passes('twitter_name', $name));
})->with([
    'cauriland',
    '@cauriland',
    'CauriLand',
    'ark_ecosystem',
    'cauri-land',
]);

it('invalidates an invalid name', function ($name) {
    expect($this->subject->passes('twitter_name', $name))->toBeFalse();
})->with([
    'http://twiter.com/cauriland',
    'www.twiter.com/cauriland',
    '/cauriland',
    'cauri.ecosystem',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.twitter_name'));
});
