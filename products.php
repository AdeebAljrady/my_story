<?php
session_start();
include_once 'php/db.php';

if (isset($_GET['category'])) {
    $category = $_GET['category'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE type = ?");
    $stmt->execute([$category]);
} else if (isset($_GET['search'])) {
    $search = '%' . $_GET['search'] . '%';
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
    $stmt->execute([$search]);
} else {
    $stmt = $conn->query("SELECT * FROM products");
}

function handleAddToCart($conn, $product_id)
{
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        $check_stmt = $conn->prepare("SELECT * FROM shopping_cart WHERE user_id = ? AND product_id = ?");
        $check_stmt->execute([$user_id, $product_id]);
        $cart_item = $check_stmt->fetch();

        if ($cart_item) {
            $update_stmt = $conn->prepare("UPDATE shopping_cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
            $update_stmt->execute([$user_id, $product_id]);
        } else {
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
    <title>قطعتي - إدارة المنتجات</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/products.css">
</head>
<body>
<div class="products-page">
    <?php require "./php/header.php"; ?>

    <div class="section_title text-center">
        <h2>ابحث في المنتجات</h2>
        <div class="brand_border">
            <i class="fa fa-minus" aria-hidden="true"></i>
            <i class="fas fa-search" aria-hidden="true"></i>
            <i class="fa fa-minus" aria-hidden="true"></i>
        </div>
        <p>ابحث عن المنتجات المختلفة من قطع غيار واكسسوارات السيارات بكل سهولة.</p>
    </div>
    <div class="section_title text-center">
        <div class="search-bar-container">
            <form method="GET" action="">
                <input type="text" class="search-bar" name="search" placeholder=" ابحث عن قطع غيار، جنوط، شاشات...">
                <button class="search-icon" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <div class="filter-buttons">
            <button class="filter-btn" onclick="filterProducts('قطع غيار')"><i class="fas fa-wrench"></i>قطع غيار</button>
            <button class="filter-btn" onclick="filterProducts('جنوط')"><i class="fas fa-circle-notch"></i> جنوط</button>
            <button class="filter-btn" onclick="filterProducts('شاشات')"><i class="fas fa-tablet-alt"></i> شاشات</button>
            <button class="filter-btn" onclick="filterProducts('مسجلات')"><i class="fas fa-video"></i> مسجلات</button>
        </div>
    </div>

    <div class="product-gallery container">
        <?php
        while ($row = $stmt->fetch()) {
            echo '<div class="product-card" data-category="' . htmlspecialchars($row['type']) . '">';
            echo '<img class="product-image" src="' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '">';
            echo '<div class="product-details">';
            echo '<div class="info-row">';
            echo '<p class="product-name"><i class="fa fa-cog"></i> ' . htmlspecialchars($row['name']) . '</p>';
            echo '<p class="product-price"><i class="fa fa-tag"></i> ' . htmlspecialchars($row['price']) . ' ر.س</p>';
            echo '</div>';
            echo '<div class="info-row">';
            echo '<p class="product-location"><i class="fa fa-map-marker"></i> ' . htmlspecialchars($row['city']) . '</p>';
            echo '<p class="product-seller"><i class="fa fa-user"></i><span>البائع :</span> ' . htmlspecialchars($row['seller']) . '</p>';
            echo '</div>';
            echo '<div class="button-row">';
            echo '<form method="post">
                  <input type="hidden" name="product_id" value="' . $row['product_id'] . '">
                  <button name="add_to_cart" type="submit"><i class="fa fa-cart-plus"></i> أضف للسلة</button>
                  </form>';
            echo '<button class="button-more-info"><i class="fa fa-info-circle"></i> المزيد</button>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <div class="pagination"></div>

    <?php require "./php/footer.php"; ?>
</div>
<script>
    function filterProducts(category) {
        window.location.href = 'products.php?category=' + category;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const productsPerPage = 12;
        let currentPage = 1;

        function loadProducts(page) {
            const start = (page - 1) * productsPerPage;
            const end = start + productsPerPage;
            const allProducts = document.querySelectorAll('.product-card');
            allProducts.forEach((product, index) => {
                product.style.display = (index >= start && index < end) ? 'block' : 'none';
            });
            updatePagination(page, Math.ceil(allProducts.length / productsPerPage));
        }

        function updatePagination(currentPage, totalPages) {
            const paginationContainer = document.querySelector('.pagination');
            paginationContainer.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const pageLink = document.createElement('span');
                pageLink.textContent = i;
                if (i === currentPage) {
                    pageLink.classList.add('active');
                }
                pageLink.addEventListener('click', () => loadProducts(i));
                paginationContainer.appendChild(pageLink);
            }
        }

        loadProducts(currentPage);
    });
</script>
</body>
</html>
