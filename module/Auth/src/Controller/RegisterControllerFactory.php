<?php
declare(strict_types=1);

namespace Auth\Controller;

use Auth\Form\RegisterForm;
use Auth\Service\RegistrationService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class RegisterControllerFactory
 *
 * @package Auth\Controller
 */
class RegisterControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return RegisterController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new RegisterController(
            $container->get(RegisterForm::class),
            $container->get(RegistrationService::class),
        );
    }
}
