<?php
declare(strict_types=1);

namespace Auth\Controller;

use Auth\Form\LoginForm;
use Auth\Service\AuthenticationService;
use Auth\Service\AuthorizeService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class LoginControllerFactory
 *
 * @package Auth\Controller
 */
class LoginControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     *
     * @return LoginController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new LoginController(
            $container->get(LoginForm::class),
            $container->get(AuthenticationService::class),
            $container->get(AuthorizeService::class)
        );
    }
}
