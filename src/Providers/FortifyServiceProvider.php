<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Providers;

use CauriLand\Foundation\Fortify\Actions\AuthenticateUser;
use CauriLand\Foundation\Fortify\Actions\CreateNewUser;
use CauriLand\Foundation\Fortify\Actions\DeleteUser;
use CauriLand\Foundation\Fortify\Actions\ResetUserPassword;
use CauriLand\Foundation\Fortify\Actions\UpdateUserPassword;
use CauriLand\Foundation\Fortify\Actions\UpdateUserProfileInformation;
use CauriLand\Foundation\Fortify\Components\DeleteUserForm;
use CauriLand\Foundation\Fortify\Components\ExportUserData;
use CauriLand\Foundation\Fortify\Components\FooterEmailSubscriptionForm;
use CauriLand\Foundation\Fortify\Components\LogoutOtherBrowserSessionsForm;
use CauriLand\Foundation\Fortify\Components\RegisterForm;
use CauriLand\Foundation\Fortify\Components\ResetPasswordForm;
use CauriLand\Foundation\Fortify\Components\TwoFactorAuthenticationForm;
use CauriLand\Foundation\Fortify\Components\UpdatePasswordForm;
use CauriLand\Foundation\Fortify\Components\UpdateProfileInformationForm;
use CauriLand\Foundation\Fortify\Components\UpdateProfilePhotoForm;
use CauriLand\Foundation\Fortify\Components\UpdateTimezoneForm;
use CauriLand\Foundation\Fortify\Components\VerifyEmail;
use CauriLand\Foundation\Fortify\Console\Commands\CreateUserCommand;
use CauriLand\Foundation\Fortify\Console\Commands\RunPlaybookCommand;
use CauriLand\Foundation\Fortify\Contracts\DeleteUser as DeleteUserContract;
use CauriLand\Foundation\Fortify\Contracts\UserRole as UserRoleContract;
use CauriLand\Foundation\Fortify\Http\Controllers\TwoFactorAuthenticatedPasswordResetController;
use CauriLand\Foundation\Fortify\Http\Responses\FailedPasswordResetLinkRequestResponse as FortifyFailedPasswordResetLinkRequestResponse;
use CauriLand\Foundation\Fortify\Http\Responses\SuccessfulPasswordResetLinkRequestResponse as FortifySuccessfulPasswordResetLinkRequestResponse;
use CauriLand\Foundation\Fortify\Models;
use CauriLand\Foundation\Fortify\Responses\FailedTwoFactorLoginResponse;
use CauriLand\Foundation\Fortify\Responses\RegisterResponse;
use CauriLand\Foundation\Fortify\Responses\TwoFactorLoginResponse;
use CauriLand\Foundation\Fortify\Support\Enums\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\FailedPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse as FailedTwoFactorLoginResponseContract;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Contracts\TwoFactorLoginResponse as TwoFactorLoginResponseContract;
use Laravel\Fortify\Features;
use Laravel\Fortify\Fortify;
use Livewire\Livewire;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerResponseBindings();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishers();

        $this->registerLivewireComponents();

        $this->registerActions();

        $this->registerViews();

        $this->registerAuthentication();

        $this->registerRoutes();

        $this->registerCommands();

        $this->registerContracts();
    }

    /**
     * Register the publishers.
     *
     * @return void
     */
    public function registerPublishers(): void
    {
        $this->publishes([
            __DIR__.'/../../config/fortify.php' => config_path('fortify.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/newsletter.php',
            'newsletter'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../../config/fortify.php',
            'fortify'
        );

        $this->publishes([
            __DIR__.'/../../resources/views/auth'       => resource_path('views/auth'),
            __DIR__.'/../../resources/views/components' => resource_path('views/components'),
            __DIR__.'/../../resources/views/profile'    => resource_path('views/profile'),
            __DIR__.'/../../resources/views/account'    => resource_path('views/account'),
        ], 'foundation-views');

        $this->publishes([
            __DIR__.'/../../resources/images' => resource_path('images'),
        ], 'images');
    }

    /**
     * Register the Livewire components.
     *
     * @return void
     */
    public function registerLivewireComponents(): void
    {
        Livewire::component('profile.delete-user-form', DeleteUserForm::class);
        Livewire::component('profile.export-user-data', ExportUserData::class);
        Livewire::component('profile.logout-other-browser-sessions-form', LogoutOtherBrowserSessionsForm::class);
        Livewire::component('profile.two-factor-authentication-form', TwoFactorAuthenticationForm::class);
        Livewire::component('profile.update-password-form', UpdatePasswordForm::class);
        Livewire::component('profile.update-profile-information-form', UpdateProfileInformationForm::class);
        Livewire::component('profile.update-profile-photo-form', UpdateProfilePhotoForm::class);
        Livewire::component('profile.update-timezone-form', UpdateTimezoneForm::class);
        Livewire::component('auth.register-form', RegisterForm::class);
        Livewire::component('auth.reset-password-form', ResetPasswordForm::class);
        Livewire::component('newsletter.footer-subscription-form', FooterEmailSubscriptionForm::class);
        Livewire::component('auth.verify-email', VerifyEmail::class);
    }

    /**
     * Register the actions.
     *
     * @return void
     */
    public function registerActions(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        app()->singleton(DeleteUserContract::class, DeleteUser::class);
    }

    public function registerRoutes(): void
    {
        Route::middleware('web')->group(function () {
            Route::view(config('fortify.routes.feedback_thank_you'), 'cauri-fortify::profile.feedback-thank-you')
                ->name('profile.feedback.thank-you')
                ->middleware('signed');

            Route::get(config('fortify.routes.two_factor_reset_password'), [TwoFactorAuthenticatedPasswordResetController::class, 'create'])
                ->name('two-factor.reset-password')
                ->middleware('guest');

            Route::post(config('fortify.routes.two_factor_reset_password'), [TwoFactorAuthenticatedPasswordResetController::class, 'store'])
                ->name('two-factor.reset-password-store')
                ->middleware('guest');
        });

        if (Features::enabled(Features::updateProfileInformation())) {
            Route::group(['middleware' => config('fortify.middlewares.account_settings.update_profile', ['web', 'auth'])], function () {
                Route::view(config('fortify.routes.account_settings_account'), 'cauri-fortify::account.settings-account')
                    ->name('account.settings.account');
            });
        }

        if (Features::enabled(Features::updatePasswords())) {
            Route::group(['middleware' => config('fortify.middlewares.account_settings.update_password', ['web', 'auth'])], function () {
                $slug = (string) config('fortify.routes.account_settings_password');

                Route::view($slug, 'cauri-fortify::account.settings-password')->name('account.settings.password');
                Route::redirect('/.well-known/change-password', $slug);
            });
        }
    }

    /**
     * Register the views.
     *
     * @return void
     */
    private function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cauri-fortify');

        Fortify::loginView(function () {
            return view('cauri-fortify::auth.login');
        });

        Fortify::twoFactorChallengeView(function ($request) {
            $request->session()->put([
                'login.idFailure' => $request->session()->get('login.id'),
            ]);

            return view('cauri-fortify::auth.two-factor-challenge');
        });

        Fortify::registerView(function ($request) {
            return view('cauri-fortify::auth.register');
        });

        Fortify::requestPasswordResetLinkView(function () {
            return view('cauri-fortify::auth.forgot-password');
        });

        Fortify::resetPasswordView(function ($request) {
            $user = Models::user()::where('email', $request->get('email'))->firstOrFail();

            if ($user->two_factor_secret) {
                return redirect()->route('two-factor.reset-password', ['token' => $request->token, 'email' => $user->email]);
            }

            return view('cauri-fortify::auth.reset-password', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return view('cauri-fortify::auth.verify-email');
        });

        Fortify::confirmPasswordView(function () {
            return view('cauri-fortify::auth.confirm-password');
        });
    }

    /**
     * Register the authentication callbacks.
     *
     * @return void
     */
    private function registerAuthentication(): void
    {
        Fortify::authenticateUsing(function (Request $request) {
            return (new AuthenticateUser($request))->handle();
        });
    }

    /**
     * Register the response bindings.
     *
     * @return void
     */
    private function registerResponseBindings()
    {
        $this->app->singleton(
            RegisterResponseContract::class,
            RegisterResponse::class
        );

        $this->app->singleton(
            FailedTwoFactorLoginResponseContract::class,
            FailedTwoFactorLoginResponse::class
        );

        $this->app->singleton(
            TwoFactorLoginResponseContract::class,
            TwoFactorLoginResponse::class
        );

        $this->app->singleton(
            FailedPasswordResetLinkRequestResponse::class,
            FortifyFailedPasswordResetLinkRequestResponse::class
        );

        $this->app->singleton(
            SuccessfulPasswordResetLinkRequestResponse::class,
            FortifySuccessfulPasswordResetLinkRequestResponse::class
        );
    }

    private function registerCommands()
    {
        $this->commands([
            CreateUserCommand::class,
            RunPlaybookCommand::class,
        ]);
    }

    private function registerContracts()
    {
        $this->app->singleton(UserRoleContract::class, UserRole::class);
    }
}
