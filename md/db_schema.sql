-- Database: db_booking_lapangan_badminton
-- Create database
CREATE DATABASE IF NOT EXISTS db_booking_lapangan_badminton;
USE db_booking_lapangan_badminton;

-- Table: tb_court (badminton courts)
CREATE TABLE IF NOT EXISTS tb_court (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    location VARCHAR(150) DEFAULT 'Jakarta',
    price_weekday INT DEFAULT 0,
    price_weekend INT DEFAULT 0,
    status ENUM('tersedia', 'maintenance', 'booking') DEFAULT 'tersedia',
    description TEXT,
    size VARCHAR(50) DEFAULT '17m x 8.5m',
    lighting VARCHAR(100) DEFAULT 'LED Standard',
    parking VARCHAR(100) DEFAULT 'Tersedia',
    floor_type VARCHAR(100) DEFAULT 'Vinyl/PVC',
    facilities TEXT,
    image_url VARCHAR(255),
    map_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: tb_booking (court reservations)
CREATE TABLE IF NOT EXISTS tb_booking (
    id INT AUTO_INCREMENT PRIMARY KEY,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    court_id INT NOT NULL,
    start_time DATETIME NOT NULL,
    end_time DATETIME NOT NULL,
    status ENUM('pending','confirmed','cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (court_id) REFERENCES tb_court(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: tb_court_gallery (court images gallery)
CREATE TABLE IF NOT EXISTS tb_court_gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    court_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    image_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (court_id) REFERENCES tb_court(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table: tb_setting (site-wide settings, optional)
CREATE TABLE IF NOT EXISTS tb_setting (
    id INT AUTO_INCREMENT PRIMARY KEY,
    `key` VARCHAR(100) NOT NULL UNIQUE,
    `value` TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- End of schema

-- ============================================================================
-- MIGRATION REFERENCE (For upgrading existing database)
-- ============================================================================
-- If you have existing data and need to update table structure, run these:
-- 
-- ALTER TABLE tb_court MODIFY COLUMN name VARCHAR(100) NOT NULL;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS location VARCHAR(150) DEFAULT 'Jakarta' AFTER name;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS price_weekday INT DEFAULT 0 AFTER location;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS price_weekend INT DEFAULT 0 AFTER price_weekday;
-- ALTER TABLE tb_court MODIFY COLUMN description TEXT;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS size VARCHAR(50) DEFAULT '17m x 8.5m' AFTER description;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS lighting VARCHAR(100) DEFAULT 'LED Standard' AFTER size;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS parking VARCHAR(100) DEFAULT 'Tersedia' AFTER lighting;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS floor_type VARCHAR(100) DEFAULT 'Vinyl/PVC' AFTER parking;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS facilities TEXT AFTER floor_type;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS map_url TEXT AFTER image_url;
-- ALTER TABLE tb_court ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;
-- ALTER TABLE tb_court DROP COLUMN IF EXISTS price_per_hour;
--
-- ============================================================================
