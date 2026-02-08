<?php
include_once './php/db.php';

echo '
    <header>
        <div class="container_header">
            <a href="home.php" class="logo"><img src="img/logo.png" alt="شعار المتجر"> قطعتي </a>
            
            <nav>
                <ul class="links">
                    <li><a href="home.php"><i class="fas fa-home"></i> الرئيسية</a></li>
                    <li><a href="products.php"><i class="fas fa-cubes"></i> منتجاتنا</a></li>
                    <li><a href="about.php"><i class="fas fa-info-circle"></i> عن المتجر</a></li>
                    <li><a href="contact.php"><i class="fas fa-envelope"></i> تواصل معنا</a></li>
                    <li><a href="shopping_cart.php"><i class="fas fa-shopping-cart"></i> السلة</a></li>';

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    // Display the user's first name (or full name) and a logout link
    echo '<li><i class="fas fa-user"></i> ' . htmlspecialchars($_SESSION['first_name']) . '</a></li>';
    echo '<li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>  خروج</a></li>';
} else {
    // Display link to login or create account
    echo '<li><a href="login.php"><i class="fas fa-user-plus"></i> تسجيل دخول</a></li>';
}

echo '
                </ul>
            </nav>
        </div>
    </header>
';
