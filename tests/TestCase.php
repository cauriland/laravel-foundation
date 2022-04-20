<?php

declare(strict_types=1);

namespace Tests;

use CauriLand\Foundation\Providers\CommonMarkServiceProvider;
use CauriLand\Foundation\Providers\FortifyServiceProvider;
use CauriLand\Foundation\Providers\HermesServiceProvider;
use CauriLand\Foundation\Providers\MarkdownServiceProvider;
use CauriLand\Foundation\Providers\RulesServiceProvider;
use CauriLand\Foundation\Providers\UserInterfaceServiceProvider;
use Illuminate\Support\Facades\View;
use Laravel\Fortify\FortifyServiceProvider as LaravelFortifyServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Newsletter\NewsletterServiceProvider;

/**
 * @coversNothing
 */
class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('markdown', [
            'inlineRenderers' => [],
        ]);

        $app['config']->set('app.url', 'https://ourapp.com');
        $app['config']->set('view.paths', [
            realpath(__DIR__.'/../resources/views'),
            realpath(__DIR__.'/blade-views'),
        ]);

        View::addNamespace('cauri', realpath(__DIR__.'/../resources/views'));
        View::addLocation(realpath(__DIR__.'/blade-views'));
    }

    protected function getPackageProviders($app)
    {
        return [
            // Third-Party
            LaravelFortifyServiceProvider::class,
            MarkdownServiceProvider::class,
            LivewireServiceProvider::class,
            // First-Party
            FortifyServiceProvider::class,
            HermesServiceProvider::class,
            NewsletterServiceProvider::class,
            RulesServiceProvider::class,
            UserInterfaceServiceProvider::class,
            // CommonMarkServiceProvider::class, // TODO: custom finder from this causes component tests to fail
        ];
    }
}
