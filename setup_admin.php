<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/functions.php';
$count = (int)$pdo->query("SELECT COUNT(*) FROM users WHERE role='admin'")->fetchColumn();
$message = '';
if ($count === 0) {
    $stmt = $pdo->prepare("INSERT INTO users (name,email,password,role) VALUES (?,?,?,'admin')");
    $stmt->execute(['ITUM System Admin','admin@itum.local',password_hash('ChangeMe@123',PASSWORD_DEFAULT)]);
    $message = 'Admin created. Email: admin@itum.local | Password: ChangeMe@123. Delete setup_admin.php now and change the password.';
} else $message = 'An administrator already exists. Delete this setup_admin.php file.';
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin setup</title></head><body style="font-family:Arial;padding:40px"><h2>ITUM Volunteer - Initial Admin Setup</h2><p><?= e($message) ?></p><p><a href="login.php">Go to login</a></p></body></html>
