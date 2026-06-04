-- Reset script for db_booking_lapangan_badminton
-- Drop tables if they exist (order matters due to foreign keys)
DROP TABLE IF EXISTS tb_setting;
DROP TABLE IF EXISTS tb_content;
DROP TABLE IF EXISTS tb_booking;
DROP TABLE IF EXISTS tb_court;
DROP TABLE IF EXISTS tb_user;
DROP TABLE IF EXISTS tb_admin;

-- Optionally drop the database (uncomment if you want to remove it completely)
-- DROP DATABASE IF EXISTS db_booking_lapangan_badminton;
