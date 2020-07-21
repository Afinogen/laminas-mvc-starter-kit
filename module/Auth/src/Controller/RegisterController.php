<?php
declare(strict_types=1);

namespace Auth\Controller;


use Application\Controller\AbstractController;
use Auth\Form\RegisterForm;
use Auth\Service\RegistrationService;
use Laminas\View\Model\ViewModel;

/**
 * Class RegisterController
 *
 * @package Auth\Controller
 */
class RegisterController extends AbstractController
{
    /**
     * @var RegisterForm
     */
    private $_registerForm;

    /**
     * @var RegistrationService
     */
    private $_registrationService;

    /**
     * RegisterController constructor.
     *
     * @param RegisterForm $_registerForm
     * @param RegistrationService $_registrationService
     */
    public function __construct(RegisterForm $_registerForm, RegistrationService $_registrationService)
    {
        $this->_registerForm = $_registerForm;
        $this->_registrationService = $_registrationService;
    }

    /**
     * @return \Laminas\Http\Response|ViewModel
     */
    public function registerAction()
    {
        $view = new ViewModel();

        $form = $this->_registerForm;
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $this->_registrationService->createUser($form->getData()['email'], $form->getData()['password']);
                $this->flashMessenger()->addSuccessMessage('Вы успешно зарегистрированны');

                return $this->redirect()->toRoute('home');
            }
        }

        $view->setVariable('form', $this->_registerForm);

        return $view;
    }
}