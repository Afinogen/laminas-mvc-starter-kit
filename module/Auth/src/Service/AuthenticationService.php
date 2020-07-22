<?php
declare(strict_types=1);

namespace Auth\Service;

use Laminas\Db\Adapter\Adapter;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;
use Laminas\Session\Container as SessionContainer;

/**
 * Class AuthenticationService
 *
 * @package Auth\Service
 */
class AuthenticationService
{
    /**
     * @var Adapter
     */
    private $_adapter;

    /**
     * @var SessionContainer
     */
    private $_sessionContainer;

    /**
     * AuthenticationService constructor.
     *
     * @param Adapter $_adapter
     * @param SessionContainer $_sessionContainer
     */
    public function __construct(Adapter $_adapter, SessionContainer $_sessionContainer)
    {
        $this->_adapter = $_adapter;
        $this->_sessionContainer = $_sessionContainer;
    }

    /**
     * @param string $_email
     * @param string $_password
     * @param bool $_saveAuth
     *
     * @return bool|\Laminas\Authentication\Result
     */
    public function authenticate(string $_email, string $_password, bool $_saveAuth = true)
    {
        $authAdapter = new AuthAdapter($this->_adapter);
        $authAdapter->setTableName('user')
            ->setIdentityColumn('email')
            ->setCredentialColumn('password')
            ->setIdentity($_email)
            ->setCredential($_password)
            ->setCredentialValidationCallback(
                [
                    $this,
                    'passwordVerify',
                ]
            );

        $result = $authAdapter->authenticate();
        if ($result->isValid() && $_saveAuth) {
            $obj = $authAdapter->getResultRowObject();
            $this->saveUserToSession((int)$obj->id);
        }

        return $result;
    }

    /**
     * @param string $_hash
     * @param string $_password
     *
     * @return bool
     */
    public function passwordVerify(string $_hash, string $_password): bool
    {
        return password_verify($_password, $_hash);
    }

    /**
     * @param int $_id
     */
    public function saveUserToSession(int $_id)
    {
        $this->_sessionContainer->offsetSet('user', $_id);
    }

    /**
     * @return int|null
     */
    public function getUserIdFromSession(): ?int
    {
        return $this->_sessionContainer->offsetGet('user');
    }
}