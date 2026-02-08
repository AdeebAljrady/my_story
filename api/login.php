<?php
global $conn;
session_start();
include './php/db.php';

$message = "";

// Note: Table creation logic removed from here as it's handled via Supabase SQL Editor

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        try {
            $stmt = $conn->prepare("SELECT id, \"firstName\", \"lastName\", email, password, \"accountType\" FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $row = $stmt->fetch();

            if ($row) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['account_type'] = $row['accountType'];
                    $_SESSION['first_name'] = $row['firstName'];

                    $redirectPage = $row['accountType'] === 'seller' ? 'admin_Dashboard.php' : 'home.php';
                    header("Location: ./$redirectPage");
                    exit;
                }
                $message = "Invalid email or password.";
            } else {
                $message = "Invalid email or password.";
            }
        } catch (PDOException $e) {
            $message = "Login error: " . $e->getMessage();
        }
    } elseif (isset($_POST['signup'])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $accountType = $_POST['accountType'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $stmt = $conn->prepare("INSERT INTO users (\"firstName\", \"lastName\", email, password, \"accountType\") VALUES (?, ?, ?, ?, ?)");
            if ($stmt->execute([$firstName, $lastName, $email, $hashed_password, $accountType])) {
                $_SESSION['user_id'] = $conn->lastInsertId();
                $_SESSION['account_type'] = $accountType;
                $_SESSION['first_name'] = $firstName;
                $redirectPage = $accountType === 'seller' ? 'admin_Dashboard.php' : 'home.php';
                header("Location: ./$redirectPage");
                exit;
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23505) { // PostgreSQL unique violation
                $message = "Email already exists.";
            } else {
                $message = "Signup error: " . $e->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title> قطعتي </title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <link href="css/header.css" rel="stylesheet">
    <link href="css/footer.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link href="css/login.css" rel="stylesheet">
</head>
<body>
<div class="landing-page">
    <?php require "./php/header.php" ?>
    <div class="form">
        <ul class="tab-group">
            <li class="tab active"><a href="#signup">انشاء حساب</a></li>
            <li class="tab"><a href="#login">تسجيل الدخول</a></li>
        </ul>
        <div class="tab-content">
            <div id="signup">
                <h1> انشاء حساب</h1>
                <form method="post">
                    <div class="top-row">
                        <div class="field-wrap">
                            <label for="firstName ">
                                <span class="req">*  الاسم الاول</span>
                            </label>
                            <input id="firstName" name="firstName" type="text" required autocomplete="off"/>
                        </div>
                        <div class="field-wrap">
                            <label for="lastName">
                                 <span class="req">*الاسم الاخير</span>
                            </label>
                            <input id="lastName" name="lastName" type="text" required autocomplete="off"/>
                        </div>
                    </div>
                    <div class="field-wrap">
                        <label for="email">
                            <span class="req">*البريد الإلكتروني</span>
                        </label>
                        <input id="email" name="email" type="email" required autocomplete="off"/>
                    </div>
                    <div class="field-wrap">
                        <label for="password">
                           <span class="req">* اختر كلمة مرور</span>
                        </label>
                        <input id="password" name="password" type="password" required autocomplete="off"/>
                    </div>
                    <div class="radio-div">
                        <input id="accountType1" name="accountType" type="radio" value="seller" checked/>
                        <label for="accountType1">بائع</label>
                        <input id="accountType2" name="accountType" type="radio" value="user"/>
                        <label for="accountType2">مستخدم</label>
                    </div>
                    <input type="hidden" name="signup" value="1">
                    <button class="button button-block" type="submit"> انشاء</button>
                </form>
            </div>
            <div id="login">
                <img alt="شعار المتجر" class="login-img" src="img/logo.png">
                <h1> تسجيل الدخول</h1>
                <form method="post">
                    <div class="field-wrap">
                        <label for="loginEmail">
                          <span class="req">*  البريد الإلكتروني</span>
                        </label>
                        <input id="loginEmail" name="email" type="email" required autocomplete="off"/>
                    </div>
                    <div class="field-wrap">
                        <label for="loginPassword">
                          <span class="req">*  كلمة المرور</span>
                        </label>
                        <input id="loginPassword" name="password" type="password" required autocomplete="off"/>
                    </div>
                    <input type="hidden" name="login" value="1">
                    <button class="button button-block">تسجيل الدخول</button>
                </form>
            </div>
        </div>
    </div>
    <?php require "./php/footer.php" ?>
</div>
<script>
    document.querySelectorAll('.form input, .form textarea').forEach(element => {
        element.addEventListener('keyup', toggleLabelClass);
        element.addEventListener('blur', toggleLabelClass);
        element.addEventListener('focus', toggleLabelClass);
    });
    document.querySelectorAll('.tab a').forEach(tab => {
        tab.addEventListener('click', switchTab);
    });
    function toggleLabelClass(event) {
        const input = event.target;
        let label = input.closest('.field-wrap').querySelector('label');
        if (input.value === '') {
            label.classList.remove('active', 'highlight');
        } else {
            label.classList.add('active', 'highlight');
        }
    }
    function switchTab(event) {
        event.preventDefault();
        const tab = event.target.parentElement;
        const target = document.querySelector(event.target.getAttribute('href'));
        document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        document.querySelectorAll('.tab-content > div').forEach(content => {
            content.style.display = 'none';
        });
        target.style.display = 'block';
    }
    <?php
    if ($message !== "") {
        echo "alert('" . addslashes($message) . "');";
    }
    ?>
</script>
</body>
</html>
