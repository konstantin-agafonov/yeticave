<?php

namespace Yeticave\App\Controllers;

use Yeticave\Core\View;
use Yeticave\Core\User;
use Yeticave\Core\Controller;
use Yeticave\App\Models\Categories;
use Yeticave\App\Models\Lot;

class Home extends Controller
{

    public function indexAction()
    {

        $user = new User('Db');

        $categories = Categories::selectAll();

        // записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
        $lot_time_remaining = "00:00";

        // временная метка для полночи следующего дня
        $tomorrow = strtotime('tomorrow midnight');

        // временная метка для настоящего времени
        $now = time();

        // далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
        $lot_time_remaining = date("H:i", $tomorrow + ($tomorrow - $now));

        $lots = Lot::selectAll();

        View::render('home/index.php',[
            'user' => $user,
            'lots' => $lots,
            'categories' => $categories,
            'lot_time_remaining' => $lot_time_remaining
        ]);

    }

}