<?php


namespace WebApp\Models;


use ReflectionClass;
use ReflectionProperty;
use WebApp\Database;

abstract class ActiveRecord
{
    /**
     * @return int
     */
    public abstract function getId(): int;

    /**
     * @return string
     */
    public static abstract function getTableName(): string;

    /**
     * @param $attributes
     * @return ActiveRecord|null
     */
    public static function findOne($attributes): ?ActiveRecord
    {
        $tableName = static::getTableName();
        $queryCondition = '';
        $attributesCount = count($attributes);
        foreach ($attributes as $key => $value) {
            $queryCondition .= "$key = '$value'";
            if ($key < $attributesCount - 1) {
                $queryCondition .= ' AND';
            }
        }
        $data = Database::getConnection()->query("
            SELECT * FROM {$tableName} 
            WHERE
                {$queryCondition}
            LIMIT 1
        ")->fetchArray(SQLITE3_ASSOC);

        if (!empty($data)) {
            $model = new static();
            $model->setAttributes($data);
            return $model;
        }

        return null;
    }

    /**
     * @param array $attributes
     * @return ActiveRecord|null
     */
    public static function findOrCreate(array $attributes): ActiveRecord
    {
        $model = static::findOne($attributes);
        if (empty($model)) {
            $model = new static();
            $model->setAttributes($attributes);
        }
        return $model;
    }

    /**
     * @param array $values
     */
    public function setAttributes(array $values): void
    {
        if (is_array($values)) {
            $attributes = $this->attributes();
            foreach ($values as $name => $value) {
                if (in_array($name, array_keys($attributes))) {
                    $this->$name = $value;
                }
            }
        }
    }

    /**
     * Returns the list of attribute names.
     * This method returns all public non-static properties of the class.
     * @return array list of attribute names.
     */
    public function attributes(): array
    {
        $class = new ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $name = $property->name;
                $names[$name] = $this->$name ?? null;
            }
        }

        return $names;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $tableName = static::getTableName();
        // filter model attributes to get rid of empty values
        $attributes = array_filter($this->attributes(), function ($value) {
            return !empty($value);
        });

        // normalize to sql statement
        $modelKeys = join(', ', array_keys($attributes));
        $modelValues = join(", ", array_values(array_map(function ($value) {
            return "'$value'";
        }, $attributes)));

        return Database::getConnection()->exec("
            INSERT INTO {$tableName} ({$modelKeys})
            VALUES ({$modelValues})
        ");
    }

    /**
     * @param array|null $attributeNames
     * @return bool
     */
    public function update(?array $attributeNames = null): bool
    {
        $tableName = static::getTableName();
        $attributes = [];

        // get data field that needs to be updated
        if (!empty($attributeNames)) {
            foreach ($attributeNames as $attributeName) {
                $attributes[$attributeName] = $this->attributes()[$attributeName];
            }
        } else {
            $attributes = $this->attributes();
        }

        // normalize to sql statement
        $updateRows = '';
        $attributesCount = count($attributes);
        foreach ($attributes as $key => $value) {
            $updateRows .= "$key = $value";
            if ($key < $attributesCount - 1) {
                $updateRows .= ', ';
            }
        }

        return Database::getConnection()->exec("
            UPDATE {$tableName} 
            SET
                {$updateRows}
            WHERE
                id = {$this->getId()}
        ");
    }
}