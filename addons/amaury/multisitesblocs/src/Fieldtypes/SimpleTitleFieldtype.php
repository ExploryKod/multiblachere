<?php

namespace Amaury\Multisitesblocs\Fieldtypes;

use Statamic\Fields\Fieldtype;

class SimpleTitleFieldtype extends Fieldtype
{
    /**
     * The blank/default value.
     *
     * @return string
     */
    public function defaultValue()
    {
        return $this->field()->config('default', '');
    }

    /**
     * Pre-process the data before it gets sent to the publish page.
     *
     * @param mixed $data
     * @return string
     */
    public function preProcess($data)
    {
        return $data ?? '';
    }

    /**
     * Process the data before it gets saved.
     *
     * @param mixed $data
     * @return string
     */
    public function process($data)
    {
        return $data ?? '';
    }

    /**
     * Defines the configuration for the simple title field.
     *
     * @return array Configuration for the simple title field.
     */
    protected function configFieldItems(): array
    {
        return [
            'default' => [
                'display' => 'Default Value',
                'instructions' => 'The default value for this field.',
                'type' => 'text',
                'default' => '',
                'width' => 50
            ],
            'placeholder' => [
                'display' => 'Placeholder',
                'instructions' => 'Placeholder text to show when field is empty.',
                'type' => 'text',
                'default' => 'Enter title...',
                'width' => 50
            ],
            'max_length' => [
                'display' => 'Max Length',
                'instructions' => 'Maximum number of characters allowed.',
                'type' => 'integer',
                'default' => 255,
                'width' => 50
            ],
            'required' => [
                'display' => 'Required',
                'instructions' => 'Make this field required.',
                'type' => 'toggle',
                'default' => false,
                'width' => 50
            ]
        ];
    }

    /**
     * Get the icon for this fieldtype.
     *
     * @return string
     */
    public function icon()
    {
        return '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M3 4h18v2H3V4zm0 5h18v2H3V9zm0 5h18v2H3v-2zm0 5h18v2H3v-2z"/></svg>';
    }

}
