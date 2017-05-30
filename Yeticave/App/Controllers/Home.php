<?php

namespace Yeticave\App\Controllers;

use Yeticave\App\Services\WinnerService;
use Yeticave\Core\{User, Controller};
use Yeticave\App\Models\Categories;
use Yeticave\App\Models\Lot;

class Home extends Controller
{
    public function indexAction()
    {
        WinnerService::calculateWinners();

        $user = new User('Db',false);

        $categories = Categories::selectAll();

        $lot_time_remaining = lotTimeRemaining();

        $lots = Lot::selectAll();

        $category_id = null;

        return $this->render('home/index.php',[
            'user' => $user,
            'lots' => $lots,
            'categories' => $categories,
            'lot_time_remaining' => $lot_time_remaining,
            'category_id' => $category_id
        ]);
    }

    public function searchAction()
    {
        $user = new User('Db',false);

        $categories = Categories::selectAll();

        $lot_time_remaining = lotTimeRemaining();

        if ($this->route_params['searchstring']) {

            $lots = Lot::searchBySubstring($this->route_params['searchstring']);

            $category_id = null;

            if ($lots) {
                return $this->render('home/index.php',[
                    'user' => $user,
                    'lots' => $lots,
                    'categories' => $categories,
                    'lot_time_remaining' => $lot_time_remaining,
                    'category_id' => $category_id
                ]);
            } else {
                header('HTTP/1.1 404 Not Found');
                return $this->render('home/message.php',[
                    'categories' => $categories,
                    'user' => $user,
                    'message' => '<p>Лотов по запросу <strong>'
                        . htmlspecialchars($this->route_params['searchstring'])
                        . '</strong> не найдено! <a href="/">На главную</a></p>'
                ]);
            }
        } else {
            header('HTTP/1.1 404 Not Found');
            return $this->render('home/message.php',[
                'categories' => $categories,
                'user' => $user,
                'message' => '<p>Строка поиска не может быть пустой! <a href="/">На главную</a></p>'
            ]);
        }
    }

    public function searchSuggestAction()
    {
        if ($this->route_params['searchstring']) {

            $lots = Lot::searchSuggest($this->route_params['searchstring']);

            if ($lots) {

                $result = [];
                foreach ($lots as $lot) {
                    $result[] = $lot['name'];
                }

                header("Content-type: application/json");
                return json_encode($result,JSON_PRETTY_PRINT);
            }
        }
    }

}