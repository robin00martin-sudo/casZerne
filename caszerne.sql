
CREATE DATABASE IF NOT EXISTS CasZerne
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE CasZerne;


CREATE TABLE TRANCHE (
    idTranche   INT          NOT NULL AUTO_INCREMENT,
    libelle     VARCHAR(50)  NOT NULL COMMENT 'Ex : Matin, Après-midi, Nuit',
    heureDebut  TIME         NOT NULL COMMENT 'Heure de début de la tranche',
    heureFin    TIME         NOT NULL COMMENT 'Heure de fin de la tranche',
    PRIMARY KEY (idTranche)
) ENGINE=InnoDB COMMENT='Tranches horaires de garde';


CREATE TABLE DISPONIBILITE (
    idDisponibilite INT         NOT NULL AUTO_INCREMENT,
    libelle         VARCHAR(30) NOT NULL COMMENT 'Ex : Disponible, Missionné, Absent',
    code            CHAR(1)     NOT NULL COMMENT 'Code court : D, M, A',
    PRIMARY KEY (idDisponibilite),
    UNIQUE KEY uq_code (code)
) ENGINE=InnoDB COMMENT='États de disponibilité possibles';


CREATE TABLE VOLONTAIRE (
    idVolontaire INT          NOT NULL AUTO_INCREMENT,
    nom          VARCHAR(80)  NOT NULL,
    prenom       VARCHAR(80)  NOT NULL,
    numeroBip    VARCHAR(10)  NOT NULL COMMENT 'Identifiant radio unique du pompier',
    nbGardes     INT          NOT NULL DEFAULT 0 COMMENT 'Compteur cumulé de gardes effectuées',
    PRIMARY KEY (idVolontaire),
    UNIQUE KEY uq_numeroBip (numeroBip)
) ENGINE=InnoDB COMMENT='Pompiers volontaires de la caserne';


CREATE TABLE PERIODE_GARDE (
    idTranche   INT  NOT NULL COMMENT 'FK → TRANCHE',
    datePeriode DATE NOT NULL COMMENT 'Date de la période de garde',
    nbPompiers  INT  NOT NULL DEFAULT 0 COMMENT 'Nombre de pompiers affectés à cette période',
    PRIMARY KEY (idTranche, datePeriode),
    CONSTRAINT fk_pg_tranche FOREIGN KEY (idTranche) REFERENCES TRANCHE(idTranche)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB COMMENT='Périodes de garde planifiées';


CREATE TABLE AVOIR_ACTIVITE (
    idVolontaire    INT  NOT NULL COMMENT 'FK → VOLONTAIRE',
    idTranche       INT  NOT NULL COMMENT 'FK → PERIODE_GARDE (idTranche)',
    datePeriode     DATE NOT NULL COMMENT 'FK → PERIODE_GARDE (datePeriode)',
    idDisponibilite INT  NOT NULL COMMENT 'FK → DISPONIBILITE',
    deGarde         TINYINT(1) NOT NULL DEFAULT 0 COMMENT '1 = effectivement de garde, 0 = non',
    PRIMARY KEY (idVolontaire, idTranche, datePeriode),
    CONSTRAINT fk_aa_volontaire    FOREIGN KEY (idVolontaire)    REFERENCES VOLONTAIRE(idVolontaire)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_aa_periode       FOREIGN KEY (idTranche, datePeriode) REFERENCES PERIODE_GARDE(idTranche, datePeriode)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_aa_disponibilite FOREIGN KEY (idDisponibilite) REFERENCES DISPONIBILITE(idDisponibilite)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB COMMENT='Activité (disponibilité + garde) de chaque volontaire par période';

-- ============================================================
--  JEU DE DONNÉES 
-- ============================================================

-- Tranches horaires standard
INSERT INTO TRANCHE (libelle, heureDebut, heureFin) VALUES
    ('Matin',        '06:00:00', '14:00:00'),
    ('Après-midi',   '14:00:00', '22:00:00'),
    ('Nuit',         '22:00:00', '06:00:00');

-- États de disponibilité
INSERT INTO DISPONIBILITE (libelle, code) VALUES
    ('Disponible', 'D'),
    ('Missionné',  'M'),
    ('Absent',     'A');

-- Pompiers de démonstration
INSERT INTO VOLONTAIRE (nom, prenom, numeroBip, nbGardes) VALUES
    ('MARTIN',   'Jean',    '1001', 12),
    ('DUPONT',   'Marie',   '1002',  8),
    ('BERNARD',  'Pierre',  '1003', 15),
    ('LEROY',    'Sophie',  '1004',  5),
    ('MOREAU',   'Luc',     '1005', 20);

-- Périodes de garde de démonstration
INSERT INTO PERIODE_GARDE (idTranche, datePeriode, nbPompiers) VALUES
    (1, CURDATE(),              3),
    (2, CURDATE(),              2),
    (3, CURDATE(),              2),
    (1, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 3),
    (2, DATE_ADD(CURDATE(), INTERVAL 1 DAY), 2);

-- Activités de démonstration
INSERT INTO AVOIR_ACTIVITE (idVolontaire, idTranche, datePeriode, idDisponibilite, deGarde) VALUES
    (1, 1, CURDATE(), 1, 1),
    (2, 1, CURDATE(), 1, 1),
    (3, 1, CURDATE(), 2, 1),
    (4, 2, CURDATE(), 1, 0),
    (5, 3, CURDATE(), 3, 0);

