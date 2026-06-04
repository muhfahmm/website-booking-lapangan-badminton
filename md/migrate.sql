-- Migration script untuk upgrade table tb_court
-- Jalankan script ini untuk update struktur database

-- Add new columns to tb_court if not exists
ALTER TABLE tb_court MODIFY COLUMN name VARCHAR(100) NOT NULL;
ALTER TABLE tb_court ADD COLUMN location VARCHAR(150) DEFAULT 'Jakarta' AFTER name;
ALTER TABLE tb_court ADD COLUMN price_weekday INT DEFAULT 0 AFTER location;
ALTER TABLE tb_court ADD COLUMN price_weekend INT DEFAULT 0 AFTER price_weekday;
ALTER TABLE tb_court MODIFY COLUMN description TEXT;
ALTER TABLE tb_court ADD COLUMN size VARCHAR(50) DEFAULT '17m x 8.5m' AFTER description;
ALTER TABLE tb_court ADD COLUMN lighting VARCHAR(100) DEFAULT 'LED Standard' AFTER size;
ALTER TABLE tb_court ADD COLUMN parking VARCHAR(100) DEFAULT 'Tersedia' AFTER lighting;
ALTER TABLE tb_court ADD COLUMN floor_type VARCHAR(100) DEFAULT 'Vinyl/PVC' AFTER parking;
ALTER TABLE tb_court ADD COLUMN facilities TEXT AFTER floor_type;
ALTER TABLE tb_court ADD COLUMN status ENUM('tersedia', 'maintenance', 'booking') DEFAULT 'tersedia' AFTER facilities;
ALTER TABLE tb_court ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER created_at;

-- Drop old price_per_hour column if it exists
ALTER TABLE tb_court DROP COLUMN IF EXISTS price_per_hour;

-- Create gallery table
CREATE TABLE IF NOT EXISTS tb_court_gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    court_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    image_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (court_id) REFERENCES tb_court(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
