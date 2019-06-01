SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

CREATE SCHEMA IF NOT EXISTS `id9801034_primerjalko` DEFAULT CHARACTER SET utf8 ;
USE `id9801034_primerjalko` ;

CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`Stores` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(300) NOT NULL,
  `StoreURL` VARCHAR(2000) NOT NULL,
  `LogoURL` VARCHAR(2000) NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`Categories` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC) ,
  UNIQUE INDEX `Title_UNIQUE` (`Title` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`Products` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(300) NOT NULL,
  `ProductURL` VARCHAR(2000) NOT NULL,
  `Price` DECIMAL(10,2) NOT NULL,
  `DateTime` DATETIME NOT NULL,
  `Rating` INT NULL,
  `Description` TEXT NULL,
  `Stores_ID` INT NULL,
  `Categories_ID` INT NULL,
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  PRIMARY KEY (`ID`),
  INDEX `fk_Products_Stores1_idx` (`Stores_ID` ASC),
  INDEX `fk_Products_Categories1_idx` (`Categories_ID` ASC),
  CONSTRAINT `fk_Products_Stores1`
    FOREIGN KEY (`Stores_ID`)
    REFERENCES `id9801034_primerjalko`.`Stores` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Products_Categories1`
    FOREIGN KEY (`Categories_ID`)
    REFERENCES `id9801034_primerjalko`.`Categories` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`Users` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Name` VARCHAR(100) NOT NULL,
  `LastName` VARCHAR(100) NOT NULL,
  `Email` VARCHAR(255) NOT NULL,
  `Password` CHAR(128) NOT NULL,
  `Admin` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC))
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`Pictures` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `url` VARCHAR(2000) NOT NULL,
  `Title` VARCHAR(50) NULL,
  `Products_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  INDEX `fk_Pictures_Products1_idx` (`Products_ID` ASC),
  CONSTRAINT `fk_Pictures_Products1`
    FOREIGN KEY (`Products_ID`)
    REFERENCES `id9801034_primerjalko`.`Products` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`Favorites` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Products_ID` INT NOT NULL,
  `Users_ID` INT NOT NULL,
  `DateTime` DATETIME NOT NULL,
  PRIMARY KEY (`ID`, `Products_ID`, `Users_ID`),
  INDEX `fk_Products_has_Users_Users1_idx` (`Users_ID` ASC),
  INDEX `fk_Products_has_Users_Products_idx` (`Products_ID` ASC),
  CONSTRAINT `fk_Products_has_Users_Products`
    FOREIGN KEY (`Products_ID`)
    REFERENCES `id9801034_primerjalko`.`Products` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Products_has_Users_Users1`
    FOREIGN KEY (`Users_ID`)
    REFERENCES `id9801034_primerjalko`.`Users` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`Filters` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Title` VARCHAR(100) NOT NULL,
  `Categories_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  INDEX `fk_Filters_Categories1_idx` (`Categories_ID` ASC),
  CONSTRAINT `fk_Filters_Categories1`
    FOREIGN KEY (`Categories_ID`)
    REFERENCES `id9801034_primerjalko`.`Categories` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`Products_has_Filters` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Products_ID` INT NOT NULL,
  `Filters_ID` INT NOT NULL,
  `HasFilter` INT ZEROFILL NOT NULL,
  PRIMARY KEY (`ID`, `Products_ID`, `Filters_ID`),
  INDEX `fk_Products_has_Filters_Filters1_idx` (`Filters_ID` ASC),
  INDEX `fk_Products_has_Filters_Products1_idx` (`Products_ID` ASC),
  CONSTRAINT `fk_Products_has_Filters_Products1`
    FOREIGN KEY (`Products_ID`)
    REFERENCES `id9801034_primerjalko`.`Products` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Products_has_Filters_Filters1`
    FOREIGN KEY (`Filters_ID`)
    REFERENCES `id9801034_primerjalko`.`Filters` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS `id9801034_primerjalko`.`SimilarProducts` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `Text` DOUBLE NULL,
  `Description` DOUBLE NULL,
  `Picture` DOUBLE NULL,
  `Products_ID` INT NOT NULL,
  `SimilarProduct_ID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE INDEX `ID_UNIQUE` (`ID` ASC),
  INDEX `fk_SimilarProducts_Products1_idx` (`Products_ID` ASC),
  CONSTRAINT `fk_SimilarProducts_Products1`
    FOREIGN KEY (`Products_ID`)
    REFERENCES `id9801034_primerjalko`.`Products` (`ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
ALTER TABLE id9801034_primerjalko.SimilarProducts
  ADD CONSTRAINT uq_SimilarProducts UNIQUE(Products_ID, SimilarProduct_ID);


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
