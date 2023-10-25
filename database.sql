CREATE DATABASE IF NOT EXISTS `monkey`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `monkey`.`login` (
  `username` TEXT NOT NULL,
  `password` TEXT NOT NULL,
  `salt1` TEXT NOT NULL,
  `salt2` TEXT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `monkey`.`forms` ( 
  `form_id` INT(12) NOT NULL AUTO_INCREMENT,
  `creator_username` TEXT NOT NULL,
  `title` TEXT NOT NULL,
  `description` TEXT NOT NULL,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified_date` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` TEXT NOT NULL,
  `form_url` TEXT NOT NULL,
  `response_count` INT NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;