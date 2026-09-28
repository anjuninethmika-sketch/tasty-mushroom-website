<?php
session_start();
include 'includes/db.php';

// Fetch Categories
$cat_stmt = $conn->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasty Mushroom with Pradeep Bimmal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        header {
            background: #ffffff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('images/home page.jpg');
            background-size: cover;
            background-position: center;
            padding: 140px 20px;
            text-align: center;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.6);
        }

        /* Card Hover & Bump Effect */
        .hover-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #eaeaea;
            display: block;
            text-decoration: none;
            color: inherit;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .hover-card:hover img {
            transform: scale(1.05);
        }

        .img-container {
            height: 160px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body>

    <!-- Header & Navigation -->
    <header>
        <div class="navbar" style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 15px 20px;">
            <a href="index.php" class="logo-area" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-mushroom" style="font-size: 28px; color: #2e8b57;"></i>
                <span style="font-weight: bold; color: #1b4d3e; font-size: 18px; line-height: 1.2;">Tasty Mushroom <br><small style="font-size: 11px; color: #666; font-weight: normal;">with Pradeep Bimmal</small></span>
            </a>
            <ul class="nav-links" style="list-style: none; display: flex; gap: 20px; align-items: center; margin: 0;">
                <li><a href="index.php" class="active" style="text-decoration: none; color: #2e8b57; font-weight: bold;">Home</a></li>
                <li><a href="recipes.php" style="text-decoration: none; color: #333; font-weight: 500;">Recipes</a></li>
                <li><a href="shop.php" style="text-decoration: none; color: #333; font-weight: 500;">Shop</a></li>
                <li><a href="about.php" style="text-decoration: none; color: #333; font-weight: 500;">About</a></li>
                <li><a href="blog.php" style="text-decoration: none; color: #333; font-weight: 500;">Blog</a></li>
                <li><a href="contact.php" style="text-decoration: none; color: #333; font-weight: 500;">Contact</a></li>
                <?php if (isset($_SESSION['user_id']) && isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
                    <li><a href="admin/dashboard.php" style="text-decoration: none; color: #d97706; font-weight: 500;">Admin Dashboard</a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php" style="text-decoration: none; color: #c62828; font-weight: 500;"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" style="text-decoration: none; background: #2e8b57; color: white; padding: 8px 15px; border-radius: 4px; font-weight: 500;"><i class="fa-solid fa-user"></i> Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1 style="font-size: 46px; margin-bottom: 15px; font-weight: 800;">Tasty Mushroom with Pradeep Bimmal</h1>
        <p style="font-size: 20px; margin-bottom: 25px; font-weight: 400;">Simple recipes • Fresh ingredients • Great taste</p>
        <a href="recipes.php" class="btn-primary" style="background: #2e8b57; color: white; padding: 14px 30px; text-decoration: none; font-weight: bold; border-radius: 6px; display: inline-block; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">Explore Recipes <i class="fa-solid fa-arrow-right"></i></a>
    </section>

    <!-- Categories Section with Images -->
    <section class="container" style="max-width: 1200px; margin: 50px auto; padding: 0 20px;">
        <h2 style="text-align: center; margin-bottom: 30px; color: #1b4d3e; font-size: 28px;">Recipe Categories</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 25px;">
            <?php 
            $cat_images = [
                'Mushroom Curries' => 'images/mushroom curries.webp',
                'Mushroom Soups' => 'images/soups.webp',
                'Stir Fries' => 'images/stir fries.jpg',
                'Snacks & Bites' => 'images/bites.jpg'
            ];
            foreach ($categories as $cat): 
                $cat_id = $cat['id'];
                $cat_name = $cat['name'];
                $img_url = isset($cat_images[$cat_name]) ? $cat_images[$cat_name] : 'images/curry.jpg';
            ?>
                <a href="recipes.php?category_id=<?= $cat_id; ?>" class="hover-card">
                    <div class="img-container">
                        <img src="<?= $img_url; ?>" alt="<?= htmlspecialchars($cat_name); ?>">
                    </div>
                    <div style="padding: 18px; text-align: center; font-weight: bold; color: #333; font-size: 17px;">
                        <?= htmlspecialchars($cat_name); ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer style="background: #1b4d3e; color: white; text-align: center; padding: 25px 0; margin-top: 60px;">
        <p style="margin: 0; font-size: 14px;">&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>

</body>
</html>