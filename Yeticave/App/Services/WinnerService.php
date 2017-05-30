<?php

namespace Yeticave\App\Services;

use Yeticave\Core\Db;
use Yeticave\Core\Services\BaseService;

class WinnerService extends BaseService {

    public static function calculateWinners() {
        $wins = Db::select(
<<< EOD
select          lots.id,
				lots.name,
				stakes.stake_sum,
				winners.id as winner_id,
				winners.name as winner_name,
				winners.email as winner_email,
				AUTHORS.email as author_email
from		    lots
				LEFT JOIN stakes on lots.id = stakes.lot_id
				left join users as winners on stakes.user_id = winners.id
				left join users as authors on lots.author_id = authors.id
where		    ISNULL(winner_id)
				and DATEDIFF(NOW(),lots.end_date) >= 0
				and (stakes.stake_sum,lots.id) in 
				(select max(stake_sum),lot_id
				from stakes
				GROUP BY lot_id);
EOD
        );

        /*$transport = (new \Swift_SmtpTransport(SMTP_HOST,SMTP_PORT,'SSL'))
            ->setUsername(SMTP_USER)
            ->setPassword(SMTP_PASS);
        $mailer = new \Swift_Mailer($transport);*/

        foreach ($wins as $win) {

            /*Db::update('lots',['winner_id' => $win['winner_id']],['id' => $win['id']]);*/

            /*$message = new \Swift_Message();
            $message->setTo([$win['winner_email'] => $win['winner_name']]);
            $message->setSubject('Вы победитель!');
            $message->setBody("Вы победитель по лоту {$win['name']}!");
            $message->setFrom(['info@yeticave.ru'=>'Yeticave']);
            $mailer->send($message);*/
        }
    }

}