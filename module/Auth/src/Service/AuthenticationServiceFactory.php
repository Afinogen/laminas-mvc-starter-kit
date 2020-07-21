<?php
declare(strict_types=1);

namespace Auth\Service;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\Session\Container;

/**
 * Class AuthenticationServiceFactory
 *
 * @package Auth\Service
 */
class AuthenticationServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AuthenticationService(
            $container->get(Adapter::class),
            $container->get(Container::class)
        );
    }
}