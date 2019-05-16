CREATE DATABASE `wawi` /*!40100 COLLATE 'latin1_swedish_ci' */;

USE `wawi`;

CREATE TABLE artikel 
  ( 
     id              INT auto_increment PRIMARY KEY, 
     ean             VARCHAR(128) NOT NULL, 
     bezeichnung     VARCHAR(256) NOT NULL, 
     kurztext        TEXT NULL, 
     preis           DECIMAL(10,2) NOT NULL, 
     bild            VARCHAR(512) NULL, 
     inaktiv         TINYINT(1) DEFAULT 0 NOT NULL, 
     erstellt_zeit   TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
     bearbeitet_zeit TIMESTAMP NULL, 
     geloescht_zeit  TIMESTAMP NULL, 
     CONSTRAINT artikel_bezeichnung_uindex UNIQUE (bezeichnung), 
     CONSTRAINT artikel_ean_uindex UNIQUE (ean) 
  ); 

CREATE TABLE kunden 
  ( 
     id              INT auto_increment PRIMARY KEY, 
     name            VARCHAR(128) NOT NULL, 
     vorname         VARCHAR(128) NULL, 
     strasse         VARCHAR(256) NOT NULL, 
     hausnummer      INT NOT NULL, 
     plz             INT NOT NULL, 
     ort             VARCHAR(128) NOT NULL, 
     telefon         VARCHAR(64) NOT NULL, 
     email           VARCHAR(256) NULL, 
     inaktiv         TINYINT(1) DEFAULT 0 NOT NULL, 
     erstellt_zeit   TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
     bearbeitet_zeit TIMESTAMP NULL, 
     geloescht_zeit  TIMESTAMP NULL 
  ); 

CREATE TABLE lager 
  ( 
     id              INT auto_increment PRIMARY KEY, 
     bezeichnung     VARCHAR(256) NOT NULL, 
     inhouse         TINYINT(1) DEFAULT 0 NOT NULL, 
     strasse         VARCHAR(256) NULL, 
     hausnummer      INT NULL, 
     plz             INT NULL, 
     ort             VARCHAR(128) NULL, 
     inaktiv         TINYINT(1) DEFAULT 0 NOT NULL, 
     erstellt_zeit   TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
     bearbeitet_zeit TIMESTAMP NULL, 
     geloescht_zeit  TIMESTAMP NULL, 
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

CREATE TABLE auftrag 
  ( 
     id            INT auto_increment PRIMARY KEY, 
     kunde_id      INT NOT NULL, 
     bezeichnung   VARCHAR(128) NULL, 
     lieferdatum   TIMESTAMP NULL, 
     abgeschlossen TINYINT(1) DEFAULT 0 NOT NULL, 
     abgeschlossen_zeit TIMESTAMP NULL,
     erstellt_zeit TIMESTAMP DEFAULT CURRENT_TIMESTAMP() NOT NULL, 
     CONSTRAINT auftrag_kunden_id_fk FOREIGN KEY (kunde_id) REFERENCES kunden ( 
     id) ON UPDATE CASCADE ON DELETE CASCADE 
  ); 

CREATE TABLE auftrag_artikel 
  ( 
     auftrag_id        INT NOT NULL, 
     artikel_id        INT NOT NULL, 
     lager_id          INT NOT NULL, 
     auftragsposition  INT NOT NULL, 
     menge             INT DEFAULT 1 NOT NULL, 
     PRIMARY KEY (auftrag_id, artikel_id, lager_id), 
     CONSTRAINT auftrag_artikel_artikel_id_fk FOREIGN KEY (artikel_id) 
     REFERENCES artikel (id) ON UPDATE CASCADE ON DELETE CASCADE, 
     CONSTRAINT auftrag_artikel_auftrag_id_fk FOREIGN KEY (auftrag_id) 
     REFERENCES auftrag (id) ON UPDATE CASCADE ON DELETE CASCADE,
     CONSTRAINT auftrag_artikel_lager_id_fk FOREIGN KEY (lager_id) 
     REFERENCES lager (id) ON UPDATE CASCADE ON DELETE CASCADE 
  ); 

INSERT INTO wawi.artikel (id, ean, bezeichnung, kurztext, preis, bild, inaktiv, erstellt_zeit, bearbeitet_zeit, geloescht_zeit) VALUES (1, '5060337500401', 'Monster Energy Ultra 500ml', 'Zuckerfreies koffein- und taurinhaltiges Erfrischungsgetränk mit Guarana und B-Vitaminen', 1.49, '', 0, '2019-05-11 23:13:09', null, '2019-05-12 15:49:12');

INSERT INTO wawi.artikel (id, ean, bezeichnung, kurztext, preis, bild, inaktiv, erstellt_zeit, bearbeitet_zeit, geloescht_zeit) VALUES (2, '9002490100070', 'Red Bull', '', 1.85, '', 0, '2019-05-15 08:36:29', null, null);

INSERT INTO wawi.artikel (id, ean, bezeichnung, kurztext, preis, bild, inaktiv, erstellt_zeit, bearbeitet_zeit, geloescht_zeit) VALUES (3, '8076800195019', 'Barilla Capellini No. 1', 'Teigwaren aus Hartweizengriess', 1.69, '', 0, '2019-05-15 08:38:25', null, null);

INSERT INTO wawi.artikel (id, ean, bezeichnung, kurztext, preis, bild, inaktiv, erstellt_zeit, bearbeitet_zeit, geloescht_zeit) VALUES (5, '5000112548068', 'Coca-Cola', 'Koffeinhaltige Limonade', 0.74, '', 0, '2019-05-16 05:36:02', null, null);

INSERT INTO wawi.artikel (id, ean, bezeichnung, kurztext, preis, bild, inaktiv, erstellt_zeit, bearbeitet_zeit, geloescht_zeit) VALUES (6, '4014472277163', 'Bionade - Cola', 'Biologisches Erfrischungsgetränk', 2.00, '', 0, '2019-05-16 05:45:56', null, null);

INSERT INTO wawi.kunden (id, name, vorname, strasse, hausnummer, plz, ort, telefon, email, inaktiv, erstellt_zeit, bearbeitet_zeit, geloescht_zeit) VALUES (1, 'Kuehl', 'Tjark', 'Am Hang', 12, 27499, 'Hamburg', '04286 12345678', 'tjark-kuehl@hotmail.com', 0, '2019-05-11 23:01:17', null, '2019-05-12 15:48:18');

INSERT INTO wawi.lager (id, bezeichnung, inhouse, strasse, hausnummer, plz, ort, inaktiv, erstellt_zeit, bearbeitet_zeit, geloescht_zeit) VALUES (1, 'Selber-Lagern', 0, 'Eiffestrasse', 600, 20537, 'Hamburg', 0, '2019-05-11 23:11:23', null, null);

INSERT INTO wawi.lager (id, bezeichnung, inhouse, strasse, hausnummer, plz, ort, inaktiv, erstellt_zeit, bearbeitet_zeit, geloescht_zeit) VALUES (2, 'eMotivo', 0, 'Harburger Strasse', 15, 21266, 'Jesteburg', 0, '2019-05-15 08:59:38', null, null);