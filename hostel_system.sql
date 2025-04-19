-- Create the database
CREATE DATABASE IF NOT EXISTS hostel_system;
USE hostel_system;

-- Table: users (For both students and admins)
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    student_id VARCHAR(50) UNIQUE,
    email VARCHAR(100),
    password VARCHAR(255),
    user_type ENUM('student', 'admin') DEFAULT 'student'
);

-- Table: room_requests (For students' room requests)
CREATE TABLE IF NOT EXISTS room_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    room_no VARCHAR(10),
    status VARCHAR(20) DEFAULT 'pending',
    request_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table: rooms (For room availability and assignment)
CREATE TABLE IF NOT EXISTS rooms (
    room_no VARCHAR(10) PRIMARY KEY,
    is_available BOOLEAN DEFAULT 1,
    assigned_to VARCHAR(50) DEFAULT NULL
);

-- Table: payments (For recording student payments)
CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id VARCHAR(50),
    room_no VARCHAR(10),
    amount DECIMAL(10, 2),
    payment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);