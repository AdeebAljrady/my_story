<?php
session_start();
include_once 'php/db.php';

function handleAddToCart($conn, $product_id)
{
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // Check if the product is already in the cart
        $stmt = $conn->prepare("SELECT * FROM shopping_cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $cart_item = $stmt->fetch();

        if ($cart_item) {
            // If product is already in cart, update the quantity
            $update_stmt = $conn->prepare("UPDATE shopping_cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
            $update_stmt->execute([$user_id, $product_id]);
        } else {
            // If not, add new entry to the cart
            $insert_stmt = $conn->prepare("INSERT INTO shopping_cart (user_id, product_id, quantity) VALUES (?, ?, 1)");
            $insert_stmt->execute([$user_id, $product_id]);
        }

        header('Location: shopping_cart.php');
        exit;
    } else {
        header('Location: login.php');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_to_cart'])) {
    handleAddToCart($conn, $_POST['product_id']);
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قطعتي</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
<div class="landing-page">
    <?php require "./php/header.php" ?>
    <div class="content">
        <div class="container">
            <div class="info">
                <h1>مرحبًا بك في متجر قطعتي لبيع قطع السيارات</h1>
                <p>استكشف مجموعة منتجاتنا الواسعة من قطع الغيار لمختلف أنواع السيارات والموديلات. نحن نقدم أفضل الأسعار وأعلى جودة لضمان رضاك التام.</p>
                <a href="products.php"><button>تصفح المنتجات</button></a>
                <a href="contact.php"><button>تواصل معنا</button></a>
            </div>
            <div class="image">
                <img src="img/card.png" alt="صورة قطع غيار السيارات">
            </div>
        </div>
    </div>
    <div class="section_title text-center">
        <h2>تصنيفات القطع</h2>
        <div class="brand_border">
            <i class="fa fa-minus" aria-hidden="true"></i>
            <i class="fas fa-tools" aria-hidden="true"></i>
            <i class="fa fa-minus" aria-hidden="true"></i>
        </div>
        <p>استكشاف مجموعة واسعة من التصنيفات لقطع الغيار لمختلف أنواع السيارات.</p>
    </div>
    <div class="category-links container">
        <div class="category">
            <a href="./products.php?category=قطع%20غيار">
                <i class="fas fa-cogs"></i>
                <span>قطع غيار</span>
            </a>
        </div>
        <div class="category">
            <a href="./products.php?category=جنوط">
                <i class="fas fa-circle"></i>
                <span>جنوط</span>
            </a>
        </div>
        <div class="category">
            <a href="./products.php?category=شاشات">
                <i class="fas fa-tv"></i>
                <span>شاشات</span>
            </a>
        </div>
        <div class="category">
            <a href="./products.php?category=مسجلات">
                <i class="fas fa-microphone"></i>
                <span>مسجلات</span>
            </a>
        </div>
    </div>
    <div class="section_title text-center">
        <h2>أحدث منتجاتنا</h2>
        <div class="brand_border">
            <i class="fa fa-minus" aria-hidden="true"></i>
            <i class="fas fa-cogs" aria-hidden="true"></i>
            <i class="fa fa-minus" aria-hidden="true"></i>
        </div>
        <p>استكشاف مجموعة واسعة من التصنيفات لقطع الغيار لمختلف أنواع السيارات.</p>
    </div>
    <div class="product-gallery container">
        <?php
        $stmt = $conn->query("SELECT * FROM products LIMIT 13");
        while ($product = $stmt->fetch()) {
            echo '<div class="product-card">';
            echo '<img class="product-image" src="' . $product['image'] . '" alt="' . $product['name'] . '">';
            echo '<div class="product-details">';
            echo '<div class="info-row">';
            echo '<p class="product-name"><i class="fa fa-cog"></i> ' . $product['name'] . '</p>';
            echo '<p class="product-price"><i class="fa fa-tag"></i> ' . $product['price'] . ' ر.س</p>';
            echo '</div>';
            echo '<div class="info-row">';
            echo '<p class="product-location"><i class="fa fa-map-marker"></i> ' . $product['city'] . '</p>';
            echo '<p class="product-seller"><i class="fa fa-user"></i><span>البائع :</span> ' . $product['seller'] . '</p>';
            echo '</div>';
            echo '<div class="button-row">';
            echo '<form method="post">';
            echo '<input type="hidden" name="product_id" value="' . $product['product_id'] . '">';
            echo '<button type="submit" name="add_to_cart"><i class="fa fa-cart-plus"></i> أضف للسلة</button>';
            echo '</form>';
            echo '<button class="button-more-info"><i class="fa fa-info-circle"></i> المزيد</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>
    <div class="section_title text-center">
        <h2>مميزاتنا</h2>
        <div class="brand_border">
            <i class="fa fa-minus" aria-hidden="true"></i>
            <i class="fas fa-cogs" aria-hidden="true"></i>
            <i class="fa fa-minus" aria-hidden="true"></i>
        </div>
        <p>استكشاف مجموعة واسعة من التصنيفات لقطع الغيار لمختلف أنواع السيارات.</p>
    </div>
    <section class="features container">
        <div class="feature">
            <i class="fas fa-tools"></i>
            <h2>جودة مضمونة</h2>
            <p>نقدم فقط قطع غيار أصلية مضمونة لضمان أعلى أداء وأمان لسيارتك.</p>
            <a href="about.php" class="more-btn">معرفة المزيد</a>
        </div>
        <div class="feature">
            <i class="fas fa-shipping-fast"></i>
            <h2>توصيل سريع</h2>
            <p>خدمة توصيل فعالة وسريعة لقطع الغيار في جميع أنحاء المنطقة، مما يقلل من وقت الانتظار.</p>
            <a href="about.php" class="more-btn">معرفة المزيد</a>
        </div>
        <div class="feature">
            <i class="fas fa-shield-alt"></i>
            <h2>ضمان الرضا</h2>
            <p>نقدم ضمانات شاملة على جميع قطع الغيار لضمان رضاكم وثقتكم بمنتجاتنا.</p>
            <a href="about.php" class="more-btn">معرفة المزيد</a>
        </div>
        <div class="feature">
            <i class="fas fa-headset"></i>
            <h2>دعم فني</h2>
            <p>فريق دعم فني متخصص متواجد على مدار الساعة لمساعدتك في اختيار القطع الأمثل وحل أي استفسارات.</p>
            <a  href="about.php" class="more-btn">معرفة المزيد</a>
        </div>
    </section>
    <?php require "./php/footer.php" ?>
</div>
</body>
</html>
