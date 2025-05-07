-- Drop the table if it exists
DROP TABLE IF EXISTS `owner_smtp`;

CREATE TABLE IF NOT EXISTS `owner_smtp` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `host` VARCHAR(255) NOT NULL,
    `port` VARCHAR(10) NOT NULL,
    `username` VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL,
    `setfrom` VARCHAR(255) NOT NULL,
    `replyto` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default SMTP settings
INSERT INTO `owner_smtp` (`id`, `host`, `port`, `username`, `password`, `setfrom`, `replyto`) 
VALUES (1, 'smtp-relay.brevo.com', '587', '', '', '', ''); 