insert into categories
(name)
VALUES
('Доски и лыжи'),
('Крепления'),
('Ботинки'),
('Одежда'),
('Инструменты'),
('Разное');

insert into users
(email,name,password)
VALUES
('ignat.v@gmail.com','Игнат','$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka'),
('kitty_93@li.ru','Леночка','$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa'),
('warrior07@mail.ru','Руслан','$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW')

insert into lots
(name,category_id,start_price,pic,end_date,stake_step,author_id)
VALUES
('2014 Rossignol District Snowboard',1,10999,'../img/lot-1.jpg',NOW() + INTERVAL 1 DAY,100,1),
('DC Ply Mens 2016/2017 Snowboard',1,159999,'../img/lot-2.jpg',NOW() + INTERVAL 3 DAY,100,1),
('Крепления Union Contact Pro 2015 года размер L/XL',2,8000,'../img/lot-3.jpg',NOW() + INTERVAL 4 DAY,100,2),
('Ботинки для сноуборда DC Mutiny Charocal',3,10999,'../img/lot-4.jpg',NOW() + INTERVAL 2 DAY,100,2),
('Куртка для сноуборда DC Mutiny Charocal',4,7500,'../img/lot-5.jpg',NOW() + INTERVAL 7 DAY,100,3),
('Маска Oakley Canopy',6,5400,'../img/lot-6.jpg',NOW() + INTERVAL 6 DAY,100,3);

insert into stakes
(stake_sum,user_id,lot_id)
VALUES
(12000,1,6),
(13000,2,6),
(14000,1,4),
(15000,3,4);
