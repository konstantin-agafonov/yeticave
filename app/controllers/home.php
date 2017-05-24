<?php

namespace App\Controllers;

use Core\View;
use Core\User;
use Core\Db;

class Home extends \Core\Controller
{

    public function indexAction()
    {

        $user = new User('Db');

        $categories = Db::select('select id,name from categories;');

        // записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
        $lot_time_remaining = "00:00";

        // временная метка для полночи следующего дня
        $tomorrow = strtotime('tomorrow midnight');

        // временная метка для настоящего времени
        $now = time();

        // далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
        $lot_time_remaining = date("H:i", $tomorrow + ($tomorrow - $now));

        $lots = Db::select(
<<< EOD
select  lots.*,
        categories.name as category_name
from    lots
        left join categories on lots.category_id = categories.id;
EOD
        );


        View::render('home/index.php',[
            'user' => $user,
            'lots' => $lots,
            'categories' => $categories,
            'lot_time_remaining' => $lot_time_remaining
        ]);

    }

}