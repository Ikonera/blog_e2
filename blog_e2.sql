-- MySQL Script generated by MySQL Workbench
-- Sat Nov 21 12:12:30 2020
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

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
-- Table `blog_e2`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog_e2`.`users` ;

CREATE TABLE IF NOT EXISTS `blog_e2`.`users` (
  `id_user` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `lastname` VARCHAR(45) NOT NULL,
  `pseudo` VARCHAR(45) NOT NULL,
  `email` VARCHAR(120) NOT NULL,
  `password` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE INDEX `id_user_UNIQUE` (`id_user` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC),
  UNIQUE INDEX `pseudo_UNIQUE` (`pseudo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_e2`.`categories`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog_e2`.`categories` ;

CREATE TABLE IF NOT EXISTS `blog_e2`.`categories` (
  `id_categorie` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id_categorie`),
  UNIQUE INDEX `id_categorie_UNIQUE` (`id_categorie` ASC),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_e2`.`articles`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog_e2`.`articles` ;

CREATE TABLE IF NOT EXISTS `blog_e2`.`articles` (
  `id_article` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author` INT UNSIGNED NOT NULL,
  `content` TEXT NOT NULL,
  `title` VARCHAR(45) NOT NULL,
  `category` INT UNSIGNED NOT NULL,
  `date` DATETIME NOT NULL DEFAULT NOW(),
  PRIMARY KEY (`id_article`),
  UNIQUE INDEX `id_article_UNIQUE` (`id_article` ASC),
  INDEX `authoruser_idx` (`author` ASC),
  INDEX `categoryid_idx` (`category` ASC),
  CONSTRAINT `authoruser`
    FOREIGN KEY (`author`)
    REFERENCES `blog_e2`.`users` (`id_user`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `categoryid`
    FOREIGN KEY (`category`)
    REFERENCES `blog_e2`.`categories` (`id_categorie`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `blog_e2`.`comments`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `blog_e2`.`comments` ;

CREATE TABLE IF NOT EXISTS `blog_e2`.`comments` (
  `id_comment` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `author` INT UNSIGNED NOT NULL,
  `content` TEXT NOT NULL,
  `article_id` INT UNSIGNED NOT NULL,
  `date` DATETIME NOT NULL DEFAULT NOW(),
  PRIMARY KEY (`id_comment`),
  UNIQUE INDEX `id_comment_UNIQUE` (`id_comment` ASC),
  INDEX `usercomment_idx` (`author` ASC),
  INDEX `articleid_idx` (`article_id` ASC),
  CONSTRAINT `usercomment`
    FOREIGN KEY (`author`)
    REFERENCES `blog_e2`.`users` (`id_user`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `articleid`
    FOREIGN KEY (`article_id`)
    REFERENCES `blog_e2`.`articles` (`id_article`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
