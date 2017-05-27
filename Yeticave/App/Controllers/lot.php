<?php

namespace Yeticave\App\Controllers;

use Yeticave\Core\View;
use Yeticave\Core\User;
use Yeticave\Core\Controller;
use Yeticave\Core\ActiveRecord\Finder\LotFinder;
use Yeticave\Core\ActiveRecord\Record\StakeRecord;
use Yeticave\Core\ActiveRecord\Record\LotRecord;
use Yeticave\App\Models\Categories;
use Yeticave\App\Models\Stakes;
use Respect\Validation\Validator as v;

class Lot extends Controller
{

    public function showLotByIdAction()
    {

        $categories = Categories::selectAll();

        $user = new User('Db');

        $lot_id = $this->route_params['id'];

        $lot = LotFinder::findById($lot_id);

        if (!$lot) {
            header('HTTP/1.1 404 Not Found');
            View::render('home/error.php',[
                'categories' => $categories,
                'user' => $user,
                'message' => '<p>Запрошенного лота не существует! <a href="/">На главную</a></p>'
            ]);
            die();
        }

        $form_validated = true;

        if (!empty($_POST)) {

            $fields = [
                "lot_id" => ['v' => v::intVal()->notEmpty()->positive()->setName('category') ],
                "cost" =>   ['v' => v::floatVal()->notEmpty()->positive()->setName('lot-rate') ],
            ];

            $this->validateFormFields($fields,$form_validated);

        }

        if (!empty($_POST) && $form_validated) {

            $lot = LotFinder::findById($fields['lot_id']['value']);

            $new_stake = new StakeRecord('Yeticave\Core\Db',[
                'stake_sum' => $fields['cost']['value'],
                'user_id'   => $user->getUserId(),
                'lot_id'    => $fields['lot_id']['value']
            ],true);

            $new_stake_id = $new_stake->save();

        }

        if (isset($lot) && $lot !== false) {

            // ставки пользователей, которыми надо заполнить таблицу
            $stakes = Stakes::selectByLotId((isset($lot_id)) ? $lot_id : $fields['lot_id']['value']);

            $have_stake = false;

            if ($stakes) {
                foreach ($stakes as $stake) {
                    if ($stake['user_id'] == $user->getUserId()) {
                        $have_stake = true;
                        break;
                    }
                }
            } else {
                $stakes = [];
            }

            View::render('lot/lot.php',[
                'stakes' => $stakes,
                'lot' => $lot,
                'fields' => $fields,
                'have_stake' => $have_stake,
                'categories' => $categories,
                'user' => $user
            ]);

        } else {

            View::render('lot/error.php',[
                'categories' => $categories,
                'user' => $user
            ]);


        }

    }

    public function addAction()
    {

        $categories = Categories::selectAll();

        $user = new User('Db');

        if (!$user->isLoggedIn()) {
            header("HTTP/1.1 403 Forbidden");
            View::render('home/error.php',[
                'categories' => $categories,
                'user' => $user,
                'message' => '<p>Страница доступна ТОЛЬКО для зарегистрированных пользователей! <a href="/">На главную</a></p>'
            ]);
            die();
        }

        $form_validated = true;

        if (!empty($_POST)) {

            $fields = [
                "lot-name" =>   ['v' => v::stringType()->length(5,100)->notEmpty()->setName('lot-name') ],
                "category" =>   ['v' => v::intVal()->notEmpty()->positive()->setName('category') ],
                "message" =>    ['v' => v::stringType()->length(5,1000)->notEmpty()->setName('message') ],
                "lot-rate" =>   ['v' => v::floatVal()->notEmpty()->positive()->setName('lot-rate') ],
                "lot-step" =>   ['v' => v::floatVal()->notEmpty()->positive()->setName('lot-step') ],
                "lot-date" =>   ['v' => v::date('d.m.Y')->notEmpty()->setName('lot-date') ],
            ];

            $this->validateFormFields($fields,$form_validated);

            $file = [];

            $this->validatePhotoUpload($file,$form_validated);

        }

        if (!empty($_POST) && $form_validated) {

            $dtime = \DateTime::createFromFormat("d.m.Y", $fields['lot-date']['value']);
            $timestamp = $dtime->format("Y-m-d H:i:s");

            $new_lot = new LotRecord('Yeticave\Core\Db',[
                'pic'           => '../uploads/' . $file['name'],
                'name'          => $fields['lot-name']['value'],
                'description'   => $fields['message']['value'],
                'start_price'   => (float)$fields['lot-rate']['value'],
                'end_date'      => $timestamp,
                'stake_step'    => (float)$fields['lot-step']['value'],
                'author_id'     => $user->getUserId(),
                'category_id'   => $fields['category']['value']
            ],true);

            $new_lot_id = $new_lot->save();

            if ($new_lot_id) {

                header("Location: /lot/" . $new_lot_id);
                exit();

            } else {

                View::render('home/error.php',[
                    'categories' => $categories,
                    'user' => $user,
                    'message' => '<p>Ошибка при обработке формы! <a href="/">На главную</a></p>'
                ]);

            }

        } else {

            View::render('lot/add.php',[
                'categories' => $categories,
                'form_validated' => $form_validated,
                'fields' => isset($fields) ? $fields : null,
                'file' => isset($file) ? $file : null,
                'user' => $user
            ]);

        }

    }

}