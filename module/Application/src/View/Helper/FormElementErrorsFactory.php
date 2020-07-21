<?php
declare(strict_types=1);

namespace Application\View\Helper;

use Interop\Container\ContainerInterface;
use Laminas\Form\View\Helper\FormElementErrors;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class FormElementErrorsFactory
 *
 * @package Application\View\Helper
 */
class FormElementErrorsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new FormElementErrors();
        $helper->setMessageOpenFormat('<div class="invalid-feedback"%s>');
        $helper->setMessageCloseString('</div>');
        $helper->setMessageSeparatorString('<br/>');

        return $helper;
    }
}