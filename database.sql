CREATE DATABASE IF NOT EXISTS techshop;
USE techshop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(191) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(191) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    stock INT DEFAULT 0,
    image_url VARCHAR(500),
    featured BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (email, password, role) VALUES
('admin@techshop.fr', MD5('admin123'), 'admin'),
('user@techshop.fr', MD5('user123'), 'user'),
('test@example.com', MD5('password'), 'user'),
('demo@techshop.fr', MD5('demo123'), 'user');

INSERT INTO products (name, description, price, stock, image_url, featured) VALUES
('Smartphone Pro Max', 'Dernier smartphone avec écran OLED 6.7 pouces, 256Go de stockage et triple caméra 48MP', 899.99, 15, 'assets/img/smartphonepromax-grey.webp', TRUE),
('Laptop Gaming RTX', 'Ordinateur portable gaming avec RTX 4060, 16Go RAM, SSD 1To, écran 144Hz', 1299.99, 8, 'assets/img/laptop.avif', TRUE),
('Casque Audio Wireless', 'Casque sans fil à réduction de bruit active, autonomie 30h, son Hi-Fi', 199.99, 25, 'assets/img/CasqueAudioWireless.webp', TRUE),
('Tablette 11 pouces', 'Tablette avec écran Retina, processeur M1, 128Go, compatible stylet', 649.99, 12, 'assets/img/laptop.avif', FALSE),
('Montre Connectée Sport', 'Montre intelligente étanche, GPS, monitoring cardiaque, 7 jours d\'autonomie', 299.99, 20, 'assets/img/MontreConnectSport.webp', TRUE),
('Clavier Mécanique RGB', 'Clavier gaming mécanique avec rétroéclairage RGB, switches Cherry MX', 129.99, 30, 'assets/img/laptop.avif', FALSE),
('Souris Gaming Pro', 'Souris gaming haute précision 16000 DPI, 8 boutons programmables', 79.99, 40, 'assets/img/smartphonepromax-grey.webp', FALSE),
('Écran 4K 27 pouces', 'Moniteur 4K IPS 27 pouces, 144Hz, compatible HDR, port USB-C', 449.99, 6, 'assets/img/Écran4Kpouces.avif', TRUE);

CREATE INDEX idx_products_name ON products(name);
CREATE INDEX idx_products_featured ON products(featured);

CREATE TABLE activity_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(255),
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

SELECT 'Utilisateurs créés:' as info;
SELECT email, role FROM users;

SELECT 'Produits créés:' as info;
SELECT name, price, stock FROM products;