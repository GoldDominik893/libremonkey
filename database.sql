CREATE DATABASE IF NOT EXISTS `monkey`;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `monkey`.`login` (
  `user_id` INT(12) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(65535) NOT NULL,
  `password` VARCHAR(65535) NOT NULL,
  `salt1` TEXT NOT NULL,
  `salt2` TEXT NOT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `monkey`.`forms` ( 
  `form_id` INT(12) NOT NULL AUTO_INCREMENT,
  `creator_username` VARCHAR(65535) NOT NULL,
  `title` VARCHAR(65535) NOT NULL,
  `description` VARCHAR(65535) NOT NULL,
  `creation_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_modified_date` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` TEXT NOT NULL,
  `response_count` INT NOT NULL,
  PRIMARY KEY (`form_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `monkey`.`fields` (
  `field_id` INT(12) NOT NULL AUTO_INCREMENT,
  `form_id` INT(12) NOT NULL,
  `field_label` VARCHAR(65535) NOT NULL,
  `field_type` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`field_id`),
  FOREIGN KEY (`form_id`) REFERENCES `forms`(`form_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `monkey`.`responses` (
  `response_id` INT(12) NOT NULL AUTO_INCREMENT,
  `form_id` INT(12) NOT NULL,
  `user_id` INT(12) NOT NULL,
  `submitted_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`response_id`),
  FOREIGN KEY (`form_id`) REFERENCES `forms`(`form_id`) ON DELETE CASCADE,
  FOREIGN KEY (`user_id`) REFERENCES `login`(`user_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `monkey`.`response_data` (
  `response_id` INT(12) NOT NULL,
  `field_id` INT(12) NOT NULL,
  `user_input` TEXT NOT NULL,
  PRIMARY KEY (`response_id`, `field_id`),
  FOREIGN KEY (`response_id`) REFERENCES `responses`(`response_id`) ON DELETE CASCADE,
  FOREIGN KEY (`field_id`) REFERENCES `fields`(`field_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

COMMIT;