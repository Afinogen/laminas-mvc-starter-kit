<?php
declare(strict_types=1);

namespace Auth\Mapper;

use Application\Mapper\AbstractMapper;
use Application\Mapper\Hydrator\ClassMethodsHydrator;
use Application\Mapper\Hydrator\HydratingResultSet;
use Laminas\Db\ResultSet\ResultSetInterface;
use Laminas\Db\Sql\Sql;

/**
 * Class Role
 *
 * @package Auth\Mapper
 */
class Role extends AbstractMapper
{
    /**
     * Получение списка ролей по id пользователя
     *
     * @param int $_userId
     *
     * @return array
     */
    public function getRolesByUserId(int $_userId): array
    {
        $select = (new Sql($this->getAdapter()))->select('user_has_role');
        $select->where(['user_id' => $_userId]);

        return $this->hydrate($this->selectWith($select))->asArray();
    }

    /**
     * @param ResultSetInterface $_result
     *
     * @return HydratingResultSet
     */
    protected function hydrate(ResultSetInterface $_result): HydratingResultSet
    {
        $hResult = new HydratingResultSet(new ClassMethodsHydrator(), new \Auth\Entity\Role());
        $hResult->initialize($_result->getDataSource());

        return $hResult;
    }
}