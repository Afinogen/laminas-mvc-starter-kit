<?php
declare(strict_types=1);

namespace Application\Mapper\Hydrator;


use Laminas\Hydrator\AbstractHydrator;
use Laminas\Hydrator\NamingStrategy\UnderscoreNamingStrategy;

/**
 * Class ClassMethodsHydrator
 *
 * @package Application\Mapper\Hydrator
 */
class ClassMethodsHydrator extends AbstractHydrator
{
    /**
     * @var array Кеш методов
     */
    protected static $reflectionMethods = [];

    /**
     * Simple in-memory array cache of ReflectionProperties used.
     *
     * @var \ReflectionProperty[][]
     */
    protected static $reflProperties = [];

    public function __construct()
    {
        $this->setNamingStrategy(new UnderscoreNamingStrategy());
    }

    /**
     * @param array $data
     * @param object $object
     *
     * @return object
     * @throws \ReflectionException
     */
    public function hydrate(array $data, object $object)
    {
        $reflectionMethods = $this->getReflectionMethods($object);

        foreach ($data as $key => $value) {
            $setterName = 'set'.ucfirst($this->hydrateName($key, $data));
            if (isset($reflectionMethods[$setterName])) {
                $type = current($reflectionMethods[$setterName]);
                $value = $this->hydrateValue($key, $value, $data);
                if ($value !== null) {
                    settype($value, $type);
                }
                $object->{$setterName}($value);
            }
        }

        return $object;
    }

    public function extract(object $object): array
    {
        $result = [];
        foreach (self::getReflProperties($object) as $property) {
            $propertyName = substr($this->extractName($property->getName(), $object), 1);
            if (!$this->getCompositeFilter()->filter($propertyName)) {
                continue;
            }

            $value = $property->getValue($object);
            $result[$propertyName] = $this->extractValue($propertyName, $value, $object);
        }

        return $result;
    }

    /**
     * Получение списка методов с типами параметров
     *
     * @param object $object
     *
     * @return array
     * @throws \ReflectionException
     */
    protected function getReflectionMethods(object $object): array
    {
        $class = get_class($object);

        if (isset(static::$reflectionMethods[$class])) {
            return static::$reflectionMethods[$class];
        }
        //TODO Afinogen Кешировать все это

        static::$reflectionMethods[$class] = [];
        $reflClass = new \ReflectionClass($class);
        $methods = $reflClass->getMethods();
        $reflProperties = $reflClass->getProperties();
        $properties = [];
        foreach ($reflProperties as $property) {
            $properties[strtolower(substr($property->getName(), 1))] = $property->getName();
        }
        foreach ($methods as $method) {
            if (isset(
                $properties[str_replace(
                    [
                        'set',
                        'get',
                    ], [''], strtolower($method->getName())
                )]
            )) {
                $data = [];
                foreach ($method->getParameters() as $parameter) {
                    $data[$parameter->getName()] = $parameter->getType()->getName();
                }
                static::$reflectionMethods[$class][$method->getName()] = $data;
            }
        }

        return static::$reflectionMethods[$class];
    }

    /**
     * Get a reflection properties from in-memory cache and lazy-load if
     * class has not been loaded.
     *
     * @return \ReflectionProperty[]
     */
    protected static function getReflProperties(object $input): array
    {
        $class = get_class($input);

        if (isset(static::$reflProperties[$class])) {
            return static::$reflProperties[$class];
        }

        static::$reflProperties[$class] = [];
        $reflClass = new \ReflectionClass($class);
        $reflProperties = $reflClass->getProperties();

        foreach ($reflProperties as $property) {
            $property->setAccessible(true);
            static::$reflProperties[$class][$property->getName()] = $property;
        }

        return static::$reflProperties[$class];
    }
}