# Spryker FeatureFlag

This package provides an integration for [ConfigCat](https://configcat.com/) in Spryker.

* [Installation](#installation)
* [Configuration](#configuration)
* [Usage](#usage)
* [Credits](#credits)
* [License](#license)

## Installation

- If this is the first package you are installing from the Turbine Kreuzberg Gitlab package registry,
  you have to add the package registry to your `composer.json`
  (the key `txb` you can change to something else if you want/need to)
```
composer config repositories.txb composer https://git.votum-media.net/api/v4/group/788/-/packages/composer/

composer config gitlab-domains git.votum-media.net
```
- Install the package via composer
```
composer require turbine-kreuzberg/spryker-config-cat
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
## Credits

- [All Contributors](../../../-/graphs/main)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
