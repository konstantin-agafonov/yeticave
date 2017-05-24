<?php

namespace App\Models;

use Core\Model;
use Core\Db;

class Stakes extends Model
{

    public static function selectByLotId(int $lot_id) {
        $stakes = Db::select(
<<< EOD
select  stakes.*,
        users.name as user_name
from    stakes
        left join users on stakes.user_id = users.id
where   lot_id = ?;
EOD
            ,[$lot_id]
        );
        return $stakes;
    }

    public static function selectByUserId(int $user_id) {
        $stakes = Db::select(
<<< EOD
select  stakes.*,
        lots.pic as lot_pic,
        lots.name as lot_name,
        categories.name as category_name
from stakes
left join lots on stakes.lot_id = lots.id
left join categories on lots.category_id = categories.id
where user_id = ?;
EOD
            ,[$user_id]
        );
        return $stakes;
    }

}