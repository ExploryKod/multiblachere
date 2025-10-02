Statamic.booting(() => {
    const BODY_SITE_CLASS_PREFIX = 'site--';

    const setBodySiteClass = (site) => {
        try {
            const classes = Array.from(document.body.classList || []);
            classes.forEach(c => { if (c.startsWith(BODY_SITE_CLASS_PREFIX)) document.body.classList.remove(c); });
        } catch (e) {}
        if (site) document.body.classList.add(`${BODY_SITE_CLASS_PREFIX}${site}`);
    };

    const hideByHandle = (handle) => {
        // Try multiple selectors to find the field
        const selectors = [
            `.publish-field__${handle}`,
            `[data-field="${handle}"]`,
            `[name="${handle}"]`,
            `.fieldtype-replicator[data-field="${handle}"]`,
            `.replicator-field[data-field="${handle}"]`
        ];
        
        let totalHidden = 0;
        selectors.forEach(selector => {
            const nodes = document.querySelectorAll(selector);
            nodes.forEach(n => { 
                if (n && n.style) {
                    n.style.display = 'none';
                    totalHidden++;
                }
            });
        });
        
        // eslint-disable-next-line no-console
        console.log('[HideField]', handle, 'total hidden:', totalHidden);
        return totalHidden;
    };

    const showByHandle = (handle) => {
        // Try multiple selectors to find the field
        const selectors = [
            `.publish-field__${handle}`,
            `[data-field="${handle}"]`,
            `[name="${handle}"]`,
            `.fieldtype-replicator[data-field="${handle}"]`,
            `.replicator-field[data-field="${handle}"]`
        ];
        
        // eslint-disable-next-line no-console
        console.log('[ShowField] Looking for field:', handle);
        
        let totalShown = 0;
        selectors.forEach(selector => {
            const nodes = document.querySelectorAll(selector);
            // eslint-disable-next-line no-console
            console.log('[ShowField] Selector:', selector, 'found', nodes.length, 'nodes');
            nodes.forEach(n => { 
                if (n) {
                    // eslint-disable-next-line no-console
                    console.log('[ShowField] Before - display:', n.style.display, 'visibility:', n.style.visibility, 'classList:', n.classList.toString());
                    
                    // Force show with !important to override any CSS
                    n.style.setProperty('display', 'block', 'important');
                    n.style.setProperty('visibility', 'visible', 'important');
                    n.style.setProperty('opacity', '1', 'important');
                    n.style.setProperty('height', 'auto', 'important');
                    n.style.setProperty('max-height', 'none', 'important');
                    
                    // Remove any hidden classes
                    n.classList.remove('hidden', 'invisible', 'opacity-0', 'h-0', 'max-h-0');
                    
                    // Also check parent elements and make sure they're not hidden
                    let parent = n.parentElement;
                    let level = 0;
                    while (parent && level < 5) {
                        if (parent.style.display === 'none') {
                            parent.style.setProperty('display', 'block', 'important');
                            // eslint-disable-next-line no-console
                            console.log('[ShowField] Fixed parent display:', parent);
                        }
                        parent = parent.parentElement;
                        level++;
                    }
                    
                    // eslint-disable-next-line no-console
                    console.log('[ShowField] After - display:', n.style.display, 'visibility:', n.style.visibility, 'classList:', n.classList.toString());
                    totalShown++;
                }
            });
        });
        
        // eslint-disable-next-line no-console
        console.log('[ShowField]', handle, 'total shown:', totalShown);
        return totalShown;
    };

    const detectActiveSite = (store) => {
        // eslint-disable-next-line no-console
        console.log('[detectActiveSite] store.state:', store?.state);
        // eslint-disable-next-line no-console
        console.log('[detectActiveSite] store.getters:', store?.getters);

        if (store?.state?.site) {
            console.log('[detectActiveSite] via state.site ->', store.state.site);
            return store.state.site;
        }
        if (store?.getters?.site) {
            console.log('[detectActiveSite] via getters.site ->', store.getters.site);
            return store.getters.site;
        }
        if (store?.state?.values?.site) {
            console.log('[detectActiveSite] via values.site ->', store.state.values.site);
            return store.state.values.site;
        }
        const cfg = (window.Statamic && window.Statamic.config && window.Statamic.config.site && window.Statamic.config.site.handle)
            ? window.Statamic.config.site.handle
            : 'default';
        console.log('[detectActiveSite] fallback config ->', cfg);
        return cfg;
    };

    const applyPerSiteHiding = (activeSite, retryCount = 0) => {
        setBodySiteClass(activeSite);
        let hiddenCount = 0;
        
        if (activeSite === 'groupe_blachere') {
            console.log('[PerSite] groupe_blachere -> hide marie_blachere_builder, keep page_builder visible');
            hiddenCount += hideByHandle('marie_blachere_builder');
        }
        if (activeSite === 'marie_blachere') {
            console.log('[PerSite] marie_blachere -> show marie_blachere_builder, keep page_builder visible');
            showByHandle('marie_blachere_builder');
        }
        
        // If no fields were hidden and we're in a publish form, retry after a delay
        if (hiddenCount === 0 && retryCount < 3 && document.querySelector('.publish-form')) {
            console.log('[PerSite] No fields hidden, retrying in 500ms (attempt', retryCount + 1, ')');
            setTimeout(() => applyPerSiteHiding(activeSite, retryCount + 1), 500);
        }
    };

    const onPublishBooted = ({ store }) => {
        let activeSite = detectActiveSite(store);
        // Fallback to globally observed site from network activity
        if (!activeSite || activeSite === 'default') {
            if (window.__ACTIVE_SITE && typeof window.__ACTIVE_SITE === 'string') {
                console.log('[publish:booted] using observed __ACTIVE_SITE =', window.__ACTIVE_SITE);
                activeSite = window.__ACTIVE_SITE;
            }
        }
        // Last attempt: try hidden input in the publish form
        if (!activeSite || activeSite === 'default') {
            const formSiteEl = document.querySelector('.publish-form [name="site"], form[action*="/cp/"] [name="site"]');
            if (formSiteEl && formSiteEl.value) {
                activeSite = formSiteEl.value;
                console.log('[publish:booted] found hidden form site =', activeSite);
            }
        }
        console.log('[publish:booted] activeSite =', activeSite);
        applyPerSiteHiding(activeSite);
    };

    // Hook when publish form boots (initial and after switching site)
    Statamic.$hooks.on('publish:booted', onPublishBooted);

    // Observe site from network requests (?site=...)
    const updateObservedSite = (site) => {
        if (!site) return;
        if (window.__ACTIVE_SITE === site) return;
        window.__ACTIVE_SITE = site;
        console.log('[ObservedSite] set to', site);
        // Delay hiding to ensure DOM is ready
        setTimeout(() => applyPerSiteHiding(site), 100);
    };

    try {
        const originalFetch = window.fetch;
        window.fetch = function(input, init) {
            try {
                const url = typeof input === 'string' ? input : input?.url;
                const parsed = new URL(url, window.location.origin);
                const site = parsed.searchParams.get('site');
                if (site) updateObservedSite(site);
            } catch (e) {}
            return originalFetch.apply(this, arguments);
        };
    } catch (e) { console.log('[HookFetch] error', e); }

    try {
        const originalOpen = XMLHttpRequest.prototype.open;
        XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
            try {
                const parsed = new URL(url, window.location.origin);
                const site = parsed.searchParams.get('site');
                if (site) updateObservedSite(site);
            } catch (e) {}
            return originalOpen.apply(this, arguments);
        };
    } catch (e) { console.log('[HookXHR] error', e); }

    // Initial pass: config or observed
    const initialSite = window.__ACTIVE_SITE || (window.Statamic?.config?.site?.handle) || 'default';
    console.log('[initial] site =', initialSite);
    applyPerSiteHiding(initialSite);
});


