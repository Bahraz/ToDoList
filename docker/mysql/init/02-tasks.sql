CREATE DATABASE IF NOT EXISTS todolist_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE todolist_db;

CREATE TABLE IF NOT EXISTS tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL,
    title VARCHAR(255) NOT NULL,
    completed TINYINT(1) NOT NULL DEFAULT 0,
    priority ENUM('low', 'normal', 'high') NOT NULL DEFAULT 'normal',
    date DATE NOT NULL,
    deleted TINYINT(1) NOT NULL DEFAULT 0,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO tasks (user_id, title, completed, priority, date, deleted) VALUES
(1, 'Buy groceries', 0, 'low', '2025-08-18', 0),
(1, 'Clean the kitchen', 1, 'low', '2025-08-21', 0),

(1, 'Write report', 0, 'normal', '2025-08-18', 0),
(1, 'Go jogging', 1, 'normal', '2025-08-23', 0),

(1, 'Fix the server issue', 0, 'high', '2025-08-18', 0),
(1, 'Prepare presentation', 1, 'high', '2025-08-25', 0),

(1, 'Old shopping list', 0, 'low', '2025-08-18', 1),
(1, 'Canceled meeting prep', 1, 'normal', '2025-08-12', 1);

INSERT INTO tasks (user_id, title, completed, priority, date, deleted) VALUES
(2, 'Read a book', 0, 'low', '2025-08-18', 0),
(2, 'Do laundry', 1, 'low', '2025-08-21', 0),

(2, 'Update CV', 0, 'normal', '2025-08-18', 0),
(2, 'Plan weekend trip', 1, 'normal', '2025-08-23', 0),

(2, 'Prepare dinner party', 0, 'high', '2025-08-18', 0),
(2, 'Finish coding task', 1, 'high', '2025-08-25', 0),

(2, 'Abandoned blog draft', 0, 'normal', '2025-08-18', 1),
(2, 'Old shopping task', 1, 'high', '2025-08-12', 1);