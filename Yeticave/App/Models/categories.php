<?php

namespace Yeticave\App\Models;

use Yeticave\Core\Model;
use Yeticave\Core\Db;

class Categories extends Model
{

    public static function selectAll()
    {
        $categories = Db::select('select id,name from categories;');
        return $categories;
    }

}