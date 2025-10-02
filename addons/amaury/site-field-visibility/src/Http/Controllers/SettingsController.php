<?php

namespace Amaury\SiteFieldVisibility\Http\Controllers;

use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;
use Amaury\SiteFieldVisibility\FieldVisibilitySettings;

class SettingsController extends CpController
{
    public function index()
    {
        $blueprint = FieldVisibilitySettings::getBlueprint();
        $values = FieldVisibilitySettings::getSettings();
        
        return view('site-field-visibility::settings', [
            'blueprint' => $blueprint,
            'values' => $values,
            'title' => 'Field Visibility Settings'
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'sites' => 'array',
            'sites.*.site_handle' => 'required|string',
            'sites.*.hidden_fields' => 'array',
            'sites.*.visible_fields' => 'array',
        ]);

        $sites = collect($request->input('sites', []))
            ->filter(function ($site) {
                return !empty($site['site_handle']);
            })
            ->mapWithKeys(function ($site) {
                return [
                    $site['site_handle'] => [
                        'hidden_fields' => $site['hidden_fields'] ?? [],
                        'visible_fields' => $site['visible_fields'] ?? [],
                    ]
                ];
            })
            ->toArray();

        FieldVisibilitySettings::saveSettings($sites);

        return redirect()->route('field-visibility.settings')
            ->with('success', 'Settings saved successfully!');
    }

    public function config($siteHandle)
    {
        $settings = FieldVisibilitySettings::getSettings();
        $config = $settings->get($siteHandle, [
            'hidden_fields' => [],
            'visible_fields' => []
        ]);

        return response()->json($config);
    }
}
