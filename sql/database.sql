-- EduPlatform BD 2026 Database Structure
-- সম্পূর্ণ ডাটাবেস স্ট্রাকচার

CREATE DATABASE IF NOT EXISTS eduplatform_2026;
USE eduplatform_2026;

-- ব্যবহারকারী টেবিল
CREATE TABLE IF NOT EXISTS edu_users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    profile_image VARCHAR(255),
    division VARCHAR(50),
    school_name VARCHAR(100),
    board VARCHAR(50),
    batch_year INT,
    role ENUM('user', 'instructor', 'admin') DEFAULT 'user',
    status ENUM('active', 'inactive', 'suspended') DEFAULT 'inactive',
    email_verified TINYINT(1) DEFAULT 0,
    verification_token VARCHAR(255),
    password_reset_token VARCHAR(255),
    last_login DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (email),
    INDEX (role),
    INDEX (status)
);

-- কোর্স টেবিল
CREATE TABLE IF NOT EXISTS edu_courses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_code VARCHAR(50) UNIQUE NOT NULL,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    thumbnail VARCHAR(255),
    instructor_id INT,
    price DECIMAL(10, 2) DEFAULT 0,
    discount_price DECIMAL(10, 2),
    category VARCHAR(100),
    level ENUM('beginner', 'intermediate', 'advanced') DEFAULT 'beginner',
    duration_days INT,
    total_lessons INT,
    status ENUM('active', 'inactive', 'draft') DEFAULT 'draft',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (instructor_id) REFERENCES edu_users(id),
    INDEX (status),
    INDEX (category)
);

-- এনরোলমেন্ট টেবিল
CREATE TABLE IF NOT EXISTS edu_enrollments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    enrollment_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    completion_date DATETIME,
    progress_percentage DECIMAL(5, 2) DEFAULT 0,
    status ENUM('active', 'completed', 'dropped') DEFAULT 'active',
    paid TINYINT(1) DEFAULT 0,
    payment_date DATETIME,
    payment_method VARCHAR(50),
    transaction_id VARCHAR(100),
    FOREIGN KEY (user_id) REFERENCES edu_users(id),
    FOREIGN KEY (course_id) REFERENCES edu_courses(id),
    UNIQUE KEY unique_enrollment (user_id, course_id),
    INDEX (status),
    INDEX (paid)
);

-- লেসন টেবিল
CREATE TABLE IF NOT EXISTS edu_lessons (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT,
    video_url VARCHAR(255),
    resources VARCHAR(255),
    order_no INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES edu_courses(id),
    INDEX (course_id),
    INDEX (order_no)
);

-- কুইজ টেবিল
CREATE TABLE IF NOT EXISTS edu_quizzes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    course_id INT NOT NULL,
    lesson_id INT,
    title VARCHAR(255) NOT NULL,
    total_questions INT,
    passing_score DECIMAL(5, 2) DEFAULT 50,
    time_limit INT,
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (course_id) REFERENCES edu_courses(id),
    FOREIGN KEY (lesson_id) REFERENCES edu_lessons(id),
    INDEX (course_id)
);

-- কুইজ প্রশ্ন টেবিল
CREATE TABLE IF NOT EXISTS edu_quiz_questions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    quiz_id INT NOT NULL,
    question_text TEXT NOT NULL,
    question_type ENUM('multiple_choice', 'true_false', 'short_answer') DEFAULT 'multiple_choice',
    option_a VARCHAR(255),
    option_b VARCHAR(255),
    option_c VARCHAR(255),
    option_d VARCHAR(255),
    correct_answer VARCHAR(10),
    explanation TEXT,
    order_no INT,
    FOREIGN KEY (quiz_id) REFERENCES edu_quizzes(id),
    INDEX (quiz_id)
);

-- কুইজ উত্তর টেবিল
CREATE TABLE IF NOT EXISTS edu_quiz_answers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    quiz_id INT NOT NULL,
    user_id INT NOT NULL,
    question_id INT NOT NULL,
    user_answer VARCHAR(255),
    is_correct TINYINT(1),
    answered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (quiz_id) REFERENCES edu_quizzes(id),
    FOREIGN KEY (user_id) REFERENCES edu_users(id),
    FOREIGN KEY (question_id) REFERENCES edu_quiz_questions(id),
    INDEX (user_id),
    INDEX (quiz_id)
);

-- কুইজ ফলাফল টেবিল
CREATE TABLE IF NOT EXISTS edu_quiz_results (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    quiz_id INT NOT NULL,
    score DECIMAL(5, 2),
    total_marks DECIMAL(5, 2),
    percentage DECIMAL(5, 2),
    passed TINYINT(1),
    attempt_number INT DEFAULT 1,
    completed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES edu_users(id),
    FOREIGN KEY (quiz_id) REFERENCES edu_quizzes(id),
    INDEX (user_id),
    INDEX (quiz_id),
    INDEX (passed)
);

-- প্রগতি ট্র্যাকিং টেবিল
CREATE TABLE IF NOT EXISTS edu_progress (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    course_id INT NOT NULL,
    lesson_id INT,
    completed_at DATETIME,
    time_spent INT,
    FOREIGN KEY (user_id) REFERENCES edu_users(id),
    FOREIGN KEY (course_id) REFERENCES edu_courses(id),
    FOREIGN KEY (lesson_id) REFERENCES edu_lessons(id),
    UNIQUE KEY unique_progress (user_id, lesson_id),
    INDEX (course_id)
);

-- লিডারবোর্ড টেবিল
CREATE TABLE IF NOT EXISTS edu_leaderboard (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    course_id INT,
    total_points INT DEFAULT 0,
    correct_answers INT DEFAULT 0,
    quizzes_attempted INT DEFAULT 0,
    week_points INT DEFAULT 0,
    last_updated TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES edu_users(id),
    INDEX (total_points),
    INDEX (week_points)
);

-- নোটিফিকেশন টেবিল
CREATE TABLE IF NOT EXISTS edu_notifications (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    message TEXT,
    type VARCHAR(50),
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES edu_users(id),
    INDEX (user_id),
    INDEX (is_read)
);

-- সাইট সেটিংস টেবিল
CREATE TABLE IF NOT EXISTS edu_settings (
    id INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(255) UNIQUE NOT NULL,
    setting_value LONGTEXT,
    setting_type VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX (setting_key)
);

-- পেমেন্ট টেবিল
CREATE TABLE IF NOT EXISTS edu_payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    course_id INT,
    amount DECIMAL(10, 2),
    payment_method VARCHAR(50),
    transaction_id VARCHAR(100) UNIQUE,
    status ENUM('pending', 'completed', 'failed', 'refunded') DEFAULT 'pending',
    payment_date DATETIME,
    reference_no VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES edu_users(id),
    FOREIGN KEY (course_id) REFERENCES edu_courses(id),
    INDEX (status),
    INDEX (user_id)
);

-- অ্যাক্টিভিটি লগ টেবিল
CREATE TABLE IF NOT EXISTS edu_activity_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    action VARCHAR(255),
    entity_type VARCHAR(50),
    entity_id INT,
    description TEXT,
    ip_address VARCHAR(50),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (user_id),
    INDEX (action),
    INDEX (created_at)
);

-- ডিফল্ট অ্যাডমিন ব্যবহারকারী তৈরি করুন
INSERT INTO edu_users (email, password, full_name, role, status, email_verified) 
VALUES ('admin@eduplatform.com.bd', SHA2('admin@123', 256), 'Admin User', 'admin', 'active', 1);

-- ডিফল্ট সেটিংস
INSERT INTO edu_settings (setting_key, setting_value, setting_type) VALUES
('site_name', 'EduPlatform BD 2026', 'text'),
('site_email', 'info@eduplatform.com.bd', 'text'),
('site_phone', '01700-000000', 'text'),
('currency', 'BDT', 'text'),
('maintenance_mode', '0', 'boolean'),
('user_registration_enabled', '1', 'boolean'),
('course_price_default', '99', 'number');
