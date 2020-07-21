<?php
declare(strict_types=1);

namespace Application;

use Laminas\Db\Adapter\AdapterAbstractServiceFactory;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\Session\SessionManager;

/**
 * Class ConfigProvider
 *
 * @package Application
 */
class ConfigProvider
{
    /**
     * @return array
     */
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencyConfig(),
        ];
    }

    /**
     * @return array
     */
    public function getDependencyConfig(): array
    {
        return [
//            'abstract_factories' => [
//            ],
            'factories' => [
                Console\EchoCommand::class => InvokableFactory::class,

                'mysql' => AdapterAbstractServiceFactory::class,
            ],
            'aliases'   => [
                AdapterInterface::class => 'mysql',
            ],
        ];
    }
}