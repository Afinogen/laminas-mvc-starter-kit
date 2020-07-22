<?php
declare(strict_types=1);

namespace Application\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\Mvc\Plugin\FlashMessenger\FlashMessenger;

/**
 * Class AbstractController
 *
 * @package Application\Controller
 *
 * @method FlashMessenger flashMessenger()
 * @method bool isAllowed($_resource, $_privilege = null)
 */
class AbstractController extends AbstractActionController
{
}