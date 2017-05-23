<?php

namespace ActiveRecord\Finder;

abstract class BaseFinder
{
    private function __construct(){}
    private function __clone(){}

    public static function findById(int $id) {
        $record = \Core\Db::select('select * from ' . self::$tableName . ' where id = ?',[$id]);
        if ($record) {
            $className = '\ActiveRecord\Record\\' . self::$entityName . 'Record';
            return new $className($record);
        }
        return false;
    }
}