<?php
declare(strict_types=1);

namespace Auth\Form;

use Interop\Container\ContainerInterface;
use Laminas\Db\Adapter\Adapter;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class RegisterFormFactory
 *
 * @package Auth\Form
 */
class RegisterFormFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     *
     * @return RegisterForm
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RegisterForm($container->get(Adapter::class));
    }
}
