<?php

namespace TurbineKreuzberg\Client\FeatureFlag;

use ConfigCat\User;

interface FeatureFlagClientInterface
{
    public function isFeatureOn(string $featureName): bool;

    public function isFeatureOnForUser(string $featureName, User $user): bool;

    public function getTextSetting(string $featureName): string;

    /**
     * @return array<string, bool|string>
     */
    public function getAllValues(?User $user = null): array;
}
