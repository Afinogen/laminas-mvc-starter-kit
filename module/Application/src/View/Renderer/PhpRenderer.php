<?php
declare(strict_types=1);

namespace Application\View\Renderer;

use Laminas\Form\ElementInterface;
use Laminas\Form\View\Helper\FormElementErrors;
use Laminas\Form\View\Helper\FormRow;
use Laminas\Mvc\Plugin\FlashMessenger\View\Helper\FlashMessenger;

/**
 * Class PhpRenderer
 *
 * @package Application\View\Renderer
 * @method string|FormRow formElement(ElementInterface $element)
 * @method string|FormElementErrors formElementErrors(ElementInterface $element)
 * @method FlashMessenger flashMessenger()
 */
class PhpRenderer extends \Laminas\View\Renderer\PhpRenderer
{
}