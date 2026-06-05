-- Reset script for db_booking_lapangan_badminton
-- Drop tables if they exist (order matters due to foreign keys)

-- First, disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- Drop all tables
DROP TABLE IF EXISTS tb_setting;
DROP TABLE IF EXISTS tb_court_gallery;
DROP TABLE IF EXISTS tb_booking;
DROP TABLE IF EXISTS tb_court;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Optionally drop the database (uncomment if you want to remove it completely)
-- DROP DATABASE IF EXISTS db_booking_lapangan_badminton;
