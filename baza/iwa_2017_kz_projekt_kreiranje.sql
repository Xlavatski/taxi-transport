-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema iwa_2017_kz_projekt
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema iwa_2017_kz_projekt
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `iwa_2017_kz_projekt` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_mysql500_ci ;
USE `iwa_2017_kz_projekt` ;

-- -----------------------------------------------------
-- Table `iwa_2017_kz_projekt`.`tip_korisnika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2017_kz_projekt`.`tip_korisnika` (
  `tip_id` INT(10) NOT NULL AUTO_INCREMENT,
  `naziv` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`tip_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2017_kz_projekt`.`korisnik`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2017_kz_projekt`.`korisnik` (
  `korisnik_id` INT(10) NOT NULL AUTO_INCREMENT,
  `tip_id` INT(10) NOT NULL,
  `korisnicko_ime` VARCHAR(50) NOT NULL,
  `lozinka` VARCHAR(50) NOT NULL,
  `ime` VARCHAR(50) NOT NULL,
  `prezime` VARCHAR(50) NOT NULL,
  `email` VARCHAR(50) NULL,
  `slika` VARCHAR(100) NULL,
  PRIMARY KEY (`korisnik_id`),
  INDEX `fk_korisnik_tip_korisnika_idx` (`tip_id` ASC),
  CONSTRAINT `fk_korisnik_tip_korisnika`
    FOREIGN KEY (`tip_id`)
    REFERENCES `iwa_2017_kz_projekt`.`tip_korisnika` (`tip_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2017_kz_projekt`.`zupanija`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2017_kz_projekt`.`zupanija` (
  `zupanija_id` INT(10) NOT NULL AUTO_INCREMENT,
  `moderator_id` INT(10) NOT NULL,
  `naziv` VARCHAR(50) NOT NULL,
  `broj_vozila` INT(4) NOT NULL,
  PRIMARY KEY (`zupanija_id`),
  INDEX `fk_kateogrija_predmeta_korisnik1_idx` (`moderator_id` ASC),
  CONSTRAINT `fk_kateogrija_predmeta_korisnik1`
    FOREIGN KEY (`moderator_id`)
    REFERENCES `iwa_2017_kz_projekt`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2017_kz_projekt`.`vozilo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2017_kz_projekt`.`vozilo` (
  `vozilo_id` INT(10) NOT NULL AUTO_INCREMENT,
  `zupanija_id` INT(10) NOT NULL,
  `oznaka` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`vozilo_id`),
  INDEX `fk_vozilo_podrucje1_idx` (`zupanija_id` ASC),
  CONSTRAINT `fk_vozilo_podrucje1`
    FOREIGN KEY (`zupanija_id`)
    REFERENCES `iwa_2017_kz_projekt`.`zupanija` (`zupanija_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2017_kz_projekt`.`adresa`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2017_kz_projekt`.`adresa` (
  `adresa_id` INT(10) NOT NULL AUTO_INCREMENT,
  `zupanija_id` INT(10) NOT NULL,
  `grad` VARCHAR(50) NOT NULL,
  `ulica` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`adresa_id`),
  INDEX `fk_ulica_podrucje1_idx` (`zupanija_id` ASC),
  CONSTRAINT `fk_ulica_podrucje1`
    FOREIGN KEY (`zupanija_id`)
    REFERENCES `iwa_2017_kz_projekt`.`zupanija` (`zupanija_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `iwa_2017_kz_projekt`.`rezervacija`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `iwa_2017_kz_projekt`.`rezervacija` (
  `rezervacija_id` INT(10) NOT NULL AUTO_INCREMENT,
  `korisnik_id` INT(10) NOT NULL,
  `vozilo_id` INT(10) NOT NULL,
  `adresa_polaska_id` INT(10) NOT NULL,
  `adresa_odredista_id` INT(10) NOT NULL,
  `datum_vrijeme_polaska` DATETIME NOT NULL,
  `datum_vrijeme_dolaska` DATETIME NULL,
  `komentar` VARCHAR(100) NULL,
  `status` INT(1) NOT NULL,
  INDEX `fk_ulica_has_korisnik_korisnik1_idx` (`korisnik_id` ASC),
  INDEX `fk_ulica_has_korisnik_ulica1_idx` (`adresa_polaska_id` ASC),
  INDEX `fk_rezervacija_vozilo1_idx` (`vozilo_id` ASC),
  PRIMARY KEY (`rezervacija_id`),
  CONSTRAINT `fk_ulica_has_korisnik_ulica1`
    FOREIGN KEY (`adresa_polaska_id`)
    REFERENCES `iwa_2017_kz_projekt`.`adresa` (`adresa_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ulica_has_korisnik_korisnik1`
    FOREIGN KEY (`korisnik_id`)
    REFERENCES `iwa_2017_kz_projekt`.`korisnik` (`korisnik_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_rezervacija_vozilo1`
    FOREIGN KEY (`vozilo_id`)
    REFERENCES `iwa_2017_kz_projekt`.`vozilo` (`vozilo_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE USER 'iwa_2017'@'localhost' IDENTIFIED BY 'foi2017';
GRANT SELECT, INSERT, UPDATE, DELETE ON TABLE `iwa_2017_kz_projekt`.* 
TO 'iwa_2017'@'localhost' IDENTIFIED BY 'foi2017';

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
