CREATE DATABASE wawi; 

USE wawi; 

CREATE TABLE artikel 
  ( 
     id              INT auto_increment PRIMARY KEY, 
     ean             VARCHAR(128) NULL, 
     bezeichnung     VARCHAR(256) NOT NULL, 
     kurztext        TEXT NULL, 
     preis           DECIMAL NOT NULL, 
     bild            VARCHAR(512) NULL, 
     inaktiv         TINYINT(1) DEFAULT 0 NOT NULL, 
     erstellt_zeit   TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
     bearbeitet_zeit TIMESTAMP NULL, 
     gelöscht_zeit   TIMESTAMP NULL, 
     CONSTRAINT artikel_bezeichnung_uindex UNIQUE (bezeichnung), 
     CONSTRAINT artikel_ean_uindex UNIQUE (ean) 
  ); 

CREATE TABLE kunden 
  ( 
     id              INT auto_increment PRIMARY KEY, 
     name            VARCHAR(128) NOT NULL, 
     vorname         VARCHAR(128) NULL, 
     straße          VARCHAR(256) NOT NULL, 
     straßennummer   INT NOT NULL, 
     plz             INT NOT NULL, 
     ort             VARCHAR(128) NOT NULL, 
     telefon         VARCHAR(64) NOT NULL, 
     email           VARCHAR(256) NULL, 
     inaktiv         TINYINT(1) DEFAULT 0 NOT NULL, 
     erstellt_zeit   TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
     bearbeitet_zeit TIMESTAMP NULL, 
     gelöscht_zeit   TIMESTAMP NULL 
  ); 

CREATE TABLE lager 
  ( 
     id              INT auto_increment PRIMARY KEY, 
     bezeichnung     VARCHAR(256) NOT NULL, 
     inhouse         TINYINT(1) DEFAULT 0 NOT NULL, 
     stra�e         VARCHAR(256) NULL, 
     stra�ennummer  INT NULL, 
     plz             INT NULL, 
     ort             VARCHAR(128) NULL, 
     inaktiv         TINYINT(1) DEFAULT 0 NOT NULL, 
     erstellt_zeit   TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
     bearbeitet_zeit TIMESTAMP NULL, 
     gelöscht_zeit   TIMESTAMP NULL, 
     CONSTRAINT lager_bezeichnung_uindex UNIQUE (bezeichnung) 
  ); 

CREATE TABLE lager_artikel 
  ( 
     artikel_id INT NOT NULL, 
     lager_id   INT NOT NULL, 
     menge      INT NOT NULL, 
     PRIMARY KEY (artikel_id, lager_id), 
     CONSTRAINT lager_artikel_artikel_id_fk FOREIGN KEY (artikel_id) REFERENCES 
     artikel (id) ON UPDATE CASCADE ON DELETE CASCADE, 
     CONSTRAINT lager_artikel_lager_id_fk FOREIGN KEY (lager_id) REFERENCES 
     lager (id) ON UPDATE CASCADE ON DELETE CASCADE 
  ); 

CREATE TABLE rechnung 
  ( 
     id            INT auto_increment PRIMARY KEY, 
     kunde_id      INT NOT NULL, 
     bezeichnung   VARCHAR(128) NULL, 
     lieferdatum   TIMESTAMP NULL, 
     erstellt_zeit TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
     CONSTRAINT rechnung_kunden_id_fk FOREIGN KEY (kunde_id) REFERENCES kunden ( 
     id) ON UPDATE CASCADE ON DELETE CASCADE 
  ); 

CREATE TABLE rechnung_artikel 
  ( 
     rechnung_id       INT NOT NULL, 
     artikel_id        INT NOT NULL, 
     rechnungsposition INT NOT NULL, 
     menge             INT DEFAULT 1 NOT NULL, 
     PRIMARY KEY (rechnung_id, artikel_id), 
     CONSTRAINT rechnung_artikel_artikel_id_fk FOREIGN KEY (artikel_id) 
     REFERENCES artikel (id) ON UPDATE CASCADE ON DELETE CASCADE, 
     CONSTRAINT rechnung_artikel_rechnung_id_fk FOREIGN KEY (rechnung_id) 
     REFERENCES rechnung (id) ON UPDATE CASCADE ON DELETE CASCADE 
  ); 