# Site Field Visibility Addon

This Statamic addon automatically hides/shows fields in the control panel based on the active site.

## Features

- Automatically detects the active site from network requests and publish form state
- Hides/shows fields based on site-specific rules
- Works with Statamic's site switcher dropdown
- Adds site-specific CSS classes to the body element
- Comprehensive logging for debugging

## Configuration

The addon is configured directly in the JavaScript file. Currently configured for:

- **groupe_blachere site**: Hides `marie_blachere_builder` field
- **marie_blachere site**: Shows `marie_blachere_builder` field
- **page_builder**: Always visible on both sites

## Installation

1. The addon is already installed in your project
2. Run `npm run build` in the addon directory to build assets
3. The addon will automatically load in the control panel

## Development

```bash
cd addons/amaury/site-field-visibility
npm install
npm run build
```

## Customization

Edit `resources/js/cp.js` to modify the field visibility rules for different sites.
