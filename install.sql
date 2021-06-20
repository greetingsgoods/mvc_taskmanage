--
-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.3.358.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 20.06.2021 19:15:57
-- Версия клиента: 4.1
--


--
-- Отключение внешних ключей
--
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

--
-- Установить режим SQL (SQL mode)
--
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

--
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

--
-- Установка базы данных по умолчанию
--
-- USE testw_2006;

--
-- Описание для таблицы local_logins
--
DROP TABLE IF EXISTS local_logins;
CREATE TABLE IF NOT EXISTS local_logins (
  id INT(11) NOT NULL AUTO_INCREMENT,
  token VARCHAR(256) DEFAULT NULL,
  userid INT(11) DEFAULT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 13
AVG_ROW_LENGTH = 2340
CHARACTER SET utf8
COLLATE utf8_unicode_ci
ROW_FORMAT = DYNAMIC;

--
-- Описание для таблицы local_tasks
--
DROP TABLE IF EXISTS local_tasks;
CREATE TABLE IF NOT EXISTS local_tasks (
  id INT(11) NOT NULL AUTO_INCREMENT,
  userid INT(11) DEFAULT NULL,
  username VARCHAR(255) DEFAULT NULL,
  `e-mail` VARCHAR(254) DEFAULT NULL,
  text VARCHAR(2000) DEFAULT NULL,
  taskend TINYINT(1) DEFAULT 0,
  PRIMARY KEY (id),
  INDEX userid (userid)
)
ENGINE = INNODB
AUTO_INCREMENT = 33
AVG_ROW_LENGTH = 1638
CHARACTER SET utf8
COLLATE utf8_unicode_ci
ROW_FORMAT = DYNAMIC;

--
-- Описание для таблицы local_users
--
DROP TABLE IF EXISTS local_users;
CREATE TABLE IF NOT EXISTS local_users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(20) DEFAULT NULL,
  hash VARCHAR(255) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE INDEX name (name)
)
ENGINE = INNODB
AUTO_INCREMENT = 21
AVG_ROW_LENGTH = 4096
CHARACTER SET utf8
COLLATE utf8_unicode_ci
ROW_FORMAT = DYNAMIC;

--
-- Вывод данных для таблицы local_logins
--
INSERT INTO local_logins VALUES
(10, 'a1752ea8e4fc029406a7b107dea19e06d829ce14b0b9b7f283c381e430d1d60a', 19),
(11, '685028c0a9e22bc9df82c554b5df1905e6cc4458f4efb8a41d967366014d6541', 20),
(12, '5e33f8c2efda8685dc9655581e7372ad89e2c50eb1cf153e8683ac653db7e236', 18);

--
-- Вывод данных для таблицы local_tasks
--
INSERT INTO local_tasks VALUES
(25, 17, 'Guest', NULL, NULL, 0),
(26, 17, 'Guest', NULL, 'task 26 is complete', 1),
(27, 17, 'Guest', NULL, NULL, 0),
(28, 19, 'user10', NULL, NULL, 0),
(29, 19, 'user10', NULL, NULL, 0),
(30, 20, 'user100', NULL, NULL, 0),
(31, 20, 'user100', NULL, 'task 30 is finalty', 1),
(32, 18, 'admin', NULL, NULL, 0);

--
-- Вывод данных для таблицы local_users
--
INSERT INTO local_users VALUES
(17, 'Guest', 'guest hash - inaccessable user'),
(18, 'admin', '$2y$10$td8bmZ.dC9P026zWoFv0kerGJNf86ZauoWN3d6Y6UkkHZJD/gXNBy'),
(19, 'user10', '$2y$10$DTrrqsr7w.lORJ6Fi9xGKOPHyo.atx.C9FdVo4Im.qxl0ixHBHFta'),
(20, 'user100', '$2y$10$102a4p8bZYYpKretzkbffOAQ5gzPg7WGlZ7G.dMWaZ/1AC9SY/Ylq');

--
-- Восстановить предыдущий режим SQL (SQL mode)
--
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

--
-- Включение внешних ключей
--
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
