--получить список из всех категорий;
select name
from categories;

--получить самые новые, открытые лоты.
--Каждый лот должен включать название, стартовую цену,
--ссылку на изображение, цену, количество ставок, название категории;
select    lots.id,
					lots.name,
          lots.start_price,
          lots.pic,
          categories.name,
          max(stakes.stake_sum),
					count(stakes.id)
from      lots
          inner join categories
					on lots.category_id = categories.id
          left join stakes
					on stakes.lot_id = lots.id
where			lots.winner_id is NULL
group by	lots.id
order by  lots.id desc
limit     2;

--этот ваниант оставлю
select    lots.name,
          lots.start_price,
          lots.pic,
          categories.name,
          max_lots.*
from      lots
          left join categories
					on lots.category_id = categories.id
					and lots.winner_id is NULL
          left join (
						select		lot_id,max(stake_sum),count(id)
						from			stakes
						group by	lot_id
					) max_lots
					on max_lots.lot_id = lots.id
order by  lots.created_at desc
limit     2;

--найти лот по его названию или описанию;
select  *
from    lots
where   name = "search_string"
        or description = "search_string";

--добавить новый лот (все данные из формы добавления);
insert into lots
(
`pic`,
`name`,
`description`,
`start_price`,
`end_date`,
`stake_step`,
`num_likes`,
`author_id`,
`winner_id`,
`category_id`,
)
VALUES (
'path',
'name',
'описание',
1000,
'3523452345',
100,
0,
1,
2,
3
);

--обновить название лота по его идентификатору;
update lots set name='new name' where id = 23;


--добавить новую ставку для лота;
insert into stakes
(
`stake_sum`,
`user_id`,
`lot_id`,
)
VALUES (
1000,
23,
32
);


--получить список ставок для лота по его идентификатору.
select *
from stakes
where lot_id = 34;

