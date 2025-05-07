-- Drop the table if it exists
DROP TABLE IF EXISTS `owner`;

CREATE TABLE IF NOT EXISTS `owner` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user with Argon2 hashed password (12345)
INSERT INTO `owner` (`email`, `password`) VALUES 
('admin@gmail.com', '12345'); 