<?php
declare(strict_types=1);

namespace Auth\Controller\Plugin;

use Auth\Service\AuthorizeService;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class IsAllowed
 *
 * @package Auth\Controller\Plugin
 */
class IsAllowed extends AbstractPlugin
{
    /**
     * @var AuthorizeService
     */
    private $_authorizeService;

    /**
     * IsAllowed constructor.
     *
     * @param AuthorizeService $_authorizeService
     */
    public function __construct(AuthorizeService $_authorizeService)
    {
        $this->_authorizeService = $_authorizeService;
    }

    /**
     * @param $_resource
     * @param null $_privilege
     *
     * @return bool
     */
    public function __invoke($_resource, $_privilege = null): bool
    {
        return $this->_authorizeService->isAllowed($_resource, $_privilege);
    }
}