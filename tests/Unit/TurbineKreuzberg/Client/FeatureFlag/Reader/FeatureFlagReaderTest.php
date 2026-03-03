<?php

namespace Unit\TurbineKreuzberg\Client\FeatureFlag\Reader;

use Codeception\Test\Unit;
use ConfigCat\ConfigCatClient;
use ConfigCat\User;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Client\Customer\CustomerClientInterface;
use SprykerTest\Shared\Testify\Helper\ConfigHelperTrait;
use TurbineKreuzberg\Client\FeatureFlag\FeatureFlagConfig;
use TurbineKreuzberg\Client\FeatureFlag\Reader\FeatureFlagReader;
use TurbineKreuzberg\Shared\FeatureFlag\FeatureFlagConstants;

class FeatureFlagReaderTest extends Unit
{
    use ConfigHelperTrait;

    public function testReaderGetFeatureFlagValueFromLocalConfigurationFile(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->never())
            ->method('getValue');

        $customerClientMock = $this->createMock(CustomerClientInterface::class);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertTrue($featureFlagReader->getValue('feature_flag_in_config_file'));
    }

    public function testReaderGetFeatureFlagValueFromConfigCatClientWithUser(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->once())
            ->method('getValue')
            ->with('feature_flag_name', false, new User('id'))
            ->willReturn(false);

        $customerClientMock = $this->createMock(CustomerClientInterface::class);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertFalse($featureFlagReader->getValue('feature_flag_name', new User('id')));
    }

    public function testReaderGetFeatureFlagValueFromConfigCatClientWithoutUser(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->once())
            ->method('getValue')
            ->with('feature_flag_name', false)
            ->willReturn(false);

        $customerClientMock = $this->createMock(CustomerClientInterface::class);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertFalse($featureFlagReader->getValue('feature_flag_name'));
    }

    public function testReaderGetsTextSettingValueFromLocalConfigurationFile(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->never())
            ->method('getValue');

        $customerClientMock = $this->createMock(CustomerClientInterface::class);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertSame(
            'text_setting_value',
            $featureFlagReader->getTextSetting('text_setting_in_config_file'),
        );
    }

    public function testReaderGetsTextSettingValueFromConfigCatClient(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->once())
            ->method('getValue')
            ->with('text_setting_name', '')
            ->willReturn('text_setting_from_config_cat_client');

        $customerClientMock = $this->createMock(CustomerClientInterface::class);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertSame(
            'text_setting_from_config_cat_client',
            $featureFlagReader->getTextSetting('text_setting_name'),
        );
    }

    public function testIsFeatureOnForUserInSessionForGuestCustomerFromLocalConfigurationFile(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->never())
            ->method('getValue');

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);

        $customerClientMock->expects($this->never())
            ->method('getCustomer');

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertTrue(
            $featureFlagReader->isFeatureOnForUserInSession('feature_flag_in_config_file'),
        );
    }

    public function testIsFeatureOnForUserInSessionForGuestCustomerFromConfigCatClient(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->once())
            ->method('getValue')
            ->with('text_setting_from_config_cat_client', false, null)
            ->willReturn(true);

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(false);

        $customerClientMock->expects($this->never())
            ->method('getCustomer');

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertTrue(
            $featureFlagReader->isFeatureOnForUserInSession('text_setting_from_config_cat_client'),
        );
    }

    public function testIsFeatureOnForUserInSessionForActualCustomerFromLocalConfigurationFile(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->never())
            ->method('getValue');

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);

        $customerClientMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn(
                (new CustomerTransfer())->setEmail('customer@email.com'),
            );

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertTrue(
            $featureFlagReader->isFeatureOnForUserInSession('feature_flag_in_config_file'),
        );
    }

    public function testIsFeatureOnForUserInSessionForActualCustomerFromConfigCatClient(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->once())
            ->method('getValue')
            ->with(
                'feature_flag_name',
                false,
                new User('customer@email.com'),
            )
            ->willReturn(false);

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);

        $customerClientMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn(
                (new CustomerTransfer())->setEmail('customer@email.com'),
            );

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertFalse(
            $featureFlagReader->isFeatureOnForUserInSession('feature_flag_name'),
        );
    }

    public function testIsFeatureOnForUserInSessionForActualCustomerWillReturnFalseForEmptySessionCustomer(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->never())
            ->method('getValue');

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);

        $customerClientMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn(null);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertFalse(
            $featureFlagReader->isFeatureOnForUserInSession('feature_flag_name'),
        );
    }

    public function testIsFeatureOnForUserInSessionForActualCustomerWillReturnFalseForNullEmailInSessionCustomer(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->never())
            ->method('getValue');

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('isLoggedIn')
            ->willReturn(true);

        $customerClientMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn(
                (new CustomerTransfer())->setEmail(null),
            );

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertFalse(
            $featureFlagReader->isFeatureOnForUserInSession('feature_flag_name'),
        );
    }

    public function testGetAllValuesWillCallConfigCatClientWithNullForNonLoggedInUser(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->once())
            ->method('getAllValues')
            ->with(null)
            ->willReturn(['featureFlagKey' => 'featureFlagValue']);

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn(null);

        $this->setConfig(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertSame(
            ['featureFlagKey' => 'featureFlagValue'],
            $featureFlagReader->getAllFeatureFlags(),
        );
    }

    public function testGetAllValuesWillCallConfigCatClientWithNullForLoggedInUserWithoutEmail(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->once())
            ->method('getAllValues')
            ->with(null)
            ->willReturn(['featureFlagKey' => 'featureFlagValue']);

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn(
                (new CustomerTransfer())->setEmail(null),
            );

        $this->setConfig(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertSame(
            ['featureFlagKey' => 'featureFlagValue'],
            $featureFlagReader->getAllFeatureFlags(),
        );
    }

    public function testGetAllValuesWillCallConfigCatClientWithConfigCatUserObjectForLoggedInUser(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->once())
            ->method('getAllValues')
            ->with(
                new User('some@email.com'),
            )
            ->willReturn(['featureFlagKey' => 'featureFlagValue']);

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->once())
            ->method('getCustomer')
            ->willReturn(
                (new CustomerTransfer())->setEmail('some@email.com'),
            );

        $this->setConfig(FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS, []);

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertSame(
            ['featureFlagKey' => 'featureFlagValue'],
            $featureFlagReader->getAllFeatureFlags(),
        );
    }

    public function testGetAllValuesWillReturnFeatureFlagsFromLocalConfigurationFile(): void
    {
        $configCatClientMock = $this->createMock(ConfigCatClient::class);
        $configCatClientMock->expects($this->never())
            ->method('getAllValues');

        $customerClientMock = $this->createMock(CustomerClientInterface::class);
        $customerClientMock->expects($this->never())
            ->method('getCustomer');

        $this->setConfig(
            FeatureFlagConstants::CONFIG_CAT_FEATURE_FLAGS,
            [
                'featureFlagFromConfigurationKey' => 'featureFlagFromConfigurationValue',
                'featureFlagFromConfigurationKeyBool' => false,
            ],
        );

        $featureFlagReader = new FeatureFlagReader(
            $configCatClientMock,
            $customerClientMock,
            new FeatureFlagConfig(),
        );

        $this->assertSame(
            [
                'featureFlagFromConfigurationKey' => 'featureFlagFromConfigurationValue',
                'featureFlagFromConfigurationKeyBool' => false,
            ],
            $featureFlagReader->getAllFeatureFlags(),
        );
    }
}
