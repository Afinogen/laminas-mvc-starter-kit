<?php
declare(strict_types=1);

namespace Auth\Form;

use Laminas\Db\Adapter\Adapter;
use Laminas\Filter\StringToLower;
use Laminas\Filter\StringTrim;
use Laminas\Form\Element\Email;
use Laminas\Form\Element\Password;
use Laminas\Form\Element\Submit;
use Laminas\Form\Form;
use Laminas\InputFilter\InputFilter;
use Laminas\Validator\Db\NoRecordExists;
use Laminas\Validator\EmailAddress;
use Laminas\Validator\Identical;

/**
 * Class RegisterForm
 *
 * @package Auth\Form
 */
class RegisterForm extends Form
{
    /**
     * @var Adapter
     */
    private $_adapter;

    /**
     * RegisterForm constructor.
     *
     * @param Adapter $_adapter
     * @param null $name
     * @param array $options
     */
    public function __construct(Adapter $_adapter, $name = null, $options = [])
    {
        parent::__construct($name, $options);
        $this->_adapter = $_adapter;

        $this->setAttribute('class', 'needs-validation');
        $this->add(
            (new Email('email'))
                ->setLabel('E-mail')
                ->setAttribute('class', 'form-control')
        );

        $this->add(
            (new Password('password'))
                ->setLabel('Пароль')
                ->setAttribute('class', 'form-control')
        );

        $this->add(
            (new Password('password_confirm'))
                ->setLabel('Повтор пароля')
                ->setAttribute('class', 'form-control')
        );

        $this->add(
            (new Submit('send'))
                ->setValue('Регистрация')
                ->setAttribute('class', 'btn btn-primary')
        );

        $this->setInputFilter($this->createInputFilter());
    }

    /**
     * @return InputFilter
     */
    protected function createInputFilter(): InputFilter
    {
        return (new InputFilter())
            ->add(
                [
                    'name'       => 'email',
                    'filters'    => [
                        ['name' => StringTrim::class],
                        ['name' => StringToLower::class],
                    ],
                    'validators' => [
                        ['name' => EmailAddress::class],
                        [
                            'name'    => NoRecordExists::class,
                            'options' => [
                                'table'   => 'user',
                                'field'   => 'email',
                                'adapter' => $this->_adapter,
                            ],
                        ],
                    ],
                ]
            )
            ->add(
                [
                    'name' => 'password',
                ]
            )
            ->add(
                [
                    'name'       => 'password_confirm',
                    'validators' => [
                        [
                            'name'    => Identical::class,
                            'options' => [
                                'token'    => 'password',
                                'messages' => [
                                    Identical::NOT_SAME => 'Пароли не совпадают!',
                                ],
                            ],
                        ],
                    ],
                ]
            );
    }
}