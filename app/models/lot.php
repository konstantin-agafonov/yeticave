<?php

namespace App\Models;

use Core\Model;
use Core\Db;

class Lot extends Model
{

    public static function selectAll()
    {
        $lots = Db::select(
<<< EOD
select  lots.*,
        categories.name as category_name
from    lots
        left join categories on lots.category_id = categories.id;
EOD
        );
        return $lots;
    }

}