<?php
declare(strict_types=1);

namespace Auth\Mapper;


use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class UserFactory
 *
 * @package Auth\Mapper
 */
class UserFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new User('user', $container->get(Adapter::class), null);
    }
}