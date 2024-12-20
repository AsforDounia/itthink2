CREATE DATABASE ITThink;
USE ITThink;
CREATE TABLE Utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom_utilisateur VARCHAR(255) NOT NULL,
    mot_de_passe VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    user_role VARCHAR(50) NOT NULL
);

INSERT INTO Utilisateurs (nom_utilisateur, mot_de_passe, email, user_role) VALUES ('alice', SHA2('password123', 256), 'alice@example.com', 'ADMIN'),('bob', SHA2('password456', 256), 'bob@example.com', 'USER'),('charlie', SHA2('password789', 256), 'charlie@example.com', 'USER');


CREATE TABLE Categories (
    id_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_categorie VARCHAR(255) UNIQUE NOT NULL
);
INSERT INTO Categories (nom_categorie) VALUES  ('Développement Web'),('Design'),('Marketing');

CREATE TABLE SousCategories (
    id_sous_categorie INT AUTO_INCREMENT PRIMARY KEY,
    nom_sous_categorie VARCHAR(255) UNIQUE NOT NULL,
    id_categorie INT,
    FOREIGN KEY (id_categorie) REFERENCES Categories(id_categorie) ON DELETE CASCADE
);
INSERT INTO SousCategories (nom_sous_categorie, id_categorie) VALUES  ('Frontend', 1), ('UI/UX', 2),('SEO', 3);


CREATE TABLE Projets (
    id_projet INT AUTO_INCREMENT PRIMARY KEY,
    titre_projet VARCHAR(255) UNIQUE NOT NULL,
    description TEXT NOT NULL,
    id_categorie INT,
    id_sous_categorie INT,
    id_utilisateur INT,
    FOREIGN KEY (id_categorie) REFERENCES Categories(id_categorie) ON DELETE SET NULL,
    FOREIGN KEY (id_sous_categorie) REFERENCES SousCategories(id_sous_categorie) ON DELETE SET NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur) ON DELETE CASCADE
);
INSERT INTO Projets (titre_projet, description, id_categorie, id_sous_categorie, id_utilisateur) VALUES  ('Refonte site e-commerce', 'Refonte complète du site de vente en ligne', 1, 1, 1),('Création logo', 'Création d un logo pour une entreprise de technologie', 2, 2, 2),('Campagne publicitaire', 'Campagne marketing pour une nouvelle application mobile', 3, 3, 3);

CREATE TABLE Freelances (
    id_freelance INT AUTO_INCREMENT PRIMARY KEY,
    competences TEXT NOT NULL,
    id_utilisateur INT UNIQUE,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur) ON DELETE CASCADE
);
INSERT INTO Freelances (competences, id_utilisateur)
VALUES ('Développement Web, React, Node.js', 1),('Design graphique, Photoshop, Illustrator', 2),('SEO, SEM, Google Ads', 3);


CREATE TABLE Offres (
    id_offre INT AUTO_INCREMENT PRIMARY KEY,
    montant FLOAT NOT NULL,
    delai INT NOT NULL,
    id_freelance INT,
    id_projet INT,
    FOREIGN KEY (id_freelance) REFERENCES Freelances(id_freelance) ON DELETE CASCADE,
    FOREIGN KEY (id_projet) REFERENCES Projets(id_projet) ON DELETE CASCADE
);
INSERT INTO Offres (montant, delai, id_freelance, id_projet)
VALUES (1500.00, 30, 1, 1),(500.00, 15, 2, 2),(1200.00, 45, 3, 3);


CREATE TABLE Temoignages (
    id_temoignage INT AUTO_INCREMENT PRIMARY KEY,
    commentaire TEXT NOT NULL,
    id_utilisateur INT,
    FOREIGN KEY (id_utilisateur) REFERENCES Utilisateurs(id_utilisateur) ON DELETE CASCADE
);
INSERT INTO Temoignages (commentaire, id_utilisateur)
VALUES ('Excellent service, très professionnel.', 1),('Très satisfait de la qualité du design.', 2),('Le projet a été livré dans les temps et selon les attentes.', 3);



-- ======================== Mise à jour des tables  ========================
    -- Ajouter une colonne date_creation dans la table Projets :
        ALTER TABLE Projets ADD COLUMN date_creation DATETIME DEFAULT CURRENT_TIMESTAMP;
    -- Ajouter un champ statut dans la table Projets :
        ALTER TABLE Projets ADD COLUMN statut VARCHAR(50) DEFAULT 'En cours';

-- ======================== Réaliser des opérations courantes ===============
    -- Insertion : Ajouter une nouvelle offre dans la table Offres
        INSERT INTO Offres (montant, delai, id_freelance, id_projet) VALUES (1500.00, 30, 1, 2);
    -- Mise à jour : Modifier les détails d’un projet
        UPDATE Projets SET titre_projet = 'Projet Redesign', description = 'Redesign complet du site', statut = 'Terminé' WHERE id_projet = 1;
    -- Suppression : Supprimer un témoignage
        DELETE FROM Temoignages WHERE id_temoignage = 1;


-- ======================== Requêtes de jointure ============================
    -- Récupérer les détails des projets liés à Développement Web catégorie
        SELECT p.id_projet, p.titre_projet, p.description, c.nom_categorie FROM Projets p INNER JOIN Categories c ON p.id_categorie = c.id_categorie WHERE c.nom_categorie = 'Développement Web';
    -- Récupérer les détails des offres liées à le freelance avec l id 1
        SELECT o.id_offre, o.montant, o.delai, f.competences, p.titre_projet FROM Offres o INNER JOIN Freelances f ON o.id_freelance = f.id_freelance INNER JOIN Projets p ON o.id_projet = p.id_projet WHERE f.id_freelance = 1;


-- ================================ Bonus ==================================
-- Utiliser des index
    CREATE INDEX idx_id_categorie ON Projets(id_categorie);
    -- SELECT * FROM Projets WHERE id_categorie = 1;
    CREATE INDEX idx_categorie_sous_categorie ON Projets(id_categorie, id_sous_categorie);
    -- SELECT * FROM Projets WHERE id_categorie = 1 AND id_sous_categorie = 2;
    -- SHOW INDEXES FROM table_name;
-- Implémenter des contraintes d'intégrité pour assurer la qualité des données
    ALTER TABLE Utilisateurs ADD CONSTRAINT chk_role CHECK (user_role IN ('Admin', 'User'));
-- Considérer l'utilisation de procédures stockées pour des opérations complexes
    DELIMITER //
        CREATE PROCEDURE AjouterOffre(IN p_montant FLOAT, IN p_delai INT, IN p_id_freelance INT, IN p_id_projet INT)
        BEGIN
            INSERT INTO Offres (montant, delai, id_freelance, id_projet) VALUES (p_montant, p_delai, p_id_freelance, p_id_projet);
        END //
    DELIMITER ;
