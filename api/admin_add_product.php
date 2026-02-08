<?php
session_start();

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'seller') {
    header("Location: login.php");
    exit;
}
include_once './php/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $productPrice = $_POST['productPrice'];
    $productSeller = $_SESSION['first_name'];
    $productCity = $_POST['productCity'];
    $productType = $_POST['productType'];
    $productImage = '';

    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] == 0) {
        $tempName = $_FILES['productImage']['tmp_name'];
        $fileName = time() . '_' . basename($_FILES['productImage']['name']);
        $uploadDir = './img/';
        $uploadFile = $uploadDir . $fileName;

        if (move_uploaded_file($tempName, $uploadFile)) {
            $productImage = $uploadFile;
        } else {
            echo 'Error uploading the file. Please try again.';
            exit;
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO products (name, price, seller, city, image, type) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$productName, $productPrice, $productSeller, $productCity, $productImage, $productType])) {
            header("Location: ./admin_products.php");
            exit;
        }
    } catch (PDOException $e) {
        echo 'Error adding product: ' . $e->getMessage();
    }
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
    <link rel="stylesheet" href="css/admin_Dashboard.css">
    <link rel="stylesheet" href="css/admin_add_product.css">
</head>
<body>
<section class="admin-Dashboard">
    <div class="navicon-toggle navicon-toggle-mobile">
        <div class="top"></div>
        <div class="middle"></div>
        <div class="bottom"></div>
    </div>
    <section class="page-sidebar">
        <header class="main-header">
            <div class="logo-img"><img src="img/logo.png"/></div>
            <h1 class="logo-title">قطعتي</h1>
        </header>
        <nav class="main-nav">
            <ul>
                <li class="nav-item"><a href="admin_Dashboard.php"><i class="fas fa-home"></i> الرئيسية</a></li>
                <li class="nav-item"><a href="home.php"><i class="fas fa-store"></i> المتجر</a></li>
                <li class="nav-item"><a href="admin_users.php"><i class="fas fa-users"></i> قسم المستخدمين</a></li>
                <li class="nav-item"><a href="admin_admins.php"><i class="fas fa-user-shield"></i> قسم البائعين</a></li>
                <li class="nav-item"><a href="admin_products.php"><i class="fas fa-box"></i> قسم المنتجات</a></li>
                <li class="nav-item"><a class="active" href="admin_add_product.php"><i class="fas fa-plus-circle"></i> قسم إضافة منتج</a></li>
            </ul>
        </nav>
    </section>
    <main id="page-wrapper">
        <div class="container_admin">
            <article id="page-home">
                <div class="content">
                    <section class="generalAdmin-dashboard admin_addPorducts ">
                        <div class="container_usersadmin">
                            <div class="section_title text-center">
                                <h2>إضافة منتجات</h2>
                                <div class="brand_border">
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                    <i class="fas fa-plus-circle"></i>
                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                </div>
                                <p>أضف منتجات جديدة إلى المتجر بسهولة.</p>
                            </div>
                            <div class="container-admin_addPorducts">
                                <h2>إضافة منتج جديد</h2>
                                <form id="addProductForm" action="admin_add_product.php" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="productImage">صورة المنتج:</label>
                                        <input type="file" id="productImage" name="productImage" accept="image/*" onchange="previewImage();">
                                        <img id="preview" src="#" alt="معاينة الصورة" style="display: none;"/>
                                    </div>
                                    <div class="form-group">
                                        <label for="productName">اسم المنتج:</label>
                                        <input type="text" id="productName" name="productName" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="productPrice">السعر بالريال:</label>
                                        <input type="number" id="productPrice" name="productPrice" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="productSeller">البائع:</label>
                                        <input type="text" id="productSeller" name="productSeller" value="<?= htmlspecialchars($_SESSION['first_name']) ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="productCity">المدينة:</label>
                                        <input type="text" id="productCity" name="productCity" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="productType">نوع المنتج:</label>
                                        <select id="productType" name="productType" required>
                                            <option value="قطع غيار">قطع غيار</option>
                                            <option value="جنوط">جنوط</option>
                                            <option value="شاشات">شاشات</option>
                                            <option value="مسجلات">مسجلات</option>
                                        </select>
                                    </div>
                                    <div class="form-group checkbox">
                                        <input type="checkbox" id="terms" onchange="toggleSubmitButton();">
                                        <label for="terms">أوافق على الشروط والأحكام لمتجر قطعتي</label>
                                    </div>
                                    <button type="submit" id="submitBtn" disabled>إضافة المنتج</button>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
            </article>
        </div>
    </main>
</section>
<script src="js/admin.js"></script>
</body>
</html>
