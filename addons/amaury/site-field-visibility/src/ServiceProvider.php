<?php

namespace Amaury\SiteFieldVisibility;

use Statamic\Providers\AddonServiceProvider;
use Amaury\SiteFieldVisibility\FieldVisibilitySettings;
use Amaury\SiteFieldVisibility\Http\Controllers\SettingsController;

class ServiceProvider extends AddonServiceProvider
{
    protected $scripts = [
        'public/vendor/site-field-visibility/js/cp.js',
    ];

    protected $routes = [
        'cp' => __DIR__.'/../routes/web.php',
    ];

    protected $publishables = [
        'config' => 'site-field-visibility',
    ];

    public function boot()
    {
        parent::boot();

        // Register settings
        FieldVisibilitySettings::register();

        // Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'site-field-visibility');

        // Publish config
        $this->publishes([
            __DIR__.'/../config/site-field-visibility.php' => config_path('site-field-visibility.php'),
        ], 'site-field-visibility-config');
    }

    public function bootAddon()
    {
        // Register navigation in Control Panel sidebar
        \Statamic\Facades\CP\Nav::extend(function ($nav) {
            $nav->content('Field Visibility')
                ->route('field-visibility.settings')
                ->icon('toggle');
        });
    }
}
