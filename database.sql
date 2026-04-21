-- =============================================
-- BASE DE DONNÉES : gestion_etudiants
-- =============================================

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS gestion_etudiants
    CHARACTER SET utf8
    COLLATE utf8_general_ci;

USE gestion_etudiants;

-- =============================================
-- TABLE : filieres
-- =============================================
CREATE TABLE IF NOT EXISTS filieres (
    id  INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL
);

-- =============================================
-- TABLE : etudiants
-- =============================================
CREATE TABLE IF NOT EXISTS etudiants (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nom        VARCHAR(100) NOT NULL,
    prenom     VARCHAR(100) NOT NULL,
    filiere_id INT NOT NULL,
    FOREIGN KEY (filiere_id) REFERENCES filieres(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =============================================
-- DONNÉES DE TEST : filières
-- =============================================
INSERT INTO filieres (nom) VALUES
    ('Systèmes Informatiques et Logiciels'),
    ('Génie Logiciel'),
    ('Réseaux et Télécommunications'),
    ('Maintenance Informatique'),
    ('Développement Web');

-- =============================================
-- DONNÉES DE TEST : étudiants
-- =============================================
INSERT INTO etudiants (nom, prenom, filiere_id) VALUES
    ('Koffi', 'Sylvain', 1),
    ('Ahounou', 'Brice', 2),
    ('Agossou', 'Marlène', 3);
