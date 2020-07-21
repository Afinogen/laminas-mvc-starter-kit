<?php
declare(strict_types=1);

namespace Auth\Entity;

/**
 * Class User
 *
 * @package Auth\Entity
 */
class User
{
    /**
     * @var int
     */
    protected $_id;

    /**
     * @var string
     */
    protected $_email;

    /**
     * @var string
     */
    protected $_password;

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
    public function setId(?int $_id): self
    {
        $this->_id = $_id;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->_email;
    }

    /**
     * @param string $_email
     *
     * @return $this;
     */
    public function setEmail(?string $_email): self
    {
        $this->_email = $_email;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->_password;
    }

    /**
     * @param string $_password
     *
     * @return $this;
     */
    public function setPassword(?string $_password): self
    {
        $this->_password = $_password;

        return $this;
    }

    /**
     * @param string $_password
     *
     * @return $this
     */
    public function setNewPassword(string $_password): self
    {
        return $this->setPassword(password_hash($_password, PASSWORD_BCRYPT));
    }
}