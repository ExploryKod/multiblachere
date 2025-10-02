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

    // Custom CP conditions
    // host_is: robust compare against normalized hostname (no port, lowercase)
    const __host = window.location.hostname.toLowerCase();
    // minimal debug
    console.log('[CP Conditions] hostname:', __host);
    Statamic.$conditions.add('host_is', ({ value }) => {
        const expected = String(value || '').toLowerCase().trim();
        const match = __host === expected;
        console.log('[host_is]', { expected, actual: __host, match });
        return match;
    });


    // host_in: show when normalized hostname is in provided array
    Statamic.$conditions.add('host_in', ({ value }) => {
        const list = Array.isArray(value) ? value.map(v => String(v).toLowerCase().trim()) : [];
        const match = list.includes(__host);
        console.log('[host_in]', { list, actual: __host, match });
        return match;
    });

    // Auto-fill hidden helper field `site_flag` from current Statamic site handle
    Statamic.$hooks.on('publish:booted', ({ store }) => {
        if (!store?.state?.values || !Object.prototype.hasOwnProperty.call(store.state.values, 'site_flag')) return;
        const siteHandle = (window.Statamic && window.Statamic.config && window.Statamic.config.site && window.Statamic.config.site.handle)
            ? window.Statamic.config.site.handle
            : 'default';
        store.commit('setValue', { handle: 'site_flag', value: siteHandle });
        console.log('[site_flag] set to', siteHandle);
    });

});


