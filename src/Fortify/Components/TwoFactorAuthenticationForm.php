<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Fortify\Components;

use CauriLand\Foundation\Fortify\Actions\EnableTwoFactorAuthentication;
use CauriLand\Foundation\Fortify\Actions\GenerateTwoFactorAuthenticationSecretKey;
use CauriLand\Foundation\Fortify\Components\Concerns\InteractsWithUser;
use CauriLand\Foundation\Fortify\Rules\OneTimePassword;
use CauriLand\Foundation\UserInterface\Http\Livewire\Concerns\HasModal;
use CauriLand\Foundation\UserInterface\Rules\CurrentPassword;
use BaconQrCode\Renderer\Color\Rgb;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\Fill;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Laravel\Fortify\Actions\DisableTwoFactorAuthentication;
use Laravel\Fortify\Actions\GenerateNewRecoveryCodes;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Livewire\Component;

class TwoFactorAuthenticationForm extends Component
{
    use InteractsWithUser;
    use HasModal;

    public bool $showingQrCode = false;

    public array $state = [];

    public bool $confirmPasswordShown = false;

    public bool $disableConfirmPasswordShown = false;

    public string $confirmedPassword = '';

    protected $messages = [
        'state.otp.required' => 'Please provide an OTP',
        'state.otp.digits'   => 'One Time Password must be :digits digits.',
    ];

    public function mount(): void
    {
        if (! $this->enabled) {
            $this->generateSecretKey();
        }
    }

    public function render(): View
    {
        return view('cauri-fortify::profile.two-factor-authentication-form');
    }

    public function updatedStateOtp(): void
    {
        $this->resetValidation();
    }

    public function enableTwoFactorAuthentication(): void
    {
        $this->validate([
            'state.otp' => ['required', 'digits:6', new OneTimePassword($this->state['two_factor_secret'])],
        ]);

        app(EnableTwoFactorAuthentication::class)(Auth::user(), $this->state['two_factor_secret']);

        $this->showingQrCode = true;
        $this->state['otp']  = null;
        $this->showRecoveryCodes();
    }

    public function showRecoveryCodes(): void
    {
        $this->openModal();
    }

    public function regenerateRecoveryCodes(): void
    {
        app(GenerateNewRecoveryCodes::class)(Auth::user());

        $this->showRecoveryCodes();
    }

    public function disableTwoFactorAuthentication(): void
    {
        $this->validate();

        app(DisableTwoFactorAuthentication::class)(Auth::user());

        $this->generateSecretKey();
        $this->closeDisableConfirmPassword();

        $this->emit('toastMessage', [
            trans('ui::messages.2fa_disabled'),
            'success',
        ]);
    }

    public function getEnabledProperty(): bool
    {
        return ! empty($this->user->two_factor_secret);
    }

    public function getTwoFactorQrCodeSvgProperty(): string
    {
        $svg = (new Writer(
            new ImageRenderer(
                new RendererStyle(170, 0, null, null, Fill::uniformColor(new Rgb(255, 255, 255), new Rgb(45, 55, 72))),
                new SvgImageBackEnd()
            )
        ))->writeString($this->twoFactorQrCodeUrl);

        return trim(substr($svg, strpos($svg, "\n") + 1));
    }

    public function getTwoFactorQrCodeUrlProperty(): string
    {
        return app(TwoFactorAuthenticationProvider::class)->qrCodeUrl(
            config('app.name'),
            (string) data_get($this->user, config('fortify.username'), 'email'),
            $this->state['two_factor_secret']
        );
    }

    public function hideRecoveryCodes(): void
    {
        $this->closeModal();
    }

    public function showConfirmPassword(): void
    {
        $this->resetValidation();
        $this->confirmPasswordShown = true;
        $this->confirmedPassword    = '';
    }

    public function closeConfirmPassword(): void
    {
        $this->confirmPasswordShown = false;
        $this->confirmedPassword    = '';

        $this->modalClosed();
    }

    public function showDisableConfirmPassword(): void
    {
        $this->resetValidation();
        $this->disableConfirmPasswordShown = true;
        $this->confirmedPassword           = '';
    }

    public function closeDisableConfirmPassword(): void
    {
        $this->disableConfirmPasswordShown = false;
        $this->confirmedPassword           = '';

        $this->modalClosed();
    }

    public function showRecoveryCodesAfterPasswordConfirmation(): void
    {
        $this->validate();

        $this->closeConfirmPassword();

        $this->showRecoveryCodes();
    }

    protected function rules()
    {
        return [
            'confirmedPassword' => ['required', new CurrentPassword(Auth::user())],
        ];
    }

    private function generateSecretKey(): void
    {
        $this->state['two_factor_secret'] = app(GenerateTwoFactorAuthenticationSecretKey::class)();
    }
}
