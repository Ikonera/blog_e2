-- MySQL Script generated by MySQL Workbench
-- Tue Mar 30 23:56:59 2021
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema blog_e2
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `blog_e2` ;

-- -----------------------------------------------------
-- Schema blog_e2
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `blog_e2` DEFAULT CHARACTER SET utf8 ;
USE `blog_e2` ;

-- -----------------------------------------------------
-- Table `blog_e2`.`categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog_e2`.`categories` ;

CREATE TABLE IF NOT EXISTS `blog_e2`.`categories` (
  `category_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`category_id`),
  UNIQUE INDEX `id_categorie_UNIQUE` (`category_id` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `blog_e2`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog_e2`.`users` ;

CREATE TABLE IF NOT EXISTS `blog_e2`.`users` (
  `user_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `pseudo` VARCHAR(45) NOT NULL,
  `email` VARCHAR(70) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  `rights` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`user_id`),
  UNIQUE INDEX `id_user_UNIQUE` (`user_id` ASC),
  UNIQUE INDEX `pseudo_UNIQUE` (`pseudo` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `blog_e2`.`articles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog_e2`.`articles` ;

CREATE TABLE IF NOT EXISTS `blog_e2`.`articles` (
  `article_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  `author` VARCHAR(45) NOT NULL,
  `category` INT(10) UNSIGNED NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `keywords` VARCHAR(45) NULL,
  `description` VARCHAR(255) NULL,
  PRIMARY KEY (`article_id`),
  UNIQUE INDEX `id_article_UNIQUE` (`article_id` ASC),
  INDEX `categoryid_idx` (`category` ASC),
  INDEX `authorpseudo_idx` (`author` ASC),
  CONSTRAINT `categoryid`
    FOREIGN KEY (`category`)
    REFERENCES `blog_e2`.`categories` (`category_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `authorpseudo`
    FOREIGN KEY (`author`)
    REFERENCES `blog_e2`.`users` (`pseudo`)
    ON DELETE NO ACTION
    ON UPDATE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `blog_e2`.`comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog_e2`.`comments` ;

CREATE TABLE IF NOT EXISTS `blog_e2`.`comments` (
  `comment_id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` TEXT NOT NULL,
  `article_id` INT(10) UNSIGNED NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
  `author` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`comment_id`),
  UNIQUE INDEX `id_comment_UNIQUE` (`comment_id` ASC),
  INDEX `articleid_idx` (`article_id` ASC),
  INDEX `authorpseudo_idx` (`author` ASC),
  CONSTRAINT `articleid`
    FOREIGN KEY (`article_id`)
    REFERENCES `blog_e2`.`articles` (`article_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `userpseudo`
    FOREIGN KEY (`author`)
    REFERENCES `blog_e2`.`users` (`pseudo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
