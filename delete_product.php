<?php
session_start();
include_once './php/db.php';

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'seller') {
    header("Location: login.php");
    exit;
}

if (empty($_GET['id'])) {
    echo "Error: Product ID is required.";
    exit;
}

$product_id = $_GET['id'];

try {
    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->execute([$product_id]);
} catch (PDOException $e) {
    echo "Error deleting product: " . $e->getMessage();
    exit;
}

header("Location: admin_products.php");
exit;
?>
