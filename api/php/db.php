<?php
// Supabase Pooler connection (Vercel-safe)

$databaseUrl = getenv('DATABASE_URL');

if (!$databaseUrl) {
    die('DATABASE_URL is not defined');
}

try {
    $conn = new PDO($databaseUrl, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}