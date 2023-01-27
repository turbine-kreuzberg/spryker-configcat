# Spryker FeatureFlag

[![tests](https://github.com/turbine-kreuzberg/spryker-configcat/actions/workflows/tests.yml/badge.svg)](https://github.com/turbine-kreuzberg/spryker-configcat/actions/workflows/tests.yml)

This package provides an integration for [ConfigCat](https://configcat.com/) in Spryker.

* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
* [Credits](#credits)
* [License](#license)

## Installation

- Install the package via composer
```
composer require turbine-kreuzberg/spryker-configcat
```

## Configuration

For an easy start, copy the following snippet to your `config_local.php`

```php
$config[FeatureFlagConstants::SDK_KEY] = 'CONFIG-CAT-KEY';
$config[FeatureFlagConstants::CACHE_REFRESH_INTERVAL] = REFRESH_INTERVAL;
```

## Usage

You can use it as a Client dependency in your bundles.

Example snippet:
```php
$featureFlagClient = $this->getFactory()->getFeatureFlagClient();

if ($featureFlagClient->isFeatureOn('testFeature')) {
    echo('Feature is on!');
}
```
## Tests
To have feature flag independent of configCat in tests you can set a default value 
in configFile

```php
$config[FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS] = [
    'feature_flag_in_config_file' => true,
    'feature flag 2' => false,
    'feature flag 3' => true,
];
```

## Credits

- [All Contributors](../../../-/graphs/main)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
