<?php
declare(strict_types=1);

namespace Auth;

use Auth\Listener\RouteAccessDeniedStrategy;
use Auth\Listener\RouteListener;
use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ControllerPluginProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ModuleManager\Feature\ViewHelperProviderInterface;
use Laminas\Mvc\ApplicationInterface;

/**
 * Class Module
 *
 * @package Auth
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface, BootstrapListenerInterface, ViewHelperProviderInterface, ControllerPluginProviderInterface
{
    /**
     * @param EventInterface $_e
     */
    public function onBootstrap(EventInterface $_e)
    {
        /** @var ApplicationInterface $app */
        $app = $_e->getTarget();
        $container = $app->getServiceManager();
        /** @var RouteListener $routeListener */
        $routeListener = $container->get(RouteListener::class);
        $routeListener->attach($app->getEventManager());
        /** @var RouteAccessDeniedStrategy $routeStrategy */
        $routeStrategy = $container->get(RouteAccessDeniedStrategy::class);
        $routeStrategy->attach($app->getEventManager());
    }

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

    /**
     * @return array
     */
    public function getViewHelperConfig(): array
    {
        return [
            'factories' => [
                'isAllowed' => View\Helper\IsAllowedFactory::class,
            ],
        ];
    }

    /**
     * @return array
     */
    public function getControllerPluginConfig(): array
    {
        return [
            'factories' => [
                'isAllowed' => Controller\Plugin\IsAllowedFactory::class,
            ],
        ];
    }
}
