<?php

namespace App\Models;

use Core\Model;
use Core\Db;

class Categories extends Model
{

    public static function selectAll()
    {
        $categories = Db::select('select id,name from categories;');
        return $categories;
    }

}