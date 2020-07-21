<?php
declare(strict_types=1);

namespace Auth\Mapper;

use Application\Mapper\AbstractMapper;
use Application\Mapper\Hydrator\ClassMethodsHydrator;
use Application\Mapper\Hydrator\HydratingResultSet;
use Laminas\Db\ResultSet\ResultSetInterface;

/**
 * Class Role
 *
 * @package Auth\Mapper
 */
class Role extends AbstractMapper
{
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