<?php


namespace WebApp\Models;


use ReflectionClass;

class ActiveRecord
{
    public static function findOne($attributes)
    {
    }

    public static function findOrCreate(array $attributes)
    {
        $model = static::findOne($attributes);
        if (empty($model)) {
            $model = new static();
            $model->setAttributes($attributes);
        }
        return $model;
    }

    public function setAttributes($values)
    {
        if (is_array($values)) {
            $attributes = array_flip($this->attributes());
            foreach ($values as $name => $value) {
                if (isset($attributes[$name])) {
                    $this->$name = $value;
                }
            }
        }
    }

    /**
     * Returns the list of attribute names.
     * By default, this method returns all public non-static properties of the class.
     * You may override this method to change the default behavior.
     * @return array list of attribute names.
     */
    public function attributes()
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }

        return $names;
    }

    public function save(): bool
    {
        return true;
    }
}