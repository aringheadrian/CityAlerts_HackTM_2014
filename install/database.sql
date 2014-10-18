-- MySQL Script generated by MySQL Workbench
-- 09/01/14 23:42:10
-- Model: New Model    Version: 1.0
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';


-- -----------------------------------------------------
-- Table `user_groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_user_groups` (
  `group_id` INT NOT NULL AUTO_INCREMENT,
  `group_name` VARCHAR(45) NULL,
  `group_description` VARCHAR(255) NULL,
  PRIMARY KEY (`group_id`))
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT INTO `ct_user_groups` (`group_id`, `group_name`, `group_description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'user', 'Registered User');

-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_users` (
  `user_id` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `user_email` VARCHAR(255) NULL,
  `user_password` VARCHAR(45) NULL,
  `user_status` TINYINT NULL,
  `user_approved` TINYINT NULL,
  `user_created` DATETIME NULL,
  `last_login` DATETIME NULL,
  `last_ip` VARCHAR(45) NULL,
  `remember_code` VARCHAR(45) NULL,
  `activation_code` VARCHAR(45) NULL,
  PRIMARY KEY (`user_id`),
  INDEX `fk_users_user_groups1_idx` (`group_id` ASC),
  CONSTRAINT `fk_users_user_groups1`
    FOREIGN KEY (`group_id`)
    REFERENCES `cta_user_groups` (`group_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `user_profiles`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_user_profiles` (
  `profile_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `first_name` VARCHAR(255) NULL,
  `last_name` VARCHAR(255) NULL,
  `username` VARCHAR(255) NULL,
  `avatar` VARCHAR(255) NULL,
  PRIMARY KEY (`profile_id`),
  INDEX `fk_user_profiles_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_profiles_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `cta_users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



-- -----------------------------------------------------
-- Table `social_accounts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_social_accounts` (
  `social_id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `social_network` VARCHAR(45) NULL,
  `social_token` VARCHAR(255) NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`social_id`),
  INDEX `fk_social_accounts_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_social_accounts_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `cta_users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `agencies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_agencies` (
  `agency_id` INT NOT NULL AUTO_INCREMENT,
  `agency_name` VARCHAR(255) NULL,
  `agency_city` VARCHAR(255) NULL,
  `contact_details` TEXT NULL,
  PRIMARY KEY (`agency_id`))
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `alert_types`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_alert_types` (
  `type_id` INT NOT NULL AUTO_INCREMENT,
  `type_name` VARCHAR(255) NULL,
  `agency_id` INT NOT NULL,
  PRIMARY KEY (`type_id`),
  INDEX `fk_alert_types_agencies1_idx` (`agency_id` ASC),
  CONSTRAINT `fk_alert_types_agencies1`
    FOREIGN KEY (`agency_id`)
    REFERENCES `cta_agencies` (`agency_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `alerts`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_alerts` (
  `alert_id` INT NOT NULL,
  `agency_id` INT NOT NULL,
  `type_id` INT NOT NULL,
  `alert_title` VARCHAR(255) NULL,
  `alert_description` TEXT NULL,
  `alert_image` VARCHAR(255) NULL,
  `alert_city` VARCHAR(255) NULL,
  `alert_address` TEXT NULL,
  `alert_add` DATETIME NULL,
  `alert_contact` VARCHAR(255) NULL,
  `alert_start` DATETIME NULL,
  `alert_end` DATETIME NULL,
  `alert_coordinates` TEXT NULL,
  `alert_impact` TINYINT NULL,
  `alert_status` TINYINT NULL,
  PRIMARY KEY (`alert_id`),
  INDEX `fk_alerts_agencies1_idx` (`agency_id` ASC),
  INDEX `fk_alerts_alert_types1_idx` (`type_id` ASC),
  CONSTRAINT `fk_alerts_agencies1`
    FOREIGN KEY (`agency_id`)
    REFERENCES `cta_agencies` (`agency_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_alerts_alert_types1`
    FOREIGN KEY (`type_id`)
    REFERENCES `cta_alert_types` (`type_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `users_agencies`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_users_agencies` (
  `users_id` INT UNSIGNED NOT NULL,
  `agency_id` INT NOT NULL,
  PRIMARY KEY (`users_id`, `agency_id`),
  INDEX `fk_users_has_agencies_agencies1_idx` (`agency_id` ASC),
  INDEX `fk_users_has_agencies_users1_idx` (`users_id` ASC),
  CONSTRAINT `fk_users_has_agencies_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `cta_users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_users_has_agencies_agencies1`
    FOREIGN KEY (`agency_id`)
    REFERENCES `cta_agencies` (`agency_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `user_settings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_user_settings` (
  `setting_id` INT NOT NULL AUTO_INCREMENT,
  `setting_details` TEXT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`setting_id`),
  INDEX `fk_user_settings_users1_idx` (`user_id` ASC),
  CONSTRAINT `fk_user_settings_users1`
    FOREIGN KEY (`user_id`)
    REFERENCES `cta_users` (`user_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `comments`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_comments` (
  `comment_id` INT NOT NULL AUTO_INCREMENT,
  `alert_id` INT NOT NULL,
  `social_id` INT UNSIGNED NOT NULL,
  `content` TEXT NULL,
  `cooment_status` TINYINT NULL,
  PRIMARY KEY (`comment_id`),
  INDEX `fk_comments_alerts1_idx` (`alert_id` ASC),
  INDEX `fk_comments_social_accounts1_idx` (`social_id` ASC),
  CONSTRAINT `fk_comments_alerts1`
    FOREIGN KEY (`alert_id`)
    REFERENCES `cta_alerts` (`alert_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `fk_comments_social_accounts1`
    FOREIGN KEY (`social_id`)
    REFERENCES `cta_social_accounts` (`social_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `pages`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cta_pages` (
  `page_id` INT NOT NULL AUTO_INCREMENT,
  `page_title` VARCHAR(255) NULL,
  `page_meta_keywords` VARCHAR(255) NULL,
  `page_meta_description` VARCHAR(255) NULL,
  `page_content` TEXT NULL,
  `page_slug` VARCHAR(255) NULL,
  PRIMARY KEY (`page_id`))
ENGINE = InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
