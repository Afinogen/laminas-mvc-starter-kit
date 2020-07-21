<?php
declare(strict_types=1);

namespace Auth\Entity;

use Laminas\Permissions\Acl\Role\RoleInterface;

/**
 * Class Role
 *
 * @package Auth\Entity
 */
class Role implements RoleInterface
{
    /**
     * @var int
     */
    protected $_id;

    /**
     * @var string
     */
    protected $_name;

    /**
     * @var int
     */
    protected $_parentId;

    /**
     * @var Role|null
     */
    protected $_parent;

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->_id;
    }

    /**
     * @param int $_id
     *
     * @return $this;
     */
    public function setId(int $_id): self
    {
        $this->_id = $_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->_name;
    }

    /**
     * @param string $_name
     *
     * @return $this;
     */
    public function setName(string $_name): self
    {
        $this->_name = $_name;

        return $this;
    }

    /**
     * @return int
     */
    public function getParentId(): ?int
    {
        return $this->_parentId;
    }

    /**
     * @param int $_parentId
     *
     * @return $this;
     */
    public function setParentId(?int $_parentId): self
    {
        $this->_parentId = $_parentId;

        return $this;
    }

    /**
     * @return Role|null
     */
    public function getParent(): ?Role
    {
        return $this->_parent;
    }

    /**
     * @param Role|null $_parent
     *
     * @return $this;
     */
    public function setParent(?Role $_parent): self
    {
        $this->_parent = $_parent;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoleId(): string
    {
        return $this->getName();
    }

    /**
     * Defined by RoleInterface; returns the Role identifier
     * Proxies to getRoleId()
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getRoleId();
    }
}