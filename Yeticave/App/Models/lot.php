<?php

namespace Yeticave\App\Models;

use Yeticave\Core\Model;
use Yeticave\Core\Db;

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