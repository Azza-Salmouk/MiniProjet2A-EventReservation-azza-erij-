-- Database setup script for MiniEvent Reservation System

-- Create database
CREATE DATABASE IF NOT EXISTS mini_event CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mini_event;

-- Drop tables if they exist (for clean setup)
DROP TABLE IF EXISTS reservations;
DROP TABLE IF EXISTS events;
DROP TABLE IF EXISTS admin;

-- Create events table
CREATE TABLE events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATETIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    seats INT NOT NULL DEFAULT 0,
    image VARCHAR(255) NULL
);

-- Create reservations table
CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

-- Create admin table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
);

-- Insert sample events
INSERT INTO events (title, description, event_date, location, seats, image) VALUES
('Tech Conference 2023', 'Join us for the biggest tech conference of the year featuring industry leaders and innovators.', '2024-01-15 09:00:00', 'Convention Center, Paris', 200, 'tech.jpg'),
('Art Exhibition Opening', 'Experience contemporary art from emerging artists in our grand opening exhibition.', '2024-01-20 18:00:00', 'Modern Art Gallery, Lyon', 150, 'art.jpg'),
('Music Festival', 'Three days of amazing music performances from local and international artists.', '2024-02-10 12:00:00', 'Central Park, Marseille', 500, 'music.jpg');

-- Note: Admin user will be created via seed_admin.php script
-- Default credentials: admin / admin123