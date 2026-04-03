CREATE DATABASE IF NOT EXISTS taghazout_surf_db CHARACTER SET utf8mb4;
USE taghazout_surf_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'student') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL 
) ENGINE=InnoDB;


CREATE TABLE students (
    id_user INT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    country VARCHAR(50),
    level ENUM('Beginner', 'Intermediate', 'Advanced') NOT NULL DEFAULT 'Beginner',
    CONSTRAINT fk_student_user FOREIGN KEY (id_user) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;


CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    coach_name VARCHAR(100) NOT NULL,
    lesson_date DATETIME NOT NULL,
    max_capacity INT DEFAULT 10,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    deleted_at DATETIME DEFAULT NULL 
) ENGINE=InnoDB;


CREATE TABLE enrollments (
    id_student INT,
    id_lesson INT,
    payment_status ENUM('Paid', 'Pending') NOT NULL DEFAULT 'Pending',
    enrolled_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id_student, id_lesson),
    CONSTRAINT fk_enroll_student FOREIGN KEY (id_student) REFERENCES students(id_user) ON DELETE CASCADE,
    CONSTRAINT fk_enroll_lesson FOREIGN KEY (id_lesson) REFERENCES lessons(id) ON DELETE CASCADE
) ENGINE=InnoDB;

ALTER TABLE `lessons` 
ADD `price` DECIMAL(10, 2) NOT NULL DEFAULT '0.00' 
AFTER `lesson_date`;