<?php

namespace Amaury\SiteFieldVisibility;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $scripts = [
        'vendor/site-field-visibility/js/cp.js',
    ];

    public function bootAddon()
    {
        // Register any additional functionality here if needed
    }
}
