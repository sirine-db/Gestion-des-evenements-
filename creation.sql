-- Créer la base de données
CREATE DATABASE evenement_platform;

-- Utiliser la base de données créée
USE evenement_platform;

-- Table: users
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    numero_tele VARCHAR(20),
    adresse_mail VARCHAR(100),
    password VARCHAR(255),
    username VARCHAR(50),
    role ENUM('user', 'admin', 'organiser'),
    statut ENUM('connecte', 'bannis'),
    photo_path VARCHAR(255)
    preference INT(1) -- hedy ztha
);
-- Table: preferences
CREATE TABLE preference_user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    categorie VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table: events
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    nombre_participant INT,
    lieu VARCHAR(100),
    date_event DATE,
    duree TIME,
    organizer_id INT,
    users_list TEXT,
    photo_path VARCHAR(255),-- hedy ne7ouha ndiroulha une table w7edha
    status ENUM('pending', 'accepted', 'rejected'),
    FOREIGN KEY (organizer_id) REFERENCES users(id)
);

-- Table: event_requests
CREATE TABLE event_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    nombre_participant INT,
    lieu VARCHAR(100),
    date_event DATE,
    duree TIME,
    organizer_id INT,
    status ENUM('pending', 'accepted', 'rejected'),
    photo_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (organizer_id) REFERENCES users(id)
);

-- Table: event_participants
CREATE TABLE event_participants (
    event_id INT,
    user_id INT,
    PRIMARY KEY (event_id, user_id),
    FOREIGN KEY (event_id) REFERENCES events(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Table: messages
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT,
    subject VARCHAR(255),
    body TEXT,
    sent_at DATETIME,
    status ENUM('unread', 'read', 'archived'),
    FOREIGN KEY (sender_id) REFERENCES users(id)
);

-- Table: notifications
CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message VARCHAR(255),
    date_sent DATETIME,
    status ENUM('unread', 'read')
);

CREATE TABLE event_participation (
    id INT AUTO_INCREMENT PRIMARY KEY, -- Identifiant unique pour chaque participation
    user_id INT NOT NULL,              -- Référence à l'utilisateur
    event_id INT NOT NULL,             -- Référence à l'événement
    motivation TEXT,                   -- Motivation de l'utilisateur pour participer
    attentes TEXT,                     -- Attentes de l'utilisateur pour l'événement
    statut ENUM('etudiant', 'professionnelle', 'retraité', 'autre') NOT NULL, -- Statut de l'utilisateur
    rajout TEXT,                       -- Informations supplémentaires fournies par l'utilisateur
    participation_status ENUM('en_cours', 'accepté') DEFAULT 'en_cours', -- Statut de la participation
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, -- Date et heure de la soumission
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE, -- Clé étrangère pour les utilisateurs
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE -- Clé étrangère pour les événements
);


// hedy c la cmd C:\xampp\htdocs\tpweb>C:\xampp\mysql\bin\mysql -u root -p < C:\xampp\htdocs\tpweb\creation.sql