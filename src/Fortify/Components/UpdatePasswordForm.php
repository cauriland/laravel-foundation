<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Components;

use CauriLand\Foundation\Fortify\Components\Concerns\InteractsWithUser;
use CauriLand\Foundation\Fortify\Components\Concerns\ValidatesPassword;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;

class UpdatePasswordForm extends Component
{
    use InteractsWithUser;
    use ValidatesPassword;

    public string $currentPassword = '';

    public ?string $password = '';

    public ?string $password_confirmation = '';

    protected $listeners = ['passwordUpdated' => 'passwordUpdated'];

    /**
     * Update the user's password.
     *
     * @param \Laravel\Fortify\Contracts\UpdatesUserPasswords $updater
     *
     * @return void
     */
    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();

        $updater->update(Auth::user(), [
            'current_password'      => $this->currentPassword,
            'password'              => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        $this->currentPassword       = '';
        $this->password              = '';
        $this->password_confirmation = '';

        $this->dispatchBrowserEvent('updated-password');
        $this->resetRules();

        $this->emit('toastMessage', [trans('ui::pages.user-settings.password_updated'), 'success']);
    }

    public function updated(string $property): void
    {
        $this->clearValidation($property);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('cauri-fortify::profile.update-password-form');
    }
}
