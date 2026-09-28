<?php
session_start();
include 'includes/db.php';
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Fetch user from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Check password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = trim($user['role']); // role එක save කරගැනීම

            // Debugging: role එක හරියටම admin ද බලමු
            if ($_SESSION['user_role'] === 'admin') {
                header("Location: admin/dashboard.php");
                exit();
            } else {
                header("Location: shop.php");
                exit();
            }
        } else {
            $msg = "Incorrect password! Please try again.";
        }
    } else {
        $msg = "No account found with this email!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Tasty Mushroom</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header>
        <div class="navbar">
            <a href="index.php" class="logo-area">
                <i class="fa-solid fa-mushroom" style="font-size: 28px; color: #2e8b57;"></i>
                <span>Tasty Mushroom <br><small style="font-size: 12px; color: #666;">with Pradeep Bimmal</small></span>
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <li><a href="login.php" class="active">Login</a></li>
            </ul>
        </div>
    </header>

    <main class="container" style="max-width: 500px; margin: 50px auto; padding: 0 20px;">
        <div style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <h2 style="color: #1b4d3e; margin-bottom: 20px; text-align: center;"><i class="fa-solid fa-right-to-bracket"></i> User Login</h2>
            
            <?php if (!empty($msg)): ?>
                <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center; font-weight: bold;"><?= $msg; ?></div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div style="margin-bottom: 15px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Email Address</label>
                    <input type="email" name="email" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Password</label>
                    <input type="password" name="password" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
                <button type="submit" style="width: 100%; background: #2e8b57; color: white; border: none; padding: 12px; font-size: 16px; font-weight: bold; border-radius: 5px; cursor: pointer;">Login</button>
            </form>
            <p style="text-align: center; margin-top: 15px; font-size: 14px;">Don't have an account? <br><a href="register.php" style="color: #2e8b57; font-weight: bold;">Register here</a></p>
        </div>
    </main>
</body>
</html>