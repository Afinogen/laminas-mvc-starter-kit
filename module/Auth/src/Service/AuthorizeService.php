<?php
declare(strict_types=1);

namespace Auth\Service;

use Auth\Mapper\Role;
use Laminas\Permissions\Acl\Acl;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Class AuthorizeService
 *
 * @package Auth\Service
 */
class AuthorizeService
{
    /**
     * @var Role
     */
    private $_roleMapper;

    /**
     * @var Acl
     */
    private $_acl;

    /**
     * AuthorizeService constructor.
     *
     * @param Role $_roleMapper
     */
    public function __construct(Role $_roleMapper)
    {
        $this->_roleMapper = $_roleMapper;
        $this->_acl = new Acl();
    }

    public function loadRoles()
    {
        /** @var \Auth\Entity\Role[] $roles */
        $roles = $this->_roleMapper->fetchAll()->asArray();
        $this->addRoles($roles);

        VarDumper::dump($roles);
        VarDumper::dump($this->_acl);
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