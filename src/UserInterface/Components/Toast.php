<?php

declare(strict_types=1);

namespace CauriLand\Foundation\UserInterface\Components;

use Livewire\Component;

class Toast extends Component
{
    public $toasts = [];

    protected $listeners = [
        'toastMessage' => 'handleIncomingMessage',
        'dismissToast' => 'dismissToast',
    ];

    public function render()
    {
        return view('cauri::livewire.toast', [
            'toasts' => $this->toasts,
        ]);
    }

    public function handleIncomingMessage(array $message): void
    {
        $this->toasts[uniqid()] = [
            'message' => $message[0],
            'type'    => $message[1],
        ];
    }

    public function dismissToast(string $id): void
    {
        unset($this->toasts[$id]);
    }
}
