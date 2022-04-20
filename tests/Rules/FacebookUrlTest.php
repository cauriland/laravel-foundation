<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('facebook');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('facebook_url', $url));
})->with([
    'http://www.facebook.com/cauriland',
    'http://facebook.com/cauriland',
    'https://www.facebook.com/cauriland',
    'https://facebook.com/cauriland',
    'http://www.facebook.com/#!/cauriland',
    'http://www.facebook.com/pages/Cauriland/Cauri/123456?v=app_5',
    'http://www.facebook.com/pages/Cauri/456',
    'http://www.facebook.com/#!/page_with_1_number',
    'http://www.facebook.com/bounce_page#!/pages/Cauri/456',
    'http://www.facebook.com/bounce_page#!/cauriland?v=app_166292090072334',
    'https://www.facebook.com/100004123456789',
    'https://www.facebook.com/profile.php?id=100004123456789',
    'https://www.fb.me/profile.php?id=100004123456789',
    'http://www.fb.me/profile.php?id=100004123456789',
    'https://fb.me/profile.php?id=100004123456789',
    'http://fb.me/profile.php?id=100004123456789',
    'https://www.facebook.com/groups/cauriland',
    'https://facebook.com/groups/cauriland',
    'http://www.facebook.com/groups/cauriland',
    'http://facebook.com/groups/cauriland',
    'https://fb.me/groups/cauriland',
    'https://www.fb.me/groups/cauriland',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('facebook_url', $url))->toBeFalse();
})->with([
    'http://www.twitter.com/cauriland',
    'cauriland',
    '/cauriland',
    'ftp://www.facebook.com/pages/Cauriland/Cauri/123456?v=app_5',
    'http://www.tacebook.com/bounce_page',
    'https://www.facebook.com/',
    'http://www.facebook.com/',
    'https://facebook.com/',
    'http://facebook.com/',
    'https://fb.me/',
    'https://www.fb.me/',
    'http://www.fb.me/',
    'http://fb.me/',
    'facebook.com/test',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.facebook_url'));
});
