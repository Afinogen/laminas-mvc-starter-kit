<?php
declare(strict_types=1);

namespace Auth\Controller;


use Application\Controller\AbstractController;
use Auth\Form\LoginForm;
use Auth\Service\AuthenticationService;
use Auth\Service\AuthorizeService;
use Laminas\Authentication\Result;
use Laminas\Http\Response;
use Laminas\View\Model\ViewModel;

/**
 * Class LoginController
 *
 * @package Auth\Controller
 */
class LoginController extends AbstractController
{
    /**
     * @var LoginForm
     */
    private $_loginForm;

    /**
     * @var AuthenticationService
     */
    private $_authenticationService;

    /**
     * @var AuthorizeService
     */
    private $_authorizeService;

    /**
     * LoginController constructor.
     *
     * @param LoginForm $_loginForm
     * @param AuthenticationService $_authenticationService
     * @param AuthorizeService $_authorizeService
     */
    public function __construct(LoginForm $_loginForm, AuthenticationService $_authenticationService, AuthorizeService $_authorizeService)
    {
        $this->_loginForm = $_loginForm;
        $this->_authenticationService = $_authenticationService;
        $this->_authorizeService = $_authorizeService;
    }

    /**
     * @return Response|ViewModel
     */
    public function loginAction()
    {
        $this->_authorizeService->loadRoles();exit;

        $form = $this->_loginForm;
        if ($this->getRequest()->isPost()) {
            $form->setData($this->getRequest()->getPost());
            if ($form->isValid()) {
                $result = $this->_authenticationService->authenticate($form->getData()['email'], $form->getData()['password']);
                if ($result && $result->getCode() === Result::SUCCESS) {
                    $this->flashMessenger()->addSuccessMessage('Авторизация успешна');

                    return $this->redirect()->toRoute('home');
                }
                $this->flashMessenger()->addErrorMessage('Не верный логин/пароль');
            }
        }

        return (new ViewModel())->setVariable('form', $form);
    }
}