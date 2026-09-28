<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mushroom Blog - Tasty Mushroom</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Read More Button Style */
        .read-more-btn {
            display: inline-block;
            background-color: #2e8b57;
            color: white !important;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .read-more-btn:hover {
            background-color: #246d44;
        }
    </style>
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
                <li><a href="blog.php" class="active">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                        <li><a href="admin/dashboard.php">Admin Dashboard</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php" style="color: #c62828; font-weight: bold;"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <main class="container" style="max-width: 1100px; margin: 40px auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 40px;">
            <h1 style="color: #1b4d3e; font-size: 36px; margin-bottom: 10px;">Mushroom Blog</h1>
            <p style="color: #666; font-size: 16px;">Read the latest tips, health benefits, and stories about mushrooms by Pradeep Bimmal.</p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px;">
            
            <!-- Blog Post 1 -->
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #eaeaea; display: flex; flex-direction: column; justify-content: space-between;">
                <div style="padding: 25px;">
                    <span style="background: #e8f5e9; color: #2e8b57; padding: 4px 10px; font-size: 12px; border-radius: 4px; font-weight: bold;">Health</span>
                    <h3 style="margin: 15px 0 10px; color: #333; font-size: 20px;">Top 5 Health Benefits of Eating Mushrooms</h3>
                    <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Discover how incorporating fresh mushrooms into your daily diet can boost your immunity and overall health.</p>
                </div>
                <div style="padding: 0 25px 25px 25px;">
                    <a href="blog-details.php?id=1" class="read-more-btn">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Blog Post 2 -->
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #eaeaea; display: flex; flex-direction: column; justify-content: space-between;">
                <div style="padding: 25px;">
                    <span style="background: #e8f5e9; color: #2e8b57; padding: 4px 10px; font-size: 12px; border-radius: 4px; font-weight: bold;">Cultivation</span>
                    <h3 style="margin: 15px 0 10px; color: #333; font-size: 20px;">How to Grow Mushrooms at Home Easily</h3>
                    <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">A beginner-friendly guide to starting your own small mushroom garden right at home with Pradeep Bimmal.</p>
                </div>
                <div style="padding: 0 25px 25px 25px;">
                    <a href="blog-details.php?id=2" class="read-more-btn">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

            <!-- Blog Post 3 -->
            <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.06); border: 1px solid #eaeaea; display: flex; flex-direction: column; justify-content: space-between;">
                <div style="padding: 25px;">
                    <span style="background: #e8f5e9; color: #2e8b57; padding: 4px 10px; font-size: 12px; border-radius: 4px; font-weight: bold;">Cooking Tips</span>
                    <h3 style="margin: 15px 0 10px; color: #333; font-size: 20px;">The Secret to Perfectly Sautéed Mushrooms</h3>
                    <p style="color: #666; font-size: 14px; line-height: 1.6; margin-bottom: 20px;">Learn the professional techniques to get golden, juicy, and flavorful mushrooms every single time.</p>
                </div>
                <div style="padding: 0 25px 25px 25px;">
                    <a href="blog-details.php?id=3" class="read-more-btn">Read More <i class="fa-solid fa-arrow-right"></i></a>
                </div>
            </div>

        </div>
    </main>

    <footer style="background: #1b4d3e; color: white; text-align: center; padding: 20px 0; margin-top: 50px;">
        <p>&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>
</body>
</html>