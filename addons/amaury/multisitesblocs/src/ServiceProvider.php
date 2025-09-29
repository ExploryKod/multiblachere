<?php

namespace Amaury\Multisitesblocs;

use Amaury\Multisitesblocs\Fieldtypes\SimpleTitleFieldtype;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function bootAddon()
    {
        SimpleTitleFieldtype::register();
    }
}
