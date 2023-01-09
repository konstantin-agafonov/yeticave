<?php

namespace Yeticave\Core\ActiveRecord\Finder;

use Yeticave\Core\Db;

class StakeFinder extends BaseFinder
{
    private static $tableName = 'stakes';
    private static $entityName = 'Stake';

    private function __construct(){}
    private function __clone(){}

    public static function maxByLotId(int $id)
    {
        $stakeFields = Db::select(
<<< EOD
select    stakes.*
from      stakes
where     stakes.lot_id = ?
order by  stakes.stake_sum desc
limit     1;
EOD
        , [$id]
        );

        if ($stakeFields) {
            $stakeFields = $stakeFields[0];
            $className = 'Yeticave\Core\ActiveRecord\Record\\' . self::$entityName . 'Record';
            $stakeRecord = new $className('Core\Db', $stakeFields, false);
            return $stakeRecord;
        } else {
            return false;
        }
    }
}
