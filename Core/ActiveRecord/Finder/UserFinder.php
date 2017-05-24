<?php

namespace Core\ActiveRecord\Finder;

use Core\Db;

class UserFinder extends BaseFinder
{
    private static $tableName = 'users';
    private static $entityName = 'User';

    private function __construct(){}
    private function __clone(){}

    public static function findByEmail(string $email)
    {
        $record = Db::select('select * from ' . self::$tableName . ' where email= ?;',[$email]);
        $record = $record[0];
        if ($record) {
            $className = 'Core\ActiveRecord\Record\\' . self::$entityName . 'Record';
            $userRecord =  new $className('Db',$record,false);
            return $userRecord;
        }
        return false;
    }
}
