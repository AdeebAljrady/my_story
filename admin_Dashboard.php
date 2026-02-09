<?php
session_start();

if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] !== 'seller') {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>متجر قطعتي </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="css/admin_Dashboard.css">
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
            <div class="logo-img"><img src="img/logo.png" alt="Logo"/></div>
            <h1 class="logo-title">قطعتي</h1>
        </header>
        <nav class="main-nav">
            <ul>
                <li class="nav-item"><a class="active" href="admin_Dashboard.php"><i class="fas fa-home"></i> الرئيسية</a></li>
                <li class="nav-item"><a href="home.php"><i class="fas fa-store"></i> المتجر</a></li>
                <li class="nav-item"><a href="admin_users.php"><i class="fas fa-users"></i> قسم المستخدمين</a></li>
                <li class="nav-item"><a href="admin_admins.php"><i class="fas fa-user-shield"></i> قسم البائعين</a></li>
                <li class="nav-item"><a href="admin_products.php"><i class="fas fa-box"></i> قسم المنتجات</a></li>
                <li class="nav-item"><a href="admin_add_product.php"><i class="fas fa-plus-circle"></i> قسم إضافة منتج</a></li>
            </ul>
        </nav>
    </section>
    <main id="page-wrapper">
        <div class="container_admin">
            <article id="page-home">
                <div class="content">
                    <section class="generalAdmin-dashboard home_admin container">
                        <div class="container_homeadmin">
                            <a class="section-box" href="admin_Dashboard.php"><i class="fas fa-home"></i> <p>الرئيسية</p></a>
                            <a class="section-box" href="home.php"><i class="fas fa-store"></i> <p>المتجر</p></a>
                            <a class="section-box" href="admin_users.php"><i class="fas fa-users"></i> <p>قسم المستخدمين</p></a>
                            <a class="section-box" href="admin_admins.php"><i class="fas fa-user-shield"></i> <p>قسم البائعين</p></a>
                            <a class="section-box" href="admin_products.php"><i class="fas fa-box"></i> <p>قسم المنتجات</p></a>
                            <a class="section-box" href="admin_add_product.php"><i class="fas fa-plus-circle"></i> <p>قسم إضافة منتج</p></a>
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
