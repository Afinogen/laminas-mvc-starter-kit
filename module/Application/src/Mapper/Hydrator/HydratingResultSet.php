<?php
declare(strict_types=1);

namespace Application\Mapper\Hydrator;

/**
 * Class HydratingResultSet
 *
 * @package Application\Mapper\Hydrator
 */
class HydratingResultSet extends \Laminas\Db\ResultSet\HydratingResultSet
{
    /**
     * По какому ключу группировать массив энтити
     */
    public const DEFAULT_AS_ARRAY_KEY = 'Id';

    /**
     * Вернет массив с ключами из метода $_key
     *
     * @param string $_key
     *
     * @return array
     */
    public function asArray(string $_key = self::DEFAULT_AS_ARRAY_KEY): array
    {
        $_key = 'get'.$_key;
        $return = [];

        foreach ($this as $row) {
            if (method_exists($row, $_key)) {
                $result = $row->{$_key}();
                $key = is_array($result) ? implode('-', $result) : $result;

                $return[$key] = $row;

            } else {
                $return[] = $row;
            }
        }

        return $return;
    }

    /**
     * @param string|null $_key
     * @param bool $_useObjectName
     *
     * @return array
     */
    public function toArray(string $_key = null, bool $_useObjectName = false): array
    {
        $return = [];
        foreach ($this as $row) {
            if ($_key) {
                $item = $this->hydrator->extract($row);
                $return[$item[$_key]] = $item;
            } else {
                $return[] = $this->hydrator->extract($row);
            }
        }

        return $return;
    }
}