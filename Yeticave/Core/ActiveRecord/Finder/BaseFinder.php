<?php

namespace Yeticave\Core\ActiveRecord\Finder;

use Yeticave\Core;

abstract class BaseFinder
{
    private function __construct(){}
    private function __clone(){}

    public static function findById(int $id) {
        $record = Db::select('select * from ' . self::$tableName . ' where id = ?',[$id]);
        if ($record) {
            $className = 'Core\ActiveRecord\Record\\' . self::$entityName . 'Record';
            return new $className($record);
        }
        return false;
    }
}