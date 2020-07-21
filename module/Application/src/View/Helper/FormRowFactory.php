<?php
declare(strict_types=1);

namespace Application\View\Helper;

use Interop\Container\ContainerInterface;
use Laminas\Form\View\Helper\FormRow;
use Laminas\ServiceManager\Factory\FactoryInterface;

/**
 * Class FormRowFactory
 *
 * @package Application\View\Helper
 */
class FormRowFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $helper = new FormRow();
        $helper->setInputErrorClass('is-invalid');
        $helper->setPartial('helper/form/row');
//        $helper->setLabelPosition(FormRow::LABEL_APPEND);

        return $helper;
    }
}