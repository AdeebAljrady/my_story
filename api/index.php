<?php

session_start();

include_once 'php/db.php';



// Create Users table

$sqlUsers = "CREATE TABLE IF NOT EXISTS users (

    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,

    firstName VARCHAR(30) NOT NULL,

    lastName VARCHAR(30) NOT NULL,

    email VARCHAR(50) NOT NULL UNIQUE,

    password VARCHAR(255) NOT NULL,

    accountType ENUM('seller', 'user') DEFAULT 'user',

    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP

)";



if ($conn->query($sqlUsers) !== TRUE) {

    die("Error creating Users table: " . $conn->error);

}



// Create Products table

$sqlProducts = "CREATE TABLE IF NOT EXISTS products (

    product_id INT AUTO_INCREMENT PRIMARY KEY,

    name VARCHAR(255) NOT NULL,

    seller VARCHAR(255) NOT NULL,

    city VARCHAR(100) NOT NULL,

    price DECIMAL(10, 2) NOT NULL,

    image VARCHAR(255) NOT NULL,

    type VARCHAR(255) NOT NULL,

    created_at DATETIME DEFAULT CURRENT_TIMESTAMP

)";

if ($conn->query($sqlProducts) !== TRUE) {

    die("Error creating Products table: " . $conn->error);

}



// Create Shopping Cart table

$sqlShoppingCart = "CREATE TABLE IF NOT EXISTS shopping_cart (

    cart_id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    product_id INT NOT NULL,

    quantity INT DEFAULT 1,

    added_on DATETIME DEFAULT CURRENT_TIMESTAMP

)";

if ($conn->query($sqlShoppingCart) !== TRUE) {

    die("Error creating Shopping Cart table: " . $conn->error);

}

$sqlCheckEmpty = "SELECT COUNT(*) AS cnt FROM products";

$result = $conn->query($sqlCheckEmpty);

$row = $result->fetch_assoc();

if ($row['cnt'] == 0) {

    $sqlInsertDummy = "INSERT INTO products (name, seller, city, price, image, type) VALUES

    ('قطع غيار ', 'بائع 1', 'الرياض', 100.00, 'img/image1.png', 'قطع غيار'),

    ('قطع غيار', 'بائع 2', 'جدة', 300.00, 'img/image2.png', 'جنوط'),

    ('قطع غيار', 'بائع 3', 'الخبر', 450.00, 'img/image3.png', 'شاشات'),

    (' قطع غيار', 'بائع 4', 'الدمام', 250.00, 'img/image4.png', 'مسجلات'),

    ('قطع غيار ', 'بائع 5', 'الطائف', 150.00, 'img/image5.png', 'قطع غيار'),

    (' قطع غيار', 'بائع 6', 'الرياض', 350.00, 'img/image6.png', 'جنوط'),

    (' قطع غيار', 'بائع 7', 'جدة', 500.00, 'img/image7.png', 'شاشات'),

    (' قطع غيار', 'بائع 8', 'الخبر', 200.00, 'img/image8.png', 'مسجلات'),

    ('قطع غيار  ', 'بائع 9', 'الدمام', 120.00, 'img/image9.png', 'قطع غيار'),

    (' قطع غيار', 'بائع 10', 'الطائف', 320.00, 'img/image10.png', 'جنوط'),

    (' قطع غيار', 'بائع 11', 'الطائف', 370.00, 'img/image13.png', 'جنوط'),

    (' قطع غيار', 'بائع 12', 'الطائف', 120.00, 'img/image14.png', 'جنوط'),

    ('قطع غيار ', 'بائع 13', 'الرياض', 280.00, 'img/image15.png', 'شاشات'),

    ('قطع غيار', 'بائع 14', 'جدة', 180.00, 'img/image16.png', 'مسجلات'),

    ('قطع غيار', 'بائع 15', 'الدمام', 400.00, 'img/image17.png', 'جنوط'),

    ('قطع غيار ', 'بائع 16', 'الخبر', 230.00, 'img/image18.png', 'قطع غيار')";

    if ($conn->query($sqlInsertDummy) !== TRUE) {

        die("Error inserting dummy data: " . $conn->error);

    }

}
function handleAddToCart($conn, $product_id)

{

    if (isset($_SESSION['user_id'])) { // Check if the user is logged in

        $user_id = $_SESSION['user_id']; // The user's ID from the session



        // Check if the product is already in the cart

        $check_cart = "SELECT * FROM shopping_cart WHERE user_id = $user_id AND product_id = $product_id";

        $cart_result = mysqli_query($conn, $check_cart);



        if (mysqli_num_rows($cart_result) > 0) {

            // If product is already in cart, update the quantity

            $update_query = "UPDATE shopping_cart SET quantity = quantity + 1 WHERE user_id = $user_id AND product_id = $product_id";

            mysqli_query($conn, $update_query);

        } else {

            // If not, add new entry to the cart

            $insert_query = "INSERT INTO shopping_cart (user_id, product_id, quantity) VALUES ($user_id, $product_id, 1)";

            mysqli_query($conn, $insert_query);

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

                <p>استكشف مجموعة منتجاتنا الواسعة من قطع الغيار لمختلف أنواع السيارات والموديلات. نحن نقدم أفضل الأسعار

                    وأعلى جودة لضمان رضاك التام.</p>

                <a href="products.php">

                    <button>تصفح المنتجات</button>

                </a>

                <a href="contact.php">

                    <button>تواصل معنا</button>

                </a>

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

        $products = mysqli_query($conn, "SELECT * FROM products LIMIT 13");

        while ($product = mysqli_fetch_assoc($products)) {

            echo '<div class="product-card">';

            echo '<img class="product-image" src="' . $product['image'] . '" alt="' . $product['name'] . '">';

            echo '<div class="product-details">';

            echo '<div class="info-row">';

            echo '<p class="product-name"><i class="fa fa-cog"></i> ' . $product['name'] . '</p>';

            echo '<p class="product-price"><i class="fa fa-tag"></i> ' . $product['price'] . ' ر.س</p>';

            echo '</div>';

            echo '<div class="info-row">';

            echo '<p class="product-location"><i class="fa fa-map-marker"></i> الرياض</p>';

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

        $conn->close();



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

<script>

</script>

</body>

</html>

