CREATE DATABASE IF NOT EXISTS todolist_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE todolist_db;

CREATE TABLE IF NOT EXISTS tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    priority ENUM('low', 'normal', 'high') NOT NULL DEFAULT 'normal',
    date DATE NOT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0
);

INSERT INTO tasks (title, completed, priority, date, deleted) VALUES
('Buy groceries', 0, 'low', '2025-07-19', 0),
('Take the dog for a walk', 0, 'high', '2025-07-15', 0),
('Go to the gym', 0, 'normal', '2025-07-15', 0),
('Finish the project report', 1, 'high', '2025-07-10', 0),
('Read a book', 1, 'low', '2025-07-25', 0),
('Make dinner', 1, 'low', '2025-07-25', 1),
('Fix phone', 0, 'low', '2025-07-25', 1);
