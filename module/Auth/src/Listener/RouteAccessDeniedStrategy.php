<?php
declare(strict_types=1);

namespace Auth\Listener;

use Laminas\EventManager\AbstractListenerAggregate;
use Laminas\EventManager\EventManagerInterface;
use Laminas\Http\Response as HttpResponse;
use Laminas\Mvc\MvcEvent;
use Laminas\View\Model\ViewModel;

/**
 * Class RouteAccessDeniedStrategy
 *
 * @package Auth\Listener
 */
class RouteAccessDeniedStrategy extends AbstractListenerAggregate
{
    /**
     * @param EventManagerInterface $_events
     * @param int $priority
     */
    public function attach(EventManagerInterface $_events, $priority = 1)
    {
        $this->listeners[] = $_events->attach(
            MvcEvent::EVENT_DISPATCH_ERROR, [
                $this,
                'detectAccessDeniedError',
            ]
        );
    }

    /**
     * @param MvcEvent $_event
     */
    public function detectAccessDeniedError(MvcEvent $_event): void
    {
        $error = $_event->getError();
        if (empty($error)) {
            return;
        }

        if ($error === RouteListener::ERROR) {
            $result = $_event->getResult();
            if ($result instanceof ViewModel) {
                $result->setTemplate('error/403');
            }

            $response = $_event->getResponse();
            if (!$response) {
                $response = new HttpResponse();
                $_event->setResponse($response);
            }
            $response->setStatusCode(403);
        }
    }
}