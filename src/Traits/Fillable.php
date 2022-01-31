<?php

/**
 * Fill the class properties by array/object
 */
trait Fillable
{
    public function fillFromArray(array $array): self
    {
        foreach ($array as $key => $value) {
            if (property_exists(__CLASS__, $key)) {
                $setter = 'set' . ucfirst($key);
                if (method_exists(__CLASS__, $setter)) {
                    $this->$setter($value);
                } else {
                    $this->$key = $value;
                }
            }
        }

        return $this;
    }

    public function fillFromObject(object $object): self
    {
        $array = get_object_vars($object);

        return $this->fillFromArray($array);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function fill($arrayOrObject): self
    {
        switch (gettype($arrayOrObject)) {
            case 'array':
                return $this->fillFromArray($arrayOrObject);
            case 'object':
                return $this->fillFromObject($arrayOrObject);
            default:
                throw new InvalidArgumentException('Parameter should be array or object only!');
        }
    }
}
