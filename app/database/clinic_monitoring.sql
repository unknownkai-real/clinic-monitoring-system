CREATE DATABASE IF NOT EXISTS clinic_monitoring CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE clinic_monitoring;

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 username VARCHAR(50) UNIQUE NOT NULL,
 password_hash VARCHAR(255) NOT NULL,
 full_name VARCHAR(120) NOT NULL,
 role ENUM('admin','nurse','doctor','staff') NOT NULL DEFAULT 'staff',
 created_at TIMESTAMP NULL,
 updated_at TIMESTAMP NULL,
 deleted_at TIMESTAMP NULL
);
INSERT INTO users (username,password_hash,full_name,role,created_at,updated_at) VALUES
('admin','$2y$10$0Ob5w3Yf7vdv7nXmvGw2Vuv7hQHqomcM6po7fK1vNXX4v6jY1p2dG','System Administrator','admin',NOW(),NOW());

CREATE TABLE students (id INT AUTO_INCREMENT PRIMARY KEY, student_id VARCHAR(50) UNIQUE, first_name VARCHAR(80), last_name VARCHAR(80), course VARCHAR(120), department VARCHAR(120), medical_status VARCHAR(120), medical_note TEXT, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL);
CREATE TABLE employees (id INT AUTO_INCREMENT PRIMARY KEY, employee_id VARCHAR(50) UNIQUE, first_name VARCHAR(80), last_name VARCHAR(80), designation VARCHAR(120), department VARCHAR(120), medical_status VARCHAR(120), medical_note TEXT, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL);
CREATE TABLE medicines (id INT AUTO_INCREMENT PRIMARY KEY, medicine_name VARCHAR(120), brand VARCHAR(120), dosage VARCHAR(80), form VARCHAR(80), expiry_date DATE, quantity INT DEFAULT 0, low_stock_threshold INT DEFAULT 10, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL, INDEX(expiry_date));
CREATE TABLE equipments (id INT AUTO_INCREMENT PRIMARY KEY, equipment_name VARCHAR(120), brand VARCHAR(120), color_size VARCHAR(80), quantity INT DEFAULT 0, requested INT DEFAULT 0, created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL);
CREATE TABLE damaged_equipment (id INT AUTO_INCREMENT PRIMARY KEY, equipment_name VARCHAR(120), brand VARCHAR(120), color_size VARCHAR(80), quantity INT, description TEXT, reported_by VARCHAR(120), status VARCHAR(80) DEFAULT 'reported', created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL);
CREATE TABLE admissions (id INT AUTO_INCREMENT PRIMARY KEY, date DATE, time_in TIME, name VARCHAR(160), designation VARCHAR(100), reason TEXT, intervention TEXT, disposition VARCHAR(120), time_out TIME, clinic_staff_name VARCHAR(120), created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL, INDEX(date));
CREATE TABLE consultations (id INT AUTO_INCREMENT PRIMARY KEY, date DATE, name VARCHAR(160), designation VARCHAR(100), reason TEXT, diagnosis TEXT, follow_up_checkup VARCHAR(120), follow_up_lab VARCHAR(120), remarks TEXT, physician_name VARCHAR(120), created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL, INDEX(date));
CREATE TABLE borrowings (id INT AUTO_INCREMENT PRIMARY KEY, date DATE, name VARCHAR(160), designation VARCHAR(100), equipment_id INT, date_returned DATE NULL, remarks TEXT, clinic_staff VARCHAR(120), created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL, CONSTRAINT fk_borrow_equipment FOREIGN KEY (equipment_id) REFERENCES equipments(id));
CREATE TABLE first_aid_cases (id INT AUTO_INCREMENT PRIMARY KEY, cause VARCHAR(160), date DATE, time TIME, name VARCHAR(160), designation VARCHAR(100), treatment TEXT, disposition VARCHAR(120), clinic_staff_name VARCHAR(120), created_at TIMESTAMP NULL, updated_at TIMESTAMP NULL, deleted_at TIMESTAMP NULL);
CREATE TABLE activity_logs (id INT AUTO_INCREMENT PRIMARY KEY, user_id INT, action VARCHAR(50), module VARCHAR(50), record_id INT, details TEXT, created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP, INDEX(user_id), FOREIGN KEY (user_id) REFERENCES users(id));
