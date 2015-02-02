-- phpMyAdmin SQL Dump
-- version 3.5.6
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 02 2015 г., 19:42
-- Версия сервера: 5.1.67-community-log
-- Версия PHP: 5.4.11

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `laravel`
--

-- --------------------------------------------------------

--
-- Структура таблицы `shake_files`
--

CREATE TABLE IF NOT EXISTS `shake_files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `file` varchar(255) DEFAULT NULL,
  `parent_id` int(11) NOT NULL,
  `parent_type` varchar(255) NOT NULL,
  `field` varchar(255) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `field` (`field`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=52 ;

--
-- Дамп данных таблицы `shake_files`
--

INSERT INTO `shake_files` (`id`, `file`, `parent_id`, `parent_type`, `field`, `updated_at`, `created_at`) VALUES
(37, '/upload/files/test.rar', 7, 'Page', 'images', '2014-10-21 18:11:12', '2014-10-21 18:11:12'),
(38, '/upload/images/test.png', 7, 'Page', 'images', '2014-10-21 18:11:12', '2014-10-21 18:11:12'),
(39, '/upload/files/test_1.rar', 7, 'Page', 'images', '2014-10-21 18:11:20', '2014-10-21 18:11:20'),
(41, '/upload/images/test_1.png', 7, 'Page', 'images', '2014-10-23 15:58:56', '2014-10-23 15:58:56'),
(50, '/upload/images/test_3.png', 7, 'Page', 'test', '2014-11-03 14:39:35', '2014-11-03 14:39:35'),
(51, '/upload/images/image1.png', 0, '', 'images', '2015-01-26 11:38:50', '2015-01-26 11:38:50');

-- --------------------------------------------------------

--
-- Структура таблицы `shake_pages`
--

CREATE TABLE IF NOT EXISTS `shake_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `template` varchar(255) NOT NULL,
  `page_id` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `position` int(11) NOT NULL,
  `file` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `page_id` (`page_id`),
  KEY `position` (`position`),
  KEY `slug` (`slug`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `shake_pages`
--

INSERT INTO `shake_pages` (`id`, `active`, `slug`, `title`, `content`, `template`, `page_id`, `updated_at`, `created_at`, `position`, `file`) VALUES
(1, 1, 'pervaya-stranica', 'Первая страница', '<p>Эта страница посвящается всем кто делаем свою CMS!</p>\r\n', '', 8, '2014-10-25 13:34:27', '2014-06-22 05:20:21', 1, NULL),
(2, 1, 'asdfasdf-asdf-asdf-ads', '1234123412341', '<p>2341234123412341</p>\r\n', '', 6, '2014-10-25 13:34:40', '2014-06-22 05:42:51', 1, NULL),
(3, 1, 'hjkhgkgjhk', '1234123412341', '<p>2341234123412341</p>\r\n', '', 0, '2014-10-25 13:34:59', '2014-06-22 05:43:01', 4, NULL),
(4, 1, 'erer-qer-qwer', '1234123412341', '<p>2341234123412341</p>\r\n', '', 2, '2014-10-25 13:34:48', '2014-06-22 05:43:36', 1, NULL),
(5, 0, 'fa-sdf-asdf-asdf', '1234123412341', '<p>2341234123412341</p>\r\n', '', 0, '2014-10-25 13:34:52', '2014-06-22 06:24:33', 2, NULL),
(6, 0, '1234123412341', '1234123412341', '<p>2341234123412341</p>\r\n', '', 0, '2014-10-25 13:34:32', '2014-06-26 18:08:51', 1, NULL),
(7, 1, 'stranica-dlya-testirovaniya', 'Страница для тестирования', '<p>Текст который содержит текст</p>\r\n', 'second', 0, '2014-11-04 07:52:16', '2014-06-26 18:12:43', 0, NULL),
(8, 0, 'icukicukicukicuk', 'йцукйцукйцукйцук', '<p>йцукйцукйцукйцук</p>\r\n', 'default', 7, '2014-11-04 07:52:20', '2014-06-26 18:36:58', 1, NULL),
(9, 1, 'wqeqweqweqwe', 'wqeqweqweqwe', '<p>qweqweqweqwe</p>\r\n', '', 8, '2014-10-25 13:34:22', '2014-06-26 18:37:50', 0, NULL),
(10, 1, 'zqzqzqzq', 'zqzqzqzq', '<p>zqzqzqzqzq</p>\r\n', '', 2, '2014-10-25 13:34:43', '2014-06-26 18:43:33', 0, NULL),
(11, 0, 'iopiopiopiop', 'iopiopiopiop', '<p>iopiopiopiopiopiopiopiopiopiopiop</p>\r\n', '', 0, '2014-10-25 13:34:55', '2014-06-26 18:47:19', 3, NULL),
(12, 1, 'eshche-odna-stranica', 'Еще одна страница', '<p>хз что тут написать</p>\r\n', '', 0, '2014-10-25 13:35:01', '2014-09-28 05:42:41', 6, NULL),
(13, 1, 'uzhe-vtoraya-stranica', 'Уже вторая страница', '<p>ААААААА чо писать то епта</p>\r\n', '', 0, '2014-10-25 13:35:04', '2014-09-28 06:02:50', 7, NULL),
(14, 1, 'testiruem-novyi-funkcional', 'Тестируем новый функционал', '<p>Тест прошел успешно</p>\r\n', '', 0, '2014-10-25 13:35:06', '2014-09-28 09:04:22', 8, NULL),
(15, 1, 'testovaya-stranica-2', 'Тестовая страница 2', '<p>что это за бред ты тут написал?</p>\r\n', '', 0, '2014-10-25 13:24:04', '2014-10-25 13:23:27', 0, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `shake_users`
--

CREATE TABLE IF NOT EXISTS `shake_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `active` tinyint(1) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `group` int(11) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `updated_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `shake_users`
--

INSERT INTO `shake_users` (`id`, `active`, `email`, `password`, `group`, `remember_token`, `updated_at`, `created_at`) VALUES
(1, 1, 'test@test.ru', '$2y$10$As6v9LOsscemc1MvyTIbSu8cm9sKCpTtx0prUWuir60RrJK3.2lx.', 1, 'CRmQNuaoZDAc31fqYPOt134VhrBx0ufTpdbpMUSRgmkWwn1Jf4d2H1qij13p', '2014-10-25 13:43:19', '2014-07-18 11:48:07'),
(2, 1, 'asd@asd.ru', '$2y$10$zbpavwZ0rADr9pW2Mp3XOeXx7ssJIPJvRQN78T1frGvFQDxRsFfTC', 2, NULL, '2014-11-04 07:32:33', '2014-07-29 17:57:28'),
(3, 1, 'asdqwesda@asd.ru', '$2y$10$g5JvyP0xyYGCTqGcJrQVtegTjaaL68cGxq9rU75Hkg9PuVexDcQQG', 0, NULL, '2014-10-25 15:32:23', '2014-07-29 17:58:03'),
(4, 1, 'zxc@zxc.ru', 'asidsfoadso', 0, NULL, '2014-10-21 06:17:13', '2014-07-29 17:59:08'),
(7, 1, 'asdfasdfasdf@asdfasdfasdf.ru', '$2y$10$7Jv1i03M2ZLVcAYXOhDIyuOGceTr/jU2sVmws0nZqFAXxrBN/Eh7q', 0, 'tm0FqDswFl5yR75h6FOLxLbSaZ2NydXNw3r4jwrHgyna9dMspBGK67nQqN3H', '2014-10-21 06:17:13', '2014-09-28 06:00:12'),
(8, 0, 'top@top.ru', '$2y$10$IB.ApjKM18C9Nky1iCcAYOSVBW0if9243wKIR8/r6M1NFSsYLwzyW', 0, 'YiJ7LlrJS3e3AA5b4GbpfQNnO4ZEE10smFLSPbySvvpCiOF1Mz3NoH4BCkm4', '2014-09-28 06:01:55', '2014-09-28 06:01:02'),
(10, 0, 'qwerwer@qewrqwer.ru', '$2y$10$yYM9zlkoD7RbpHXgrLADe.bCZqEQtVaCw/qxOty/wT8C8p0KIaKKW', 0, NULL, '2014-10-09 14:17:48', '2014-10-09 14:15:15');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
