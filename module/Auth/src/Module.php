<?php
declare(strict_types=1);

namespace Auth;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;

/**
 * Class Module
 *
 * @package Auth
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface
{
    /**
     * @return array
     */
    public function getConfig(): array
    {
        return include __DIR__.'/../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig(): array
    {
        $provider = new ConfigProvider();

        return $provider->getDependencyConfig();
    }
}
