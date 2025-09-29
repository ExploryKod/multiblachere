<?php

namespace Amaury\Multisitesblocs\Tests;

use Amaury\Multisitesblocs\ServiceProvider;
use Statamic\Testing\AddonTestCase;

abstract class TestCase extends AddonTestCase
{
    protected string $addonServiceProvider = ServiceProvider::class;
}
