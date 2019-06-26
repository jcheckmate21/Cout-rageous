-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Apr 28, 2017 at 02:20 PM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `demo`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  -- `qualification` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
DELIMITER $$

DROP PROCEDURE IF EXISTS upgrade_database_1_0_to_2_0 $$
CREATE PROCEDURE upgrade_database_1_0_to_2_0()
BEGIN

-- rename a table safely
IF NOT EXISTS( (SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE()
        AND TABLE_NAME='my_old_table_name') ) THEN
    RENAME TABLE 
        my_old_table_name TO my_new_table_name,
END IF;

-- add a column safely
IF NOT EXISTS( (SELECT * FROM information_schema.COLUMNS WHERE TABLE_SCHEMA=DATABASE()
        AND COLUMN_NAME='my_additional_column' AND TABLE_NAME='my_table_name') ) THEN
    ALTER TABLE my_table_name ADD my_additional_column varchar(2048) NOT NULL DEFAULT '';
END IF;

END $$

CALL upgrade_database_1_0_to_2_0() $$

DELIMITER ;






--Add a column--
ALTER TABLE users 
ADD COLUMN position VARCHAR(15) AFTER id;



--add record--
UPDATE `users` SET `position` = 'admin' WHERE `users`.`id` = 1;


--insert rows into  table.--
INSERT INTO users(name,phone,vendor_group)
VALUES('IBM','(408)-298-2987',1);
 
INSERT INTO users(name,phone,vendor_group)
VALUES('Microsoft','(408)-298-2988',1);

--delete record from table
DELETE FROM `movies` WHERE `movie_id` = 18;





--Create Students Table----------
CREATE TABLE IF NOT EXISTS `students` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `anumber` varchar(25) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `major` varchar(255) NOT NULL,
  `classification` varchar(255) NOT NULL,
  `crn` int(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  UNIQUE (`anumber`)
) ENGINE=InnoDB DEFAULT   ;