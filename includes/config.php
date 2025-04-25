<?php
function getInitials($name) {
    $names = explode(' ', $name);
    $initials = '';
    foreach ($names as $n) {
        $initials .= strtoupper(substr($n, 0, 1));
    }
    return substr($initials, 0, 2);
}
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'tunisia_eco_travel');

// Site configuration
define('SITE_NAME', 'Tunisia Eco-Travel');
define('SITE_URL', 'http://localhost/tunisia-eco-travel');

// Start session
session_start();

// Connect to database
try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
    // Remove or comment out the error mode setting if it's causing issues
    // $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Include functions
require_once 'auth_functions.php';
require_once 'db_functions.php';

?>