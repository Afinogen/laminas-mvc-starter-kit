<?php
declare(strict_types=1);

namespace Auth\Listener;

use Auth\Listener\Exception\UnAuthorizedException;
use Auth\Service\AuthorizeService;
use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Mvc\MvcEvent;

/**
 * Class RouteListener
 *
 * @package Auth\Listener
 */
class RouteListener extends AbstractListenerAggregate
{
    /**
     * Marker for invalid route errors
     */
    public const ERROR = 'error-unauthorized-route';

    /**
     * @var AuthorizeService
     */
    private $_authorizeService;

    /**
     * RouteListener constructor.
     *
     * @param AuthorizeService $_authorizeService
     */
    public function __construct(AuthorizeService $_authorizeService)
    {
        $this->_authorizeService = $_authorizeService;
    }

    /**
     * @param EventManagerInterface $_events
     * @param int $_priority
     */
    public function attach(EventManagerInterface $_events, $_priority = 1): void
    {
        $this->listeners[] = $_events->attach(
            MvcEvent::EVENT_ROUTE,
            [
                $this,
                'onRoute',
            ],
            -1000
        );
    }

    /**
     * @param MvcEvent $_event
     */
    public function onRoute(MvcEvent $_event)
    {
        $match = $_event->getRouteMatch();
        $aclParam = $match->getParam('acl');
//        if ($aclParam === null) {
//
//        }
        $acl = $this->_authorizeService->getAcl();
        $routeName = 'route/'.$match->getMatchedRouteName();
        $acl->addResource($routeName);
        $acl->allow($aclParam['roles'], $routeName);

        if ($this->_authorizeService->isAllowed($routeName)) {
            return $match;
        }

        $_event->setName(MvcEvent::EVENT_DISPATCH_ERROR);
        $_event->setError(self::ERROR);
        $_event->setParam('exception', new UnAuthorizedException('You are not authorized to access '.$routeName));

        $target = $_event->getTarget();
        $results = $target->getEventManager()->triggerEvent($_event);
        if (!empty($results)) {
            return $results->last();
        }

        return $_event->getParams();
    }
}