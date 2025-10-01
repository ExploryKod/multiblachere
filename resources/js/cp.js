/**
 * When extending the control panel, be sure to uncomment the necessary code for your build process:
 * https://statamic.dev/extending/control-panel
 */

import TogglePasswordFieldtype from './components/fieldtypes/TogglePassword.vue';
import ReadOnlyTextFieldtype from './components/fieldtypes/ReadOnlyText.vue';

Statamic.booting(() => {
    // Should be named [snake_case_handle]-fieldtype
    Statamic.$components.register('toggle_password-fieldtype', TogglePasswordFieldtype);
    Statamic.$components.register('read_only_text-fieldtype', ReadOnlyTextFieldtype);
});