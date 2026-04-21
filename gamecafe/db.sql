-- 1. Création de la base de données
CREATE DATABASE IF NOT EXISTS gamecafe_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE gamecafe_db;

-- 2. Table des Utilisateurs (Clients et Admins)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL, -- Stockera le mot de passe hashé
    role ENUM('client', 'admin') DEFAULT 'client',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. Table des Jeux (Le Catalogue)
CREATE TABLE games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category ENUM('Stratégie', 'Ambiance', 'Famille', 'Experts') NOT NULL,
    min_players INT NOT NULL,
    max_players INT NOT NULL,
    duration INT NOT NULL COMMENT 'Durée moyenne en minutes',
    description TEXT,
    difficulty INT DEFAULT 1 COMMENT 'Note de difficulté de 1 à 5',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Table des Tables physiques du Café
CREATE TABLE game_tables (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    capacity INT NOT NULL COMMENT 'Nombre maximum de joueurs à cette table'
);

-- 5. Table des Réservations
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    guests_count INT NOT NULL,
    reservation_date DATE NOT NULL,
    reservation_time TIME NOT NULL,
    status ENUM('en attente', 'confirmée', 'annulée') DEFAULT 'en attente',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- CASCADE : Si l'utilisateur est supprimé, ses réservations sont supprimées
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- 6. Table des Sessions (Le cœur du jeu en direct)
CREATE TABLE sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NULL, -- NULL si c'est des clients qui arrivent sans réserver
    game_id INT NOT NULL,
    table_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NULL,
    -- CASCADES : Si on supprime un jeu, une table ou une réservation, la session est supprimée
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    FOREIGN KEY (table_id) REFERENCES game_tables(id) ON DELETE CASCADE,
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) ON DELETE CASCADE
);

-- 7. Table des Notes (Pour le Bonus)
CREATE TABLE ratings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    game_id INT NOT NULL,
    user_id INT NOT NULL,
    score INT NOT NULL CHECK (score >= 1 AND score <= 5),
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    -- CASCADES : Si on supprime le jeu ou l'utilisateur, la note disparaît
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);