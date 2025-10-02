<?php

namespace Amaury\SiteFieldVisibility;

use Statamic\Providers\AddonServiceProvider;

class NavigationServiceProvider extends AddonServiceProvider
{
    public function boot()
    {
        parent::boot();

        \Statamic\CP\Navigation\Nav::extend(function ($nav) {
            $nav->content('Field Visibility')
                ->route('field-visibility.settings')
                ->icon('toggle')
                ->description('Configure field visibility per site');
        });
    }
}
