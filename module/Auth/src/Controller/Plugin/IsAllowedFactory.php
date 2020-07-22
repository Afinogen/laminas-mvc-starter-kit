<?php
declare(strict_types=1);

namespace Auth\Controller\Plugin;

use Auth\Service\AuthorizeService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class IsAllowedFactory
 *
 * @package Auth\Controller\Plugin
 */
class IsAllowedFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new IsAllowed($container->get(AuthorizeService::class));
    }
}