<?php

namespace Amaury\SiteFieldVisibility;

use Statamic\Fields\Blueprint;
use Statamic\Fields\Field;

class FieldVisibilitySettings
{
    public static function register()
    {
        // Navigation will be registered in the service provider
    }

    public static function getSettings()
    {
        return collect(config('site-field-visibility.sites', []));
    }

    public static function saveSettings($settings)
    {
        $configPath = config_path('site-field-visibility.php');
        
        if (!file_exists($configPath)) {
            $config = [
                'sites' => []
            ];
        } else {
            $config = include $configPath;
        }

        $config['sites'] = $settings;

        file_put_contents($configPath, '<?php return ' . var_export($config, true) . ';');
    }

    public static function getBlueprint()
    {
        return Blueprint::make()
            ->setContents([
                'tabs' => [
                    [
                        'display' => 'Site Field Visibility',
                        'handle' => 'main',
                        'fields' => [
                            [
                                'handle' => 'sites',
                                'field' => [
                                    'type' => 'replicator',
                                    'display' => 'Site Configurations',
                                    'instructions' => 'Configure which fields to hide/show for each site',
                                    'sets' => [
                                        'site_config' => [
                                            'display' => 'Site Configuration',
                                            'fields' => [
                                                [
                                                    'handle' => 'site_handle',
                                                    'field' => [
                                                        'type' => 'text',
                                                        'display' => 'Site Handle',
                                                        'instructions' => 'The site handle (e.g., groupe_blachere, marie_blachere)',
                                                        'validate' => 'required',
                                                        'placeholder' => 'groupe_blachere'
                                                    ]
                                                ],
                                                [
                                                    'handle' => 'hidden_fields',
                                                    'field' => [
                                                        'type' => 'list',
                                                        'display' => 'Fields to Hide',
                                                        'instructions' => 'Enter field handles to hide on this site (one per line)',
                                                        'placeholder' => 'marie_blachere_builder'
                                                    ]
                                                ],
                                                [
                                                    'handle' => 'visible_fields',
                                                    'field' => [
                                                        'type' => 'list',
                                                        'display' => 'Fields to Show',
                                                        'instructions' => 'Enter field handles to explicitly show on this site (one per line)',
                                                        'placeholder' => 'page_builder'
                                                    ]
                                                ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ]);
    }
}
