<?php

namespace Yeticave\Core\ActiveRecord\Finder;

use Yeticave\Core\Db;

class LotFinder extends BaseFinder
{
    private static $tableName = 'lots';
    private static $entityName = 'Lot';

    private function __construct(){}
    private function __clone(){}

    public static function findById(int $id)
    {

        $lotFields = Db::select(
<<< EOD
select  lots.*,
        categories.name as category_name
from    lots
        left join categories on lots.category_id = categories.id
where   lots.id= ?;
EOD
        , [$id]
        );

        if ($lotFields) {
            $lotFields = $lotFields[0];
            $className = 'Yeticave\Core\ActiveRecord\Record\\' . self::$entityName . 'Record';
            $lotRecord = new $className('Core\Db', $lotFields, false);
            return $lotRecord;
        } else {
            return false;
        }
    }
}
