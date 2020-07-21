<?php
declare(strict_types=1);

namespace Application\Mapper;


use Application\Mapper\Hydrator\ClassMethodsHydrator;
use Application\Mapper\Hydrator\HydratingResultSet;
use Laminas\Db\TableGateway\TableGateway;

/**
 * Class AbstractMapper
 *
 * @package Application\Mapper
 */
abstract class AbstractMapper extends TableGateway
{
    /**
     * @var string
     */
    protected $_primaryKey = 'id';

    /**
     * Получение 1 элемента по id
     *
     * @param int $_id
     *
     * @return object|null
     */
    public function findById(int $_id): ?object
    {
        $hResult = $this->hydrate($this->select([$this->_primaryKey => $_id]));

        return $hResult->current();
    }

    /**
     * Поиск 1 элемента по параметрам
     *
     * @param $_where
     *
     * @return object|null
     */
    public function findOneBy($_where): ?object
    {
        $select = $this->getSql()->select();
        $select->where($_where);
        $select->limit(1);

        return $this->hydrate($this->selectWith($select))->current();
    }

    /**
     * Выборка всех элементов по условию и сортировке
     *
     * @param null $_where
     * @param null $_order
     *
     * @return HydratingResultSet
     */
    public function fetchAll($_where = null, $_order = null): HydratingResultSet
    {
        $select = $this->getSql()->select();
        if ($_where) {
            $select->where($_where);
        }
        if ($_order) {
            $select->order($_order);
        }

        return $this->hydrate($this->selectWith($select));
    }

    /**
     * Вставка сущности
     *
     * @param object $_entity
     *
     * @return int
     */
    public function insertEntity(object $_entity): int
    {
        $res = $this->insert($this->getHydrator()->extract($_entity));

        if ($res && $_entity->getId() === null) {
            $_entity->setId((int)$this->getLastInsertValue());
        }

        return $res;
    }

    /**
     * @param object $_entity
     * @param null|array $_rows
     *
     * @return int
     */
    public function updateEntity(object $_entity, array $_rows = null): int
    {
        $set = $this->getHydrator()->extract($_entity);

        if (!empty($_rows)) {
            $set = array_intersect_key($set, array_flip($_rows));
        }

//        $this->getEventManager()->trigger(__FUNCTION__, $this, ['entity' => $_entity]);

        return $this->update($set, [$this->_primaryKey => $_entity->getId()]);
    }

    /**
     * @param object $_entity
     *
     * @return int
     */
    public function forceDeleteEntity(object $_entity): int
    {
//        $this->getEventManager()->trigger(__FUNCTION__, $this, ['entity' => $_entity]);

        return $this->delete([$this->_primaryKey => $_entity->getId()]);
    }

    /**
     * @param object $_entity
     *
     * @return int|null
     */
    public function deleteEntity(object $_entity): ?int
    {
        $result = null;

//        $this->getEventManager()->trigger(__FUNCTION__, $this, ['entity' => $_entity]);

        if (method_exists($_entity, 'isDeleted')) {
            $_entity->isDeleted(true);
            $result = $this->saveEntity($_entity);
        } else {
            $result = $this->forceDeleteEntity($_entity);
        }

        return $result;
    }

    /**
     * @param object $_entity
     * @param array $_rows
     *
     * @return int
     */
    public function saveEntity(object $_entity, array $_rows = []): int
    {
        return $_entity->getId() && $this->findById($_entity->getId()) ? $this->updateEntity($_entity, $_rows) : $this->insertEntity($_entity);
    }

    /**
     * @return ClassMethodsHydrator
     */
    protected function getHydrator(): ClassMethodsHydrator
    {
        return new ClassMethodsHydrator();
    }
}