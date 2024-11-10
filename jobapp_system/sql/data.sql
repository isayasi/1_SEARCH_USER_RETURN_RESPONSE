CREATE TABLE applicants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20) NOT NULL,
    address VARCHAR(255),
    position VARCHAR(50) NOT NULL,
    date_applied TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
