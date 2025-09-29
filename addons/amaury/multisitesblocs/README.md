# Multisitesblocs

A Statamic addon that provides custom fieldtypes for multisite content management.

## Features

- **Simple Title Fieldtype**: A clean, configurable title input field using Statamic's built-in text component

## Installation

This addon is already installed as a local development dependency.

## Usage

### Simple Title Fieldtype

The Simple Title fieldtype provides a clean text input using Statamic's built-in text field component with additional configuration options:

- **Placeholder text**: Customizable placeholder
- **Max length validation**: Enforce character limits
- **Required field support**: Optional required validation
- **Default values**: Set default text

#### Configuration Options

```yaml
handle: title
field:
  type: simple_title
  display: 'Title'
  required: true
  default: 'My Default Title'
  placeholder: 'Enter your title here...'
  max_length: 100
```

#### Available Configuration Fields

- `default`: Default value for the field
- `placeholder`: Placeholder text shown when field is empty
- `max_length`: Maximum number of characters allowed
- `required`: Whether the field is required

## Development

No build process required! This addon uses Statamic's built-in text component, making it simple and lightweight.

### File Structure

```
addons/amaury/multisitesblocs/
├── src/
│   ├── Fieldtypes/
│   │   └── SimpleTitleFieldtype.php    # PHP fieldtype class
│   └── ServiceProvider.php             # Service provider
├── composer.json
└── README.md
```

## Support

This addon is part of the multisiteblocs project for managing content across multiple Statamic sites.