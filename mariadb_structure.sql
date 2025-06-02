-- Base de données pour le suivi de projet
CREATE DATABASE IF NOT EXISTS suivi_projet CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE suivi_projet;

-- Table des projets
CREATE TABLE projets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etat ENUM('prêt à poser', 'en cours', 'terminé', 'en attente') NOT NULL,
    sorti_dossier_be DATE,
    nom VARCHAR(100) NOT NULL,
    ville VARCHAR(100) NOT NULL,
    type_projet ENUM('P', 'GC', 'Structure + Escalier', 'Carport', 'Structure Verticoffre') NOT NULL,
    ral VARCHAR(20),
    soudure VARCHAR(50),
    tole VARCHAR(50),
    cintrage VARCHAR(50),
    preparation_lasurage VARCHAR(50),
    debit VARCHAR(50),
    usinage VARCHAR(50),
    divers VARCHAR(50),
    vitrage VARCHAR(50),
    isotoit VARCHAR(50),
    commande_composite VARCHAR(50),
    spot VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Table des clients
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    email VARCHAR(100),
    telephone VARCHAR(20),
    adresse TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Relation projet-client
ALTER TABLE projets ADD COLUMN client_id INT;
ALTER TABLE projets ADD FOREIGN KEY (client_id) REFERENCES clients(id);

-- Données d'exemple basées sur votre capture
INSERT INTO clients (nom, email, telephone) VALUES
('HASS', 'hass@email.com', '0123456789'),
('JEANNENOT', 'jeannenot@email.com', '0123456790'),
('MAURER', 'maurer@email.com', '0123456791'),
('VONESCH', 'vonesch@email.com', '0123456792'),
('LITHARD', 'lithard@email.com', '0123456793'),
('LAZARUS-FREI', 'lazarus@email.com', '0123456794'),
('BOUILLARD', 'bouillard@email.com', '0123456795');

INSERT INTO projets (etat, sorti_dossier_be, nom, ville, type_projet, ral, client_id, soudure, tole, cintrage) VALUES
('en cours', '2025-03-25', 'HASS', 'Kembis', 'P', NULL, 1, NULL, NULL, '25 avril'),
('prêt à poser', '2025-06-27', 'JEANNENOT', 'Etueffont', 'P', 'RM', 2, NULL, NULL, NULL),
('prêt à poser', '2025-07-18', 'MAURER', 'Burnhaupt-le-bas', 'P', '7016s', 3, '23 juillet', NULL, NULL),
('prêt à poser', '2025-07-19', 'VONESCH', 'Meyenheim', 'P', '9210', 4, NULL, NULL, NULL),
('prêt à poser', '2025-09-02', 'LITHARD', 'Sigolsheim', 'Structure + Escalier', '2100s', 5, '5 septembre', NULL, NULL),
('prêt à poser', '2025-09-02', 'LITHARD', 'Sigolsheim', 'GC', '2100s', 5, '5 septembre', NULL, NULL),
('en attente', '2025-09-06', 'LAZARUS-FREI', 'Didilenheim', 'Carport', '900s + 9006s', 6, NULL, NULL, NULL),
('prêt à poser', '2025-09-09', 'BOUILLARD', 'Evette-salbert', 'Structure Verticoffre', '7016s', 7, NULL, NULL, NULL);