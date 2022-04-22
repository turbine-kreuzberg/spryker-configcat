<?php


use Spryker\Shared\Kernel\KernelConstants;
use TurbineKreuzberg\Shared\FeatureFlag\FeatureFlagConstants;

$config[KernelConstants::PROJECT_NAMESPACES] = [
    'TurbineKreuzberg',
];
$config[KernelConstants::PROJECT_NAMESPACE] = 'TurbineKreuzberg';

$config[KernelConstants::CORE_NAMESPACES] = [
    'Spryker',
];
$config[FeatureFlagConstants::SDK_KEY] = 'config_cat_sdk_key';
