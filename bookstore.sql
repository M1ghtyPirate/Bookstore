-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 22 2020 г., 14:36
-- Версия сервера: 5.7.25
-- Версия PHP: 7.1.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `bookstore`
--

-- --------------------------------------------------------

--
-- Структура таблицы `book`
--

CREATE TABLE `book` (
  `id_book` int(11) NOT NULL,
  `name_book` varchar(100) NOT NULL,
  `author` varchar(100) NOT NULL,
  `pages` int(11) NOT NULL,
  `year` year(4) NOT NULL,
  `publisher` varchar(100) NOT NULL,
  `price` int(11) NOT NULL,
  `id_genre` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `book`
--

INSERT INTO `book` (`id_book`, `name_book`, `author`, `pages`, `year`, `publisher`, `price`, `id_genre`) VALUES
(1, 'В финале Джон умрет', 'Дэвид Вонг', 512, 2012, 'АСТ', 410, 3),
(2, 'В этой книге полно пауков', 'Дэвид Вонг', 640, 2019, 'АСТ', 451, 3),
(3, 'Девять принцев Амбера', 'Роджер Желязны', 255, 2019, 'Эксмо', 327, 2),
(4, 'Ружья Авалона', 'Роджер Желязны', 288, 2019, 'Эксмо', 327, 2),
(5, 'Основание', 'Айзек Азимов', 304, 2003, 'Центрополиграф', 330, 1),
(6, 'Основание и империя', 'Айзек Азимов', 319, 2004, 'Центрополиграф', 330, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `buyer`
--

CREATE TABLE `buyer` (
  `id_buyer` int(11) NOT NULL,
  `name_buyer` varchar(100) NOT NULL,
  `phone` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `buyer`
--

INSERT INTO `buyer` (`id_buyer`, `name_buyer`, `phone`) VALUES
(1, 'Иванов Иван Иванович', '86584584554'),
(2, 'Сергеев Сергей Сергеевич', '86582541235'),
(3, 'Печкина Лидия Михайловна', '86584521356'),
(4, 'Тандырова Анастасия Петровна', '86584987858');

-- --------------------------------------------------------

--
-- Структура таблицы `genre`
--

CREATE TABLE `genre` (
  `id_genre` int(11) NOT NULL,
  `name_genre` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `genre`
--

INSERT INTO `genre` (`id_genre`, `name_genre`) VALUES
(1, 'Научная фантастика'),
(2, 'Фэнтези'),
(3, 'Литература ужасов');

-- --------------------------------------------------------

--
-- Структура таблицы `purchase`
--

CREATE TABLE `purchase` (
  `id_purchase` int(11) NOT NULL,
  `id_buyer` int(11) NOT NULL,
  `id_book` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `purchase`
--

INSERT INTO `purchase` (`id_purchase`, `id_buyer`, `id_book`, `date`) VALUES
(1, 1, 5, '2018-10-15'),
(2, 2, 3, '2019-09-20'),
(3, 3, 1, '2020-07-25'),
(4, 4, 4, '2020-03-13'),
(6, 1, 6, '2019-09-01');

-- --------------------------------------------------------

--
-- Дублирующая структура для представления `v_purchase`
-- (См. Ниже фактическое представление)
--
CREATE TABLE `v_purchase` (
`id_purchase` int(11)
,`id_buyer` int(11)
,`name_buyer` varchar(100)
,`id_book` int(11)
,`name_book` varchar(100)
,`author` varchar(100)
,`price` int(11)
,`date` date
);

-- --------------------------------------------------------

--
-- Структура для представления `v_purchase`
--
DROP TABLE IF EXISTS `v_purchase`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`%` SQL SECURITY DEFINER VIEW `v_purchase`  AS  select `purchase`.`id_purchase` AS `id_purchase`,`purchase`.`id_buyer` AS `id_buyer`,`buyer`.`name_buyer` AS `name_buyer`,`purchase`.`id_book` AS `id_book`,`book`.`name_book` AS `name_book`,`book`.`author` AS `author`,`book`.`price` AS `price`,`purchase`.`date` AS `date` from ((`purchase` join `book`) join `buyer`) where ((`purchase`.`id_book` = `book`.`id_book`) and (`purchase`.`id_buyer` = `buyer`.`id_buyer`)) ;

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`id_book`),
  ADD KEY `id_genre` (`id_genre`);

--
-- Индексы таблицы `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`id_buyer`);

--
-- Индексы таблицы `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id_genre`);

--
-- Индексы таблицы `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`id_purchase`),
  ADD KEY `id_buyer` (`id_buyer`),
  ADD KEY `id_book` (`id_book`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `book`
--
ALTER TABLE `book`
  MODIFY `id_book` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `buyer`
--
ALTER TABLE `buyer`
  MODIFY `id_buyer` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT для таблицы `genre`
--
ALTER TABLE `genre`
  MODIFY `id_genre` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `purchase`
--
ALTER TABLE `purchase`
  MODIFY `id_purchase` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `book`
--
ALTER TABLE `book`
  ADD CONSTRAINT `book_ibfk_1` FOREIGN KEY (`id_genre`) REFERENCES `genre` (`id_genre`);

--
-- Ограничения внешнего ключа таблицы `purchase`
--
ALTER TABLE `purchase`
  ADD CONSTRAINT `purchase_ibfk_1` FOREIGN KEY (`id_buyer`) REFERENCES `buyer` (`id_buyer`),
  ADD CONSTRAINT `purchase_ibfk_2` FOREIGN KEY (`id_book`) REFERENCES `book` (`id_book`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
