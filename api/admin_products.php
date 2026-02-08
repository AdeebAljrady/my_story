<?php
session_start();
include 'php/db.php';

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT product_id, name, seller, city, price, image, type FROM products";
if (!empty($searchQuery)) {
    $sql .= " WHERE name LIKE ? OR seller LIKE ?";
}

$stmt = $conn->prepare($sql);
if (!empty($searchQuery)) {
    $likeQuery = '%' . $searchQuery . '%';
    $stmt->execute([$likeQuery, $likeQuery]);
} else {
    $stmt->execute();
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
    <link rel="stylesheet" href="css/admin_users.css">
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
            <div class="logo-img"><img src="img/logo.png" /></div>
            <h1 class="logo-title">قطعتي</h1>
        </header>
        <nav class="main-nav">
            <ul>
                <li class="nav-item"><a href="admin_Dashboard.php"><i class="fas fa-home"></i> الرئيسية</a></li>
                <li class="nav-item"><a href="home.php"><i class="fas fa-store"></i> المتجر</a></li>
                <li class="nav-item"><a href="admin_users.php"><i class="fas fa-users"></i> قسم المستخدمين</a></li>
                <li class="nav-item"><a href="admin_admins.php"><i class="fas fa-user-shield"></i> قسم البائعين</a></li>
                <li class="nav-item"><a class="active" href="admin_products.php"><i class="fas fa-box"></i> قسم المنتجات</a></li>
                <li class="nav-item"><a href="admin_add_product.php"><i class="fas fa-plus-circle"></i> قسم إضافة منتج</a></li>
            </ul>
        </nav>
    </section>
    <main id="page-wrapper">
        <div class="container_admin">
            <article id="page-home">
                <div class="content">
                    <section class="generalAdmin-dashboard users_admin">
                        <div class="container_usersadmin">
                            <div class="section_title text-center">
                                <h2>المنتجات</h2>
                                <div class="brand_border">
                                    <i class="fa fa-minus"></i>
                                    <i class="fas fa-box"></i>
                                    <i class="fa fa-minus"></i>
                                </div>
                                <p>استعرض وقم بإدارة المنتجات الموجودة في المخزن.</p>
                            </div>
                            <form class="search-bar-container" method="GET">
                                <input type="text" class="search-bar" name="search" placeholder=" ابحث عن منتج أو بائع..." value="<?= htmlspecialchars($searchQuery) ?>">
                                <button type="submit" class="search-icon"><i class="fas fa-search"></i></button>
                            </form>
                            <table>
                                <thead>
                                <tr>
                                    <th>صورة المنتج</th>
                                    <th>اسم المنتج</th>
                                    <th>البائع</th>
                                    <th>المدينة</th>
                                    <th>السعر</th>
                                    <th>النوع</th>
                                    <th>إجراءات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php while ($row = $stmt->fetch()): ?>
                                    <tr>
                                        <td><img src="<?= htmlspecialchars($row['image']) ?>" alt="صورة المنتج" style="width: 50px; height: auto;"></td>
                                        <td><?= htmlspecialchars($row['name']) ?></td>
                                        <td><?= htmlspecialchars($row['seller']) ?></td>
                                        <td><?= htmlspecialchars($row['city']) ?></td>
                                        <td><?= htmlspecialchars($row['price']) ?></td>
                                        <td><?= htmlspecialchars($row['type']) ?></td>
                                        <td><button class="btn-remove" onclick="removeProduct(<?= $row['product_id'] ?>);">حذف</button></td>
                                    </tr>
                                <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </article>
        </div>
    </main>
</section>
<script src="js/admin.js"></script>
<script>
    function removeProduct(productId) {
        if (confirm('هل أنت متأكد من حذف هذا المنتج؟')) {
            window.location.href = 'delete_product.php?id=' + productId;
        }
    }
</script>
</body>
</html>
