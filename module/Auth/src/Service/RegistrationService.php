<?php
declare(strict_types=1);

namespace Auth\Service;

use Auth\Entity\User as UserEntity;
use Auth\Mapper\User;

/**
 * Class RegistrationService
 *
 * @package Auth\Service
 */
class RegistrationService
{
    /**
     * @var User
     */
    private $_userMapper;

    /**
     * RegistrationService constructor.
     *
     * @param User $_userMapper
     */
    public function __construct(User $_userMapper)
    {
        $this->_userMapper = $_userMapper;
    }

    /**
     * @param string $_email
     * @param string $_password
     *
     * @return UserEntity
     */
    public function createUser(string $_email, string $_password): UserEntity
    {
        $entity = new UserEntity();
        $entity->setEmail($_email)
            ->setNewPassword($_password);

        $this->_userMapper->insertEntity($entity);

        return $entity;
    }
}