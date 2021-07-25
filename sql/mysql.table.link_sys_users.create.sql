CREATE TABLE IF NOT EXISTS link_sys_users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    user_name VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    little_salt CHAR(20) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_logged_in TIMESTAMP
) 
