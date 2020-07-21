<?php
declare(strict_types=1);

namespace Application;

use Laminas\EventManager\EventInterface;
use Laminas\ModuleManager\Feature\BootstrapListenerInterface;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\ModuleManager\Feature\ServiceProviderInterface;
use Laminas\ModuleManager\Feature\ViewHelperProviderInterface;
use Laminas\Mvc\ModuleRouteListener;
use Laminas\Mvc\MvcEvent;
use Laminas\Session\SessionManager;

/**
 * Class Module
 *
 * @package Application
 */
class Module implements ConfigProviderInterface, ServiceProviderInterface, ViewHelperProviderInterface, BootstrapListenerInterface
{
    /**
     * @param EventInterface $_e
     */
    public function onBootstrap(EventInterface $_e)
    {
        $eventManager        = $_e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
        $this->bootstrapSession($_e);
    }

    /**
     * @param MvcEvent $_e
     */
    public function bootstrapSession(MvcEvent $_e)
    {
        $session = $_e->getApplication()
            ->getServiceManager()
            ->get(SessionManager::class);
        $session->start();
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

    public function getViewHelperConfig(): array
    {
        return [
            'aliases'   => [
                \Laminas\Form\View\Helper\FormElementErrors::class => 'BootstrapFormElementErrors',
                \Laminas\Form\View\Helper\FormRow::class           => 'BootstrapFormRow',
            ],
            'factories' => [
                'BootstrapFormElementErrors' => View\Helper\FormElementErrorsFactory::class,
                'BootstrapFormRow'           => View\Helper\FormRowFactory::class,
            ],
        ];
    }
}
