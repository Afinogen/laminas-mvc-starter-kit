<?php
declare(strict_types=1);

namespace Auth\View\Helper;

use Auth\Service\AuthorizeService;
use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class IsAllowedFactory
 *
 * @package Auth\View\Helper
 */
class IsAllowedFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new IsAllowed($container->get(AuthorizeService::class));
    }
}