INSERT INTO Categories (slug, name)
VALUES ('boards', 'Доски и лыжи'),
       ('attachment', 'Крепления'),
       ('boots', 'Ботинки'),
       ('clothing', 'Одежда'),
       ('tools', 'Инструменты'),
       ('other', 'Разное');
INSERT INTO USER (email, name, password)
VALUES ('user1@gmail.com', 'user1', '12345678'),
       ('admin@yeticave.ru', 'admin', 'admin');
INSERT INTO LOT (name, img, start_price, categories_id, user_id)
VALUES ('2014 Rossignol District Snowboard', 'img/lot-1.jpg', '10999', 1, 1),
       ('DC Ply Mens 2016/2017 Snowboard', 'img/lot-2.jpg', '159999', 1, 1),
       ('Крепления Union Contact Pro 2015 года размер L/XL', 'img/lot-3.jpg', '8000', 2, 1),
       ('Ботинки для сноуборда DC Mutiny Charocal', 'img/lot-4.jpg', '10999', 3, 1),
       ('Куртка для сноуборда DC Mutiny Charocal', 'img/lot-5.jpg', '7500', 4, 2),
       ('Маска Oakley Canopy', 'img/lot-6.jpg', '5400', 6, 2);
INSERT INTO BET (price, lot_id, user_id)
VALUES (11500, 1, 2),
       (8500, 3, 1);

/*  получить все категории */
SELECT *
FROM Categories;

/*
Получить самые новые, открытые лоты.
Каждый лот должен включать название, стартовую цену,
ссылку на изображение, цену, название категории;
 */
SELECT l.name, start_price, img, c.name
FROM Lot l
         JOIN Categories c ON l.categories_id = c.id
WHERE l.dt_over IS NULL
ORDER BY l.dt_add DESC;

/* Показать лот по его id. Получите также название категории, к которой принадлежит лот; */
SELECT *
FROM Lot l
         JOIN Categories c ON l.categories_id = c.id
WHERE l.id = 1;

/*Обновить название лота по его идентификатору;*/
UPDATE Lot
SET name = 'Маска Oakley Canopy v.2'
WHERE id = '6';

/*Получить список самых свежих ставок для лота по его идентификатору.*/
SELECT lot_id, l.NAME, price
FROM Bet b
         JOIN lot l ON b.lot_id = l.id
WHERE l.id = 3
ORDER BY l.dt_add DESC;
