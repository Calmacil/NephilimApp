<?php
namespace Nephilim\Entities;

/**
 * This class is design to be only a data container
 *
 * @author Calmacil
 */
abstract class AbstractEntity implements ArrayAccess
{

    /**
     * Manages relations
     * @var array
     */
    protected $relations = array();

    /**
     * Checks if a property exists
     * @param mixed $offset
     * @return boolean
     */
    public function offsetExists(mixed $offset): boolean
    {
        return method_exists($this, "_{$offset}");
    }

    /**
     * Gets a property's value
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->populateOrGetProperty($offset);
    }

    /**
     * Sets a property's value
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (!$this->offsetExists($offset))
            throw new EntityError("Tried to set a non-existing field", 2);
        $this->{"_{$offset}"} = $value;
    }

    /**
     * Unsets a property's value
     * @param mixed $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists($offset))
            throw new EntityError("Tried to unset a non-existing field", 3);
        $this->{"_{$offset}"} = null;
    }

    /**
     * Alias for offsetGet()
     * @param string $name
     */
    public function __get(string $name): mixed
    {
        return $this->offsetGet($name);
    }

    /**
     * Alias for offsetSet()
     * @param string $name
     * @param mixed $value
     */
    public function __set(string $name, mixed $value): void
    {
        $this->offsetSet($name, $value);
    }

    private function populateOrGetProperty($name): mixed
    {
        if (property_exists($this, ($relation_name = "__" . ucfirst($name)))) {
            if (!$this->{$relation_name}) {
                if (!array_key_exists(ucfirst($name), $this->relations))
                    throw new EntityError("Tried to access a non-existing relation", 4);
                $this->{$relation_name} = $this->{$relations[ucfirst($name)]}();
            }
            return $this->{$relation_name};
        }

        if (!$this->offsetExists($offset))
            throw new EntityError("Tried to access a non-existing field", 1);
        return $this->{"_{$offset}"};
    }
}
