<?php

namespace Yeticave\Core\ActiveRecord\Finder;

use Yeticave\Core\Db;

class UserFinder extends BaseFinder
{
    private static $tableName = 'users';
    private static $entityName = 'User';

    private function __construct(){}
    private function __clone(){}

    public static function findByEmail(string $email)
    {
        $record = Db::select('select * from ' . self::$tableName . ' where email= ?;', [$email]);
        if ($record) {
            $className = 'Yeticave\Core\ActiveRecord\Record\\' . self::$entityName . 'Record';
            $userRecord =  new $className('Db', $record[0], false);
            return $userRecord;
        }
        return false;
    }
}
