<?php
declare(strict_types=1);

namespace Auth\Service;

use Auth\Mapper\Role;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class AuthorizeServiceFactory
 *
 * @package Auth\Service
 */
class AuthorizeServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new AuthorizeService($container->get(Role::class));
    }
}