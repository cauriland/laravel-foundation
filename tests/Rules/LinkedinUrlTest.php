<?php

declare(strict_types=1);

use CauriLand\Foundation\Rules\ServiceLink;

beforeEach(function (): void {
    $this->subject = new ServiceLink('linkedin');
});

it('validates a valid url', function ($url) {
    $this->assertTrue($this->subject->passes('linkedin_url', $url));
})->with([
    'http://linkedin.com/in/cauriland',
    'https://linkedin.com/in/cauriland',
    'http://www.linkedin.com/in/cauriland',
    'https://www.linkedin.com/in/cauriland',
    'https://www.linkedin.com/in/sam-harper-pittam-64578b177/',
    'https://www.linkedin.com/company/linkedin/',
]);

it('invalidates an invalid url', function ($url) {
    expect($this->subject->passes('linkedin_url', $url))->toBeFalse();
})->with([
    'ftp://linkedin.com/in/cauriland',
    'http://twitter.com/in/cauriland',
    'http://linkedin.com/cauriland',
    'linkedin.com/cauriland',
    '@cauriland',
    'cauriland',
]);

it('has an error message', function () {
    expect($this->subject->message())->toBe(trans('ui::validation.social.linkedin_url'));
});
