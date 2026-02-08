<?php
global $conn;
session_start();
require './php/db.php';

if (isset($_POST['cart_id'], $_POST['quantity']) && $_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['remove'])) {
    $cartId = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("UPDATE shopping_cart SET quantity = ? WHERE cart_id = ?");
    $stmt->execute([$quantity, $cartId]);

    $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    $stmt = $conn->prepare("SELECT p.price, sc.quantity FROM shopping_cart sc JOIN products p ON sc.product_id = p.product_id WHERE sc.user_id = ?");
    $stmt->execute([$userId]);
    
    $subtotal = 0;
    while ($row = $stmt->fetch()) {
        $subtotal += $row['price'] * $row['quantity'];
    }

    $taxRate = 0.05;
    $tax = $subtotal * $taxRate;
    $shipping = $subtotal > 0 ? 50.00 : 0;
    $total = $subtotal + $tax + $shipping;

    echo json_encode(array('subtotal' => $subtotal, 'tax' => $tax, 'total' => $total));
    exit;
}

if (isset($_POST['remove']) && isset($_POST['cart_id'])) {
    $stmt = $conn->prepare("DELETE FROM shopping_cart WHERE cart_id = ?");
    $stmt->execute([$_POST['cart_id']]);
    header("Location: shopping_cart.php");
    exit;
}

$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
$stmt = $conn->prepare("SELECT sc.cart_id, sc.quantity, p.name, p.price, p.image 
        FROM shopping_cart sc
        JOIN products p ON sc.product_id = p.product_id
        WHERE sc.user_id = ?");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll();

$subtotal = 0;
foreach ($cartItems as $item) {
    $subtotal += $item['price'] * $item['quantity'];
}
$taxRate = 0.05;
$tax = $subtotal * $taxRate;
$shipping = $subtotal > 0 ? 50.00 : 0;
$total = $subtotal + $tax + $shipping;
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>السلة</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/shopping_cart.css">
</head>
<body>
<div class="landing-page shopping-cart-page">
    <?php require "./php/header.php" ?>
    <div class="section_title text-center">
        <h2>سلة التسوق</h2>
        <div class="brand_border">
            <i class="fa fa-minus" aria-hidden="true"></i>
            <i class="fas fa-shopping-cart" aria-hidden="true"></i>
            <i class="fa fa-minus" aria-hidden="true"></i>
        </div>
        <p>تسوق منتجاتك المفضلة بكل سهولة وراحة.</p>
    </div>
    <div class="container">
        <div class="shopping-cart">
            <div class="column-labels">
                <label class="product-image">صورة</label>
                <label class="product-details">المنتج</label>
                <label class="product-price">السعر</label>
                <label class="product-quantity">الكمية</label>
                <label class="product-removal">حذف</label>
                <label class="product-line-price">المجموع</label>
            </div>
            <?php foreach ($cartItems as $item): ?>
                <div class="product">
                    <div class="product-image">
                        <img src="<?= $item['image'] ?>" alt="">
                    </div>
                    <div class="product-details">
                        <div class="product-title"><?= $item['name'] ?></div>
                    </div>
                    <div class="product-price"><?= number_format($item['price'], 2) ?></div>
                    <div class="product-quantity">
                        <input type="number" id="quantity_<?= $item['cart_id'] ?>" value="<?= $item['quantity'] ?>" min="1" onchange="updateQuantity(<?= $item['cart_id'] ?>, this.value)">
                    </div>
                    <div class="product-removal">
                        <form method="post">
                            <input type="hidden" name="cart_id" value="<?= $item['cart_id'] ?>">
                            <input type="hidden" name="remove" value="1">
                            <button type="submit" class="remove-product">حذف</button>
                        </form>
                    </div>
                    <div class="product-line-price"><?= number_format($item['price'] * $item['quantity'], 2) ?></div>
                </div>
            <?php endforeach; ?>
            <div class="totals">
                <div class="totals-item">
                    <label>المجموع الفرعي</label>
                    <div class="totals-value" id="cart-subtotal"><?= number_format($subtotal, 2) ?></div>
                </div>
                <div class="totals-item">
                    <label>الضريبة (5%)</label>
                    <div class="totals-value" id="cart-tax"><?= number_format($tax, 2) ?></div>
                </div>
                <div class="totals-item">
                    <label>الشحن</label>
                    <div class="totals-value" id="cart-shipping"><?= number_format($shipping, 2) ?></div>
                </div>
                <div class="totals-item totals-item-total">
                    <label>المجموع الكلي</label>
                    <div class="totals-value" id="cart-total"><?= number_format($total, 2) ?></div>
                </div>
            </div>
            <button class="checkout" onclick="alert('تم الشراء')">إتمام الشراء</button>
        </div>
    </div>
    <?php require "./php/footer.php" ?>
</div>
<script>
    function updateQuantity(cartId, newQuantity) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('cart-subtotal').textContent = response.subtotal.toFixed(2);
                    document.getElementById('cart-tax').textContent = response.tax.toFixed(2);
                    document.getElementById('cart-total').textContent = response.total.toFixed(2);
                }
            }
        };
        xhr.send('cart_id=' + cartId + '&quantity=' + newQuantity);
    }
</script>
</body>
</html>
