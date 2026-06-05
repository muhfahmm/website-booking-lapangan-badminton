<?php
/**
 * Admin Panel - Auto Redirect to Login
 * Mengarahkan akses /admin/ langsung ke /admin/login.php
 */

// Redirect ke login page
header('Location: login.php', true, 302);
exit;
?>
