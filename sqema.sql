CREATE DATABASE taskForce;
USE taskForce;

CREATE TABLE users (
    id int AUTO_INCREMENT PRIMARY KEY,
    date_registration DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_name VARCHAR(128),
    email VARCHAR(128) NOT NULL UNIQUE,
    user_password CHAR(12),
    city VARCHAR(128),
    user_role VARCHAR(128),
    `is_available` BOOLEAN
);

CREATE TABLE categories (
    id int AUTO_INCREMENT PRIMARY KEY,
    character_code VARCHAR(128) UNIQUE,
    name_category VARCHAR(128)
);

CREATE TABLE tasks (
    id int AUTO_INCREMENT PRIMARY KEY,
    date_public DATETIME DEFAULT CURRENT_TIMESTAMP,
    task_status_code VARCHAR(128) UNIQUE,
    task_status VARCHAR(128),
    title VARCHAR(128),
    task_description TEXT,
    task_file TEXT,
    budget INT,
    city INT,
    city_lon VARCHAR(128),
    city_lat VARCHAR(128),
    date_finish DATE,
    category_id INT,
    client_id INT,
    performer_id INT,
    FOREIGN KEY (category_id) REFERENCES categories(id),
    FOREIGN KEY (performer_id) REFERENCES users(id),
    FOREIGN KEY (client_id) REFERENCES users(id)
);

CREATE TABLE cities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city_name VARCHAR(128),
    city_lon VARCHAR(128),
    city_lat VARCHAR(128)
);

CREATE TABLE reviews (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_comment DATETIME DEFAULT CURRENT_TIMESTAMP,
    review_description TEXT,
    review_mark INT,
    reviewer INT,
    FOREIGN KEY (reviewer) REFERENCES users(id)
);

CREATE TABLE profile (
    id INT AUTO_INCREMENT PRIMARY KEY,
    img VARCHAR(255),
    birth_date DATE,
    user_description VARCHAR(128),
    telephone VARCHAR(128),
    telegram VARCHAR(128),
    mark_id INT,
    user_id INT,
    review_id INT,
    FOREIGN KEY (mark_id) REFERENCES reviews(id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (review_id) REFERENCES reviews(id)
);

CREATE TABLE response (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date_response DATETIME DEFAULT CURRENT_TIMESTAMP,
    response_description TEXT,
    price INT,
    performer INT,
    response_mark INT,
    FOREIGN KEY (performer) REFERENCES users(id),
);