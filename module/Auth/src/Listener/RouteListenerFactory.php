<?php
declare(strict_types=1);

namespace Auth\Listener;

use Auth\Service\AuthorizeService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class RouteListenerFactory
 *
 * @package Auth\Listener
 */
class RouteListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RouteListener($container->get(AuthorizeService::class));
    }
}