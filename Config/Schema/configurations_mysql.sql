-- -----------------------------------------------------
-- Require: ---
-- -----------------------------------------------------


-- -----------------------------------------------------
-- Drops
-- -----------------------------------------------------

DROP TABLE IF EXISTS entities;
DROP TABLE IF EXISTS languages;
DROP TABLE IF EXISTS locations;


-- -----------------------------------------------------
-- Table locations
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS languages (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  code VARCHAR(3) NOT NULL,
  code2 VARCHAR(2) NOT NULL,
  website TINYINT(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- -----------------------------------------------------
-- Table entities
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS entities (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(45) NOT NULL,
  alias VARCHAR(45) NOT NULL,
  folder VARCHAR(45) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;


-- -----------------------------------------------------
-- Table locations
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS locations (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INT UNSIGNED DEFAULT NULL,
  lft INT UNSIGNED DEFAULT NULL,
  rght INT UNSIGNED DEFAULT NULL,
  name VARCHAR(45) NOT NULL,
  latitude DOUBLE NOT NULL,
  longitude DOUBLE NOT NULL,
  is_capital TINYINT(1) NOT NULL,
  is_node TINYINT(1) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB;

ALTER TABLE locations ADD INDEX loc_loc_idx (parent_id ASC);


-- -----------------------------------------------------
-- Constraints
-- -----------------------------------------------------

ALTER TABLE locations ADD
CONSTRAINT loc_loc_fk FOREIGN KEY (parent_id) REFERENCES locations (id)
ON DELETE NO ACTION ON UPDATE NO ACTION;