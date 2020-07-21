<?php
declare(strict_types=1);

namespace Auth;


use Laminas\ServiceManager\Factory\InvokableFactory;

/**
 * Class ConfigProvider
 *
 * @package Auth
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
                //Forms
                Form\RegisterForm::class             => Form\RegisterFormFactory::class,
                Form\LoginForm::class                => Form\LoginFormFactory::class,
                //Services
                Service\RegistrationService::class   => Service\RegistrationServiceFactory::class,
                Service\AuthenticationService::class => Service\AuthenticationServiceFactory::class,
                Service\AuthorizeService::class      => Service\AuthorizeServiceFactory::class,
                //Mappers
                Mapper\User::class                   => Mapper\UserFactory::class,
                Mapper\Role::class                   => Mapper\RoleFactory::class,
            ],
            'aliases'   => [
            ],
        ];
    }
}