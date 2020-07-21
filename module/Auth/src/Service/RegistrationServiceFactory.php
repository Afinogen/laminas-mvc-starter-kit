<?php
declare(strict_types=1);

namespace Auth\Service;

use Auth\Mapper\User;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class RegistrationServiceFactory
 *
 * @package Auth\Service
 */
class RegistrationServiceFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return RegistrationService
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RegistrationService($container->get(User::class));
    }
}
