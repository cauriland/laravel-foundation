<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

final class SendFeedback extends Mailable implements ShouldQueue
{
    use Queueable;

    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function build(): self
    {
        return $this
            ->from(config('fortify.mail.default.address'), config('fortify.mail.default.name'))
            ->subject(trans('ui::mails.feedback_subject'))
            ->markdown('cauri-fortify::mails.profile.feedback');
    }
}
