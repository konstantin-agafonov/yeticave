<?php

namespace Yeticave\App\Controllers;

use Yeticave\Core\View;
use Yeticave\Core\User;
use Yeticave\Core\Controller;
use Yeticave\Core\Db;
use Yeticave\App\Models\Categories;
use Yeticave\App\Models\Lot;

class Home extends Controller
{

    public function indexAction()
    {
        $user = new User('Db');

        $categories = Categories::selectAll();

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

    public function searchAction()
    {
        $user = new User('Db');

        $categories = Categories::selectAll();

        // временная метка для полночи следующего дня
        $tomorrow = strtotime('tomorrow midnight');

        // временная метка для настоящего времени
        $now = time();

        // далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
        $lot_time_remaining = date("H:i", $tomorrow + ($tomorrow - $now));

        if ($this->route_params['searchstring']) {

            $lots = Lot::searchBySubstring($this->route_params['searchstring']);

            If ($lots) {

                View::render('home/index.php',[
                    'user' => $user,
                    'lots' => $lots,
                    'categories' => $categories,
                    'lot_time_remaining' => $lot_time_remaining
                ]);

            } else {

                header('HTTP/1.1 404 Not Found');
                View::render('home/error.php',[
                    'categories' => $categories,
                    'user' => $user,
                    'message' => '<p>Лотов по запросу <strong>'
                        . $this->route_params['searchstring']
                        . '</strong> не найдено! <a href="/">На главную</a></p>'
                ]);
                die();

            }

        } else {

            header('HTTP/1.1 404 Not Found');
            View::render('home/error.php',[
                'categories' => $categories,
                'user' => $user,
                'message' => '<p>Строка поиска не может быть пустой! <a href="/">На главную</a></p>'
            ]);
            die();

        }

    }

    public function searchSuggestAction()
    {
        if ($this->route_params['searchstring']) {

            $lots = Lot::searchSuggest($this->route_params['searchstring']);

            If ($lots) {

                $result = [];
                foreach ($lots as $lot) {
                    $result[] = $lot['name'];
                }

                header("Content-type: application/json");
                echo json_encode($result,JSON_PRETTY_PRINT);
                exit();

            }

        }

    }

}