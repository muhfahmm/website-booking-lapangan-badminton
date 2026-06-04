<?php
// Database connection using PDO
$host = 'localhost';
$db = 'db_booking_lapangan_badminton';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection Error: ' . $e->getMessage());
}
?>
