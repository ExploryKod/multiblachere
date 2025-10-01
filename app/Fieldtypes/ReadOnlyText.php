<?php

namespace App\Fieldtypes;

use Statamic\Fields\Fieldtype;

class ReadOnlyText extends Fieldtype
{
    protected $icon = 'document-text';
    protected $categories = ['text'];

    /**
     * The blank/default value.
     *
     * @return string
     */
    public function defaultValue()
    {
        return '';
    }

    /**
     * Pre-process the data before it gets sent to the publish page.
     *
     * @param mixed $data
     * @return string
     */
    public function preProcess($data)
    {
        return $data ?: $this->config('default_text', '');
    }

    /**
     * Process the data before it gets saved.
     * For read-only fields, we return the configured default text.
     *
     * @param mixed $data
     * @return string
     */
    public function process($data)
    {
        return $this->config('default_text', '');
    }

    /**
     * Configuration fields for the fieldtype.
     *
     * @return array
     */
    public function configFieldItems(): array
    {
        return [
            'default_text' => [
                'display' => 'Text to Display',
                'instructions' => 'The text that will be displayed in this field. This cannot be changed by content authors.',
                'type' => 'textarea',
                'default' => '',
                'width' => 100,
            ],
            'text_style' => [
                'display' => 'Text Style',
                'instructions' => 'How the text should be displayed.',
                'type' => 'select',
                'options' => [
                    'normal' => 'Normal',
                    'italic' => 'Italic',
                    'bold' => 'Bold',
                    'muted' => 'Muted (gray)',
                    'success' => 'Success (green)',
                    'warning' => 'Warning (yellow)',
                    'error' => 'Error (red)',
                ],
                'default' => 'normal',
                'width' => 50,
            ],
            'show_border' => [
                'display' => 'Show Border',
                'instructions' => 'Add a subtle border around the text.',
                'type' => 'toggle',
                'default' => false,
                'width' => 50,
            ],
        ];
    }

    /**
     * This fieldtype should not be searchable.
     *
     * @return bool
     */
    public function isSearchable()
    {
        return false;
    }

    /**
     * This fieldtype should not be sortable.
     *
     * @return bool
     */
    public function isSortable()
    {
        return false;
    }
}