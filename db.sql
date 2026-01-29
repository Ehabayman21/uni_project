CREATE DATABASE IF NOT EXISTS uni_app DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE uni_app;

-- جدول المستخدمين (الطلاب/المستخدمين)
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  full_name VARCHAR(150),
  role ENUM('student','admin') DEFAULT 'student',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- جدول المقررات/المواد
CREATE TABLE courses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(20) NOT NULL UNIQUE,
  title VARCHAR(150) NOT NULL,
  description TEXT,
  credits INT DEFAULT 3
);

-- جدول تسجيل المواد (Enrollment)
CREATE TABLE registrations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  course_id INT NOT NULL,
  registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE,
  UNIQUE(user_id, course_id)
);

-- بيانات تجريبية
INSERT INTO courses (code, title, description, credits) VALUES
('CS101','Introduction to CS','مقدمة في علوم الحاسب',3),
('DB201','Database Systems','نظم قواعد البيانات',3),
('STAT101','Statistics','مبادئ الإحصاء',3);
