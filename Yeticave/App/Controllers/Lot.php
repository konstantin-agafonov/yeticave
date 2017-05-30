<?php

namespace Yeticave\App\Controllers;

use Yeticave\Core\ActiveRecord\Finder\StakeFinder;
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
        $user = new User('Db', false);
        $lot_id = $this->route_params['id'];
        $lot = LotFinder::findById($lot_id);
        $fields = [];

        if (!$lot) {
            header('HTTP/1.1 404 Not Found');
            return $this->render('home/message.php', [
                'categories' => $categories,
                'user' => $user,
                'message' => '<p>Запрошенного лота не существует! <a href="/">На главную</a></p>'
            ]);
        }

        // ставки пользователей, которыми надо заполнить таблицу
        $stakes = Stakes::selectByLotId($lot->id_Field);

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

        return $this->render('lot/lot.php', [
            'stakes' => $stakes,
            'lot' => $lot,
            'fields' => $fields,
            'have_stake' => $have_stake,
            'categories' => $categories,
            'user' => $user
        ]);
    }

    public function newStakeAction()
    {
        $categories = Categories::selectAll();

        $user = new User('Db', false);
        if (!$user->isLoggedIn()) {
            return $this->render('home/message.php', [
                'categories' => Categories::selectAll(),
                'user' => $user,
                'message' =>
                    '<p>Страница доступна только для зарегистрированных пользователей!
После входа для добавления ставки зайдите на страницу соответствующего лота! <a href="/users/login">Вход</a></p>'
            ]);
        }

        $form_validated = true;

        $fields = [
            "lot_id" => [
                'v' => v::intVal()->notEmpty()->positive()->setName('category'),
                'value' => null,
                'errors' => []
            ],
            "cost" =>   [
                'v' => v::floatVal()->notEmpty()->positive()->setName('lot-rate'),
                'value' => null,
                'errors' => []
            ],
        ];

        if (!empty($_POST)) {
            $this->validateFormFields($fields, $form_validated);
        } else {
            return $this->render('home/message.php', [
                'categories' => Categories::selectAll(),
                'user' => $user,
                'message' =>
                    '<p>Для добавления ставки зайдите на страницу соответствующего лота! <a href="/">На главную</a></p>'
            ]);
        }

        $lot = null;

        if (empty($fields['lot_id']['errors'])) {
            $lot = LotFinder::findById($fields['lot_id']['value']);
            if (!$lot) {
                return $this->render('home/message.php', [
                    'categories' => Categories::selectAll(),
                    'user' => $user,
                    'message' => '<p>Указанного в поле формы lot_id лота не существует! <a href="/">На главную</a></p>'
                ]);
            }
        }

        $min_possible_stake_sum = null;
        $max_lot_stake = null;

        if (empty($fields['cost']['errors'])) {
            $max_lot_stake = StakeFinder::maxByLotId($lot->id_Field);
            if ($max_lot_stake) {
                $min_possible_stake_sum = $max_lot_stake->stake_sum_Field + $lot->stake_step_Field;
            } else {
                $min_possible_stake_sum = $lot->start_price_Field + $lot->stake_step_Field;
            }
            if ($min_possible_stake_sum > $fields['cost']['value']) {
                $fields['cost']['errors'][] = "Сумма новой ставки должна быть не менее $min_possible_stake_sum рублей!";
                $form_validated = false;
            }
        }

        if ($form_validated) {
            $new_stake = new StakeRecord('Yeticave\Core\Db', [
                'stake_sum' => $fields['cost']['value'],
                'user_id'   => $user->getUserId(),
                'lot_id'    => $fields['lot_id']['value']
            ], true);
            $new_stake_id = $new_stake->save();
            if ($new_stake_id) {
                header("Location: /lot/" . $lot->id_Field);
                die();
            }
        }

        // ставки пользователей, которыми надо заполнить таблицу
        $stakes = Stakes::selectByLotId($lot->id_Field);
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

        return $this->render('lot/lot.php', [
            'stakes' => $stakes,
            'lot' => $lot,
            'fields' => $fields,
            'have_stake' => $have_stake,
            'categories' => $categories,
            'user' => $user
        ]);
    }

    public function addAction()
    {
        $categories = Categories::selectAll();

        $user = new User('Db', false);

        if (!$user->isLoggedIn()) {
            header("HTTP/1.1 403 Forbidden");
            return $this->render('home/message.php', [
                'categories' => $categories,
                'user' => $user,
                'message' =>
                    '<p>Страница доступна ТОЛЬКО для зарегистрированных пользователей! <a href="/">На главную</a></p>'
            ]);
        }

        $form_validated = true;
        $file = [
            'error' => null
        ];
        $fields = [
            "lot-name" =>   [
                'v' => v::stringType()->length(5,100)->notEmpty()->setName('lot-name'),
                'value' => null,
                'errors' => []
            ],
            "category" =>   [
                'v' => v::intVal()->notEmpty()->positive()->setName('category'),
                'value' => null,
                'errors' => []
            ],
            "message" =>    [
                'v' => v::stringType()->length(5,1000)->notEmpty()->setName('message'),
                'value' => null,
                'errors' => []
            ],
            "lot-rate" =>   [
                'v' => v::floatVal()->notEmpty()->positive()->setName('lot-rate'),
                'value' => null,
                'errors' => []
            ],
            "lot-step" =>   [
                'v' => v::floatVal()->notEmpty()->positive()->setName('lot-step'),
                'value' => null,
                'errors' => []
            ],
            "lot-date" =>   [
                'v' => v::date('d.m.Y')->notEmpty()->setName('lot-date'),
                'value' => null,
                'errors' => []
            ],
        ];

        if (!empty($_POST)) {
            $this->validateFormFields($fields, $form_validated);
            $this->validatePhotoUpload($file, $form_validated, true);
        }

        if (!empty($_POST) && $form_validated) {
            $dtime = \DateTime::createFromFormat("d.m.Y", $fields['lot-date']['value']);
            $timestamp = $dtime->format("Y-m-d H:i:s");

            $new_lot = new LotRecord('Yeticave\Core\Db', [
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
                return null;
            } else {
                return $this->render('home/message.php', [
                    'categories' => $categories,
                    'user' => $user,
                    'message' => '<p>Ошибка при обработке формы! <a href="/">На главную</a></p>'
                ]);
            }
        } else {
            return $this->render('lot/add.php', [
                'categories' => $categories,
                'form_validated' => $form_validated,
                'fields' => $fields,
                'file' => $file,
                'user' => $user
            ]);
        }
    }

    public function showLotsByCategoryIdAction()
    {
        $user = new User('Db', false);
        $categories = Categories::selectAll();
        $lot_time_remaining = lotTimeRemaining();
        $category_id = $this->route_params['id'];
        $lots = \Yeticave\App\Models\Lot::selectByCategoryId($category_id);

        return $this->render('home/index.php', [
            'user' => $user,
            'lots' => $lots,
            'categories' => $categories,
            'lot_time_remaining' => $lot_time_remaining,
            'category_id' => $category_id
        ]);
    }
}
