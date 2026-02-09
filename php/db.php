<?php
// Vercel / Supabase Connection using PDO PostgreSQL
$host = getenv('DB_HOST');
$port = getenv('DB_PORT') ?: '5432';
$dbname = getenv('DB_NAME');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $conn = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    
    // Compatibility layer for mysqli-style calls if needed
    // Note: It's better to refactor the code to use PDO globally.
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}
?>
