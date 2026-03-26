CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    password VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100)
);

CREATE TABLE prompts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255),
    content TEXT,
    user_id INT,
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);



INSERT INTO users (name, email, password, role) VALUES
('Touria', 'touria@test.com', '$2y$10$kNHX04x9eHb59KKVg6U07uaJUDJuogbCbo7SO2FOOsYWHq7G5PIdW', 'admin');



INSERT INTO categories (name) VALUES
('Code'),
('Marketing'),
('DevOps'),
('SQL'),
('Design');



INSERT INTO prompts (title, content, user_id, category_id) VALUES

('Générer un CRUD PHP',
'Génère un CRUD complet en PHP avec PDO et prepared statements.',
2, 1),

('Optimiser une campagne marketing',
'Donne-moi une stratégie marketing pour améliorer les conversions.',
3, 2),

('Dockeriser une app',
'Explique comment dockeriser une application Node.js avec Dockerfile.',
2, 3),

('Requête SQL optimisée',
'Optimise cette requête SQL complexe pour améliorer les performances.',
3, 4),

('Design moderne UI',
'Propose un design moderne avec Bootstrap pour une dashboard SaaS.',
2, 5),

('Validation formulaire PHP',
'Montre comment valider un formulaire côté serveur en PHP.',
3, 1);