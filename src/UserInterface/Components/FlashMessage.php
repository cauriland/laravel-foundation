<?php

declare(strict_types=1);

namespace CauriLand\Foundation\UserInterface\Components;

use Livewire\Component;

class FlashMessage extends Component
{
    public $message;

    public $type;

    protected $listeners = ['flashMessage' => 'handleIncomingMessage'];

    public function render()
    {
        return view('cauri::livewire.flash-message', [
            'message' => $this->message,
            'type'    => $this->type,
        ]);
    }

    public function handleIncomingMessage(array $message): void
    {
        $this->message = $message[0];
        $this->type    = $message[1];
    }

    public function alertType(): string
    {
        return $this->type;
    }
}
