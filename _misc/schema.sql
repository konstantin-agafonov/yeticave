CREATE DATABASE `yeticave` CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `yeticave`;

CREATE TABLE `yeticave`.`categories`
(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`name` VARCHAR(255) NOT NULL ,
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE `name` (`name`)
)
ENGINE = InnoDB;


CREATE TABLE `yeticave`.`users`
(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`name` VARCHAR(255) NOT NULL ,
`avatar` VARCHAR(255),
`email` VARCHAR(255) NOT NULL ,
`password` VARCHAR(255) NOT NULL ,
`contacts` VARCHAR(255),
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
UNIQUE `email` (`email`)
)
ENGINE = InnoDB;


CREATE TABLE `yeticave`.`lots`
(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`pic` VARCHAR(255),
`name` VARCHAR(255) NOT NULL ,
`description` VARCHAR(2000),
`start_price` DECIMAL(10,2) NOT NULL ,
`end_date` TIMESTAMP NOT NULL ,
`stake_step` DECIMAL(10,2) NOT NULL ,
`num_likes` INT UNSIGNED,
`author_id` INT UNSIGNED NOT NULL ,
`winner_id` INT UNSIGNED,
`category_id` INT UNSIGNED NOT NULL ,
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
INDEX `winner_id` (`winner_id`),
INDEX `author_id` (`author_id`),
INDEX `category_id` (`category_id`),

CONSTRAINT `lots_categories`
FOREIGN KEY (`category_id`)
REFERENCES `categories` (`id`)
ON DELETE CASCADE,

CONSTRAINT `lots_users`
FOREIGN KEY (`author_id`)
REFERENCES `users` (`id`)
ON DELETE CASCADE
)
ENGINE = InnoDB;

CREATE TABLE `yeticave`.`stakes`
(
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
`stake_sum` DECIMAL(10,2) NOT NULL ,
`user_id` INT UNSIGNED NOT NULL ,
`lot_id` INT UNSIGNED NOT NULL ,
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
`updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (`id`),
INDEX `user_id` (`user_id`),
INDEX `lot_id` (`lot_id`),

CONSTRAINT `stakes_users`
FOREIGN KEY (`user_id`)
REFERENCES `users` (`id`)
ON DELETE CASCADE,

CONSTRAINT `stakes_lots`
FOREIGN KEY (`lot_id`)
REFERENCES `lots` (`id`)
ON DELETE CASCADE
)
ENGINE = InnoDB;


