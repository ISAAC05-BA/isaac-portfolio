-- ============================================
-- ADIEYEFEH ONLINE SHOPPING - Database Setup
-- ============================================

-- Create database
CREATE DATABASE IF NOT EXISTS adieyefeh_shop;
USE adieyefeh_shop;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') DEFAULT 'customer',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Products table
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    description TEXT,
    category VARCHAR(50) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Cart table
CREATE TABLE IF NOT EXISTS cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Orders table
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_price DECIMAL(10, 2) NOT NULL,
    status ENUM('pending', 'processing', 'shipped', 'completed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Order items table
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Insert sample products
INSERT INTO products (name, description, category, price, image, stock) VALUES
-- Men's Wear
('Men\'s Classic Shirt', 'High quality cotton shirt perfect for formal occasions', 'men', 150.00, 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=400', 50),
('Men\'s Winter Coat', 'Warm and stylish winter coat for cold weather', 'men', 450.00, 'https://images.unsplash.com/photo-1544923246-77307dd628b5?w=400', 30),
('Men\'s Formal Suit', 'Elegant formal suit for business meetings', 'men', 850.00, 'https://images.unsplash.com/photo-1594938298603-c8148c4dae35?w=400', 25),

-- Women's Wear
('Women\'s Floral Dress', 'Beautiful floral dress for casual occasions', 'women', 180.00, 'https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=400', 40),
('Women\'s Blouse', 'Elegant blouse for office wear', 'women', 120.00, 'https://images.unsplash.com/photo-1564257631407-4deb1f99d992?w=400', 35),
('Women\'s Winter Coat', 'Stylish winter coat for women', 'women', 520.00, 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400', 20),

-- Children's Wear
('Kids T-Shirt', 'Comfortable cotton t-shirt for kids', 'children', 45.00, 'https://images.unsplash.com/photo-1519278350407-4c3a2b1f0d6c?w=400', 100),
('Children\'s Sneakers', 'Colorful and comfortable sneakers for kids', 'children', 120.00, 'https://images.unsplash.com/photo-1560769629-975ec94e6a86?w=400', 60),
('Kids Dress', 'Cute dress for girls', 'children', 85.00, 'https://images.unsplash.com/photo-1596870230751-ebdfce989e97?w=400', 45),

-- Footwear
('Men\'s Formal Shoes', 'Classic leather formal shoes', 'shoes', 320.00, 'https://images.unsplash.com/photo-1614252369475-531eba835eb1?w=400', 40),
('Women\'s High Heels', 'Elegant high heels for formal events', 'shoes', 280.00, 'https://images.unsplash.com/photo-1543163521-1bf539c55dd2?w=400', 35),
('Casual Sneakers', 'Comfortable casual sneakers for everyday wear', 'shoes', 180.00, 'https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?w=400', 80),

-- Bags & Accessories
('Men\'s Leather Bag', 'Professional leather bag for work', 'bags', 250.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400', 30),
('Women\'s Handbag', 'Stylish handbag for women', 'bags', 180.00, 'https://images.unsplash.com/photo-1584917865442-de89df76afd3?w=400', 50),
('Backpack', 'Durable backpack for students', 'bags', 95.00, 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400', 70);

-- Insert admin user (password: admin123)
INSERT INTO users (name, email, password, role) VALUES 
('Admin', 'admin@adieyefeh.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin');

-- Insert sample customer
INSERT INTO users (name, email, password, role) VALUES 
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'customer');
