<?php

declare(strict_types=1);

namespace CauriLand\Foundation\Providers;

use CauriLand\Foundation\UserInterface\Components\Currency;
use CauriLand\Foundation\UserInterface\Components\DataBag;
use CauriLand\Foundation\UserInterface\Components\FlashMessage;
use CauriLand\Foundation\UserInterface\Components\FrontendSettings;
use CauriLand\Foundation\UserInterface\Components\Number;
use CauriLand\Foundation\UserInterface\Components\Percentage;
use CauriLand\Foundation\UserInterface\Components\ShortCurrency;
use CauriLand\Foundation\UserInterface\Components\ShortPercentage;
use CauriLand\Foundation\UserInterface\Components\Toast;
use CauriLand\Foundation\UserInterface\Components\TruncateMiddle;
use CauriLand\Foundation\UserInterface\Http\Controllers\ImageCropController;
use CauriLand\Foundation\UserInterface\Http\Controllers\WysiwygControlller;
use CauriLand\Foundation\UserInterface\UI;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Livewire\Livewire;
use Spatie\Flash\Flash;

class UserInterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Flash::levels([
            'info'    => 'info',
            'success' => 'success',
            'warning' => 'warning',
            'error'   => 'error',
            'hint'    => 'hint',
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLoaders();

        $this->registerPublishers();

        $this->registerBladeComponents();

        $this->registerLivewireComponents();

        $this->registerRoutes();

        UI::bootErrorMessages();
    }

    /**
     * Register the loaders.
     *
     * @return void
     */
    public function registerLoaders(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'ui');
    }

    /**
     * Register routes.
     *
     * @return void
     */
    public function registerRoutes(): void
    {
        Route::group(['prefix' => 'wysiwyg'], function () {
            Route::get('twitter-embed-code', [WysiwygControlller::class, 'getTwitterEmbedCode'])->name('wysiwyg.twitter');
            Route::post('upload-image', [WysiwygControlller::class, 'uploadImage'])->name('wysiwyg.upload-image')->middleware(['web', 'auth']);
            Route::post('count-characters', [WysiwygControlller::class, 'countCharacters'])->name('wysiwyg.count-characters')->middleware(['web', 'auth', 'throttle']);
        });

        Route::post('cropper/upload-image', ImageCropController::class)->name('cropper.upload-image')->middleware(['web', 'auth']);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerPublishers(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'cauri');

        $this->publishes([
            __DIR__.'/../../config/ui.php' => config_path('ui.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../config/share.php' => config_path('share.php'),
        ], 'share');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/ui.php',
            'ui'
        );

        $this->mergeConfigFrom(
            __DIR__.'/../../config/share.php',
            'share'
        );

        $this->publishes([
            __DIR__.'/../../config/livewire.php' => config_path('livewire.php'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/cauri'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../resources/views/pagination.blade.php'     => resource_path('views/vendor/cauri/pagination.blade.php'),
            __DIR__.'/../../resources/views/pagination-url.blade.php' => resource_path('views/vendor/cauri/pagination-url.blade.php'),
        ], 'pagination');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/markdown-editor' => resource_path('js/vendor/cauri/markdown-editor'),
        ], 'wysiwyg');

        $this->publishes([
            __DIR__.'/../../resources/assets/fonts' => resource_path('fonts'),
        ], 'fonts');

        $this->publishes([
            __DIR__.'/../../resources/assets/css' => resource_path('css/vendor/cauri'),
        ], 'css');

        $this->publishes([
            __DIR__.'/../../resources/assets/icons' => resource_path('icons'),
        ], 'icons');

        $this->publishes([
            __DIR__.'/../../resources/assets/images/components' => resource_path('images/vendor/cauri'),
        ], 'images');

        $this->publishes([
            __DIR__.'/../../resources/views/errors'         => resource_path('views/errors'),
            __DIR__.'/../../resources/assets/images/errors' => resource_path('images/errors'),
        ], 'error-pages');

        // Individual JS files

        $this->publishes([
            __DIR__.'/../../resources/assets/js/modal.js' => resource_path('js/vendor/cauri/modal.js'),
        ], 'modal');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/page-scroll.js' => resource_path('js/vendor/cauri/page-scroll.js'),
        ], 'page-scroll');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/rich-select.js' => resource_path('js/vendor/cauri/rich-select.js'),
        ], 'tippy');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/prism-line-numbers.js' => resource_path('js/vendor/cauri/prism-line-numbers.js'),
            __DIR__.'/../../resources/assets/js/prism.js'              => resource_path('js/vendor/cauri/prism.js'),
        ], 'prism');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/clipboard.js' => resource_path('js/vendor/cauri/clipboard.js'),
        ], 'clipboard');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/reposition-dropdown.js' => resource_path('js/vendor/cauri/reposition-dropdown.js'),
        ], 'dropdown');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/highlightjs-copy.js' => resource_path('js/vendor/cauri/highlightjs-copy.js'),
        ], 'highlightjs');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/file-download.js' => resource_path('js/vendor/cauri/file-download.js'),
        ], 'file-download');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $blade->component('cauri::inputs.checkbox', 'cauri-checkbox');
            $blade->component('cauri::inputs.date-picker', 'cauri-date-picker');
            $blade->component('cauri::inputs.input', 'cauri-input');
            $blade->component('cauri::inputs.input-with-icon', 'cauri-input-with-icon');
            $blade->component('cauri::inputs.input-with-prefix', 'cauri-input-with-prefix');
            $blade->component('cauri::inputs.input-with-suffix', 'cauri-input-with-suffix');
            $blade->component('cauri::inputs.radio', 'cauri-radio');
            $blade->component('cauri::inputs.textarea', 'cauri-textarea');
            $blade->component('cauri::inputs.toggle', 'cauri-toggle');
            $blade->component('cauri::inputs.select', 'cauri-select');
            $blade->component('cauri::inputs.upload', 'cauri-upload');
            $blade->component('cauri::inputs.password-toggle', 'cauri-password-toggle');
            $blade->component('cauri::inputs.rich-select', 'cauri-rich-select');
            $blade->component('cauri::inputs.markdown', 'cauri-markdown');
            $blade->component('cauri::inputs.user-tagger', 'cauri-user-tagger');
            $blade->component('cauri::inputs.switch', 'cauri-switch');
            $blade->component('cauri::inputs.tile-selection', 'cauri-tile-selection');
            $blade->component('cauri::inputs.time', 'cauri-time');
            $blade->component('cauri::inputs.upload-image-single', 'cauri-upload-image-single');
            $blade->component('cauri::inputs.upload-image-collection', 'cauri-upload-image-collection');
            $blade->component('cauri::inputs.tags', 'cauri-tags');

            $blade->component('cauri::pages.contact', 'cauri-pages-contact');

            $blade->component('cauri::pages.includes.cookie-banner', 'cauri-pages-includes-cookie-banner');
            $blade->component('cauri::pages.includes.header', 'cauri-pages-includes-header');
            $blade->component('cauri::pages.includes.layout-body', 'cauri-pages-includes-layout-body');
            $blade->component('cauri::pages.includes.layout-content', 'cauri-pages-includes-layout-content');
            $blade->component('cauri::pages.includes.layout-head', 'cauri-pages-includes-layout-head');
            $blade->component('cauri::pages.includes.markdown-scripts', 'cauri-pages-includes-markdown-scripts');
            $blade->component('cauri::pages.includes.crop-image-scripts', 'cauri-pages-includes-crop-image-scripts');
            $blade->component('cauri::pages.includes.compress-image-scripts', 'cauri-pages-includes-compress-image-scripts');

            $blade->component('cauri::tables.table', 'cauri-tables.table');
            $blade->component('cauri::tables.row', 'cauri-tables.row');
            $blade->component('cauri::tables.cell', 'cauri-tables.cell');
            $blade->component('cauri::tables.header', 'cauri-tables.header');
            $blade->component('cauri::tables.view-options', 'cauri-tables.view-options');
            $blade->component('cauri::tables.mobile.cell', 'cauri-tables.mobile.cell');
            $blade->component('cauri::tables.mobile.row', 'cauri-tables.mobile.row');

            $blade->component('cauri::accordion-group', 'cauri-accordion-group');
            $blade->component('cauri::accordion', 'cauri-accordion');
            $blade->component('cauri::alert', 'cauri-alert');
            $blade->component('cauri::alert-simple', 'cauri-alert-simple');
            $blade->component('cauri::avatar', 'cauri-avatar');
            $blade->component('cauri::breadcrumbs', 'cauri-breadcrumbs');
            $blade->component('cauri::clipboard', 'cauri-clipboard');
            $blade->component('cauri::chevron-toggle', 'cauri-chevron-toggle');
            $blade->component('cauri::code', 'cauri-code');
            $blade->component('cauri::code-lines', 'cauri-code-lines');
            $blade->component('cauri::container', 'cauri-container');
            $blade->component('cauri::description-block', 'cauri-description-block');
            $blade->component('cauri::description-block-link', 'cauri-description-block-link');
            $blade->component('cauri::details-box', 'cauri-details-box');
            $blade->component('cauri::details-box-mobile', 'cauri-details-box-mobile');
            $blade->component('cauri::divider', 'cauri-divider');
            $blade->component('cauri::documentation', 'cauri-documentation');
            $blade->component('cauri::dropdown', 'cauri-dropdown');
            $blade->component('cauri::expandable', 'cauri-expandable');
            $blade->component('cauri::expandable-item', 'cauri-expandable-item');
            $blade->component('cauri::external-link', 'cauri-external-link');
            $blade->component('cauri::external-link-confirm', 'cauri-external-link-confirm');
            $blade->component('cauri::flash', 'cauri-flash');
            $blade->component('cauri::footer-bar-desktop', 'cauri-footer-bar-desktop');
            $blade->component('cauri::footer-bar-mobile', 'cauri-footer-bar-mobile');
            $blade->component('cauri::footer-copyright', 'cauri-footer-copyright');
            $blade->component('cauri::footer-social', 'cauri-footer-social');
            $blade->component('cauri::footer', 'cauri-footer');
            $blade->component('cauri::horizontal-divider', 'cauri-horizontal-divider');
            $blade->component('cauri::icon', 'cauri-icon');
            $blade->component('cauri::icon-link', 'cauri-icon-link');
            $blade->component('cauri::image-tile', 'cauri-image-tile');
            $blade->component('cauri::info', 'cauri-info');
            $blade->component('cauri::js-modal', 'cauri-js-modal');
            $blade->component('cauri::local-time', 'cauri-local-time');
            $blade->component('cauri::logo', 'cauri-logo');
            $blade->component('cauri::logo-simple', 'cauri-logo-simple');
            $blade->component('cauri::loading-spinner', 'cauri-loading-spinner');
            $blade->component('cauri::spinner-icon', 'cauri-spinner-icon');
            $blade->component('cauri::loader-icon', 'cauri-loader-icon');
            $blade->component('cauri::message', 'cauri-message');
            $blade->component('cauri::metadata', 'cauri-metadata');
            $blade->component('cauri::metadata-tags', 'cauri-metadata-tags');
            $blade->component('cauri::modal', 'cauri-modal');
            $blade->component('cauri::no-results', 'cauri-no-results');
            $blade->component('cauri::notification-dot', 'cauri-notification-dot');
            $blade->component('cauri::outgoing-link', 'cauri-outgoing-link');
            $blade->component('cauri::pagination', 'cauri-pagination');
            $blade->component('cauri::pagination-url', 'cauri-pagination-url');
            $blade->component('cauri::read-more', 'cauri-read-more');
            $blade->component('cauri::secondary-menu', 'cauri-secondary-menu');
            $blade->component('cauri::sidebar-link', 'cauri-sidebar-link');
            $blade->component('cauri::simple-footer', 'cauri-simple-footer');
            $blade->component('cauri::slider-slide', 'cauri-slider-slide');
            $blade->component('cauri::slider', 'cauri-slider');
            $blade->component('cauri::social-link', 'cauri-social-link');
            $blade->component('cauri::social-square', 'cauri-social-square');
            $blade->component('cauri::sort-icon', 'cauri-sort-icon');
            $blade->component('cauri::status-circle', 'cauri-status-circle');
            $blade->component('cauri::svg-lazy', 'cauri-svg-lazy');
            $blade->component('cauri::toast', 'cauri-toast');
            $blade->component('cauri::shapes.line', 'cauri-placeholder-line');
            $blade->component('cauri::shapes.square', 'cauri-placeholder-square');
            $blade->component('cauri::link-collection', 'cauri-link-collection');
            $blade->component('cauri::file-download', 'cauri-file-download');
            $blade->component('cauri::chart', 'cauri-chart');
            $blade->component('cauri::tabs.wrapper', 'cauri-tabbed');
            $blade->component('cauri::tabs.tab', 'cauri-tab');
            $blade->component('cauri::tabs.panel', 'cauri-tab-panel');

            // Navigation
            $blade->component('cauri::navbar', 'cauri-navbar');
            $blade->component('cauri::navbar.link-mobile', 'cauri-navbar-link-mobile');
            $blade->component('cauri::navbar.hamburger', 'cauri-navbar-hamburger');

            // Font Loader
            $blade->component('cauri::font-loader', 'cauri-font-loader');

            // Scripts
            $blade->component('cauri::scripts.dark-theme-script', 'cauri-dark-theme-script');

            // Formatting
            $blade->component('currency', Currency::class);
            $blade->component('number', Number::class);
            $blade->component('percentage', Percentage::class);
            $blade->component('short-currency', ShortCurrency::class);
            $blade->component('short-percentage', ShortPercentage::class);
            $blade->component('truncate-middle', TruncateMiddle::class);

            // Data Bags
            $blade->component('data-bag', DataBag::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerLivewireComponents(): void
    {
        Livewire::component('flash-message', FlashMessage::class);
        Livewire::component('toast', Toast::class);
        Livewire::component('frontend-settings', FrontendSettings::class);
    }
}
