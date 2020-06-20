<?php

namespace Core;

use Core\QueryBuilder as DB;

abstract class Model
{
    protected $fillable = [];
    protected $table;
    protected $primaryKey;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    public function __construct()
    {
        app()->callModel = get_called_class();
    }

    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        $this->$property = $value;
    }

    public function fillable()
    {
        return $this->fillable;
    }

    public function primaryKey()
    {
        return $this->primaryKey;
    }


    public static function __callStatic($method, $args)
    {
        return static::getInstance()->execCallStatic($method, $args);
    }

    public function __call($method, $args)
    {
        return static::getInstance()->execCallStatic($method, $args);
    }

    public function execCallStatic($method, $args)
    {
        return DB::staticEloquentBuilder($this->table, $method, $args);
    }
}
