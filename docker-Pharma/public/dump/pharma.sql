-- Create Database
CREATE DATABASE IF NOT EXISTS pharmacy_db;

-- Use the created database
USE pharmacy_db;

-- Create Users Table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'pharmacist') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Medicines Table
CREATE TABLE IF NOT EXISTS medicines (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create Prescriptions Table
CREATE TABLE IF NOT EXISTS prescriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_name VARCHAR(100) NOT NULL,
    medicine_id INT NOT NULL,
    quantity INT NOT NULL,
    prescription_date DATE NOT NULL,
    FOREIGN KEY (medicine_id) REFERENCES medicines(id) ON DELETE CASCADE
);

-- Insert Initial Admin User
INSERT INTO users (username, password, role) VALUES 
('admin', 'adminpassword', 'admin');

-- Example Insert Data for Medicines (you can remove or modify these based on your actual data)
INSERT INTO medicines (name, description, price, quantity) VALUES
('Paracetamol', 'Used for relieving pain and fever', 10.00, 100),
('Amoxicillin', 'Antibiotic for treating infections', 50.00, 200),
('Ibuprofen', 'Anti-inflammatory for pain relief', 15.00, 150);

-- Example Insert Data for Prescriptions (optional, for testing purposes)
INSERT INTO prescriptions (patient_name, medicine_id, quantity, prescribed_by, prescription_date) VALUES
('John Doe', 1, 2, 'Dr. Smith', '2024-08-01'),
('Jane Roe', 2, 1, 'Dr. Doe', '2024-08-02');
