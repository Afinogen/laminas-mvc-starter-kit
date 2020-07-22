<?php
declare(strict_types=1);

namespace Auth\Service;

use Auth\Mapper\Role;
use Laminas\Permissions\Acl\Acl;

/**
 * Class AuthorizeService
 *
 * @package Auth\Service
 */
class AuthorizeService
{
    public const DEFAULT_ROLE = 'guest';
    private const AGGREGATE_ROLE = 'acl-aggregate-role';

    /**
     * @var Role
     */
    private $_roleMapper;

    /**
     * @var Acl
     */
    private $_acl;

    /**
     * @var bool
     */
    private $_isLoaded;

    /**
     * @var AuthenticationService
     */
    private $_authenticationService;

    /**
     * AuthorizeService constructor.
     *
     * @param Role $_roleMapper
     * @param AuthenticationService $_authenticationService
     */
    public function __construct(Role $_roleMapper, AuthenticationService $_authenticationService)
    {
        $this->_roleMapper = $_roleMapper;
        $this->_authenticationService = $_authenticationService;
        $this->_acl = new Acl();
        $this->_isLoaded = false;
    }

    public function loadRoles()
    {
        /** @var \Auth\Entity\Role[] $roles */
        $roles = $this->_roleMapper->fetchAll()->asArray();
        $this->addRoles($roles);

        $userId = $this->_authenticationService->getUserIdFromSession();
        $userRoles = [];
        if ($userId) {
            $userRoles = $this->_roleMapper->getRolesByUserId($userId);
        }

        if (empty($userRoles)) {
            $userRoles[] = (new \Auth\Entity\Role())->setName(self::DEFAULT_ROLE);
        }
        $this->_acl->addRole(self::AGGREGATE_ROLE, $userRoles);

        $this->_isLoaded = true;
    }

    /**
     * @return Acl
     */
    public function getAcl(): Acl
    {
        if (!$this->_isLoaded) {
            $this->loadRoles();
        }

        return $this->_acl;
    }

    /**
     * @param string $_resource
     * @param string|null $_privilege
     *
     * @return bool
     */
    public function isAllowed(string $_resource, string $_privilege = null): bool
    {
        return $this->getAcl()->isAllowed(self::AGGREGATE_ROLE, $_resource, $_privilege);
    }

    /**
     * @param $_roles
     */
    protected function addRoles($_roles): void
    {
        if (!is_array($_roles) && !($_roles instanceof \Traversable)) {
            $_roles = [$_roles];
        }

        /* @var $role \Auth\Entity\Role */
        foreach ($_roles as $role) {
            if ($this->_acl->hasRole($role)) {
                continue;
            }

            if ($role->getParentId() !== null) {
                $parentRole = $_roles[$role->getParentId()];
                $this->addRoles([$parentRole]);
                $this->_acl->addRole($role, $parentRole);
            } elseif (!$this->_acl->hasRole($role)) {
                $this->_acl->addRole($role);
            }
        }
    }
}