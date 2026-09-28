<?php
// about.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Tasty Mushroom with Pradeep Bimmal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <!-- Header & Navigation -->
    <header>
        <div class="navbar">
            <a href="index.php" class="logo-area">
                <i class="fa-solid fa-mushroom" style="font-size: 28px; color: #2e8b57;"></i>
                <span>Tasty Mushroom <br><small style="font-size: 12px; color: #666;">with Pradeep Bimmal</small></span>
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="about.php" class="active">About</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </header>

    <!-- Page Header -->
    <section style="background: #f4f6f4; padding: 40px 20px; text-align: center;">
        <h1 style="color: #1b4d3e; font-size: 32px; margin-bottom: 10px;">About Tasty Mushroom</h1>
        <p style="color: #666; font-size: 16px;">Discover our passion for fresh, healthy, and delicious mushroom creations.</p>
    </section>

    <!-- About Content Section -->
    <main class="container" style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
        <div style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <h2 style="color: #1b4d3e; margin-bottom: 20px; font-size: 24px;"><i class="fa-solid fa-user-chef" style="color: #2e8b57;"></i> Welcome to Tasty Mushroom</h2>
            <p style="color: #555; font-size: 16px; line-height: 1.8; margin-bottom: 20px;">
                Welcome to <strong>Tasty Mushroom</strong>, your ultimate destination for mouth-watering and creative mushroom-based culinary experiences. Spearheaded by <strong>Pradeep Bimmal</strong>, this platform is dedicated to transforming simple, fresh mushrooms into extraordinary dishes that delight your taste buds.
            </p>
            <p style="color: #555; font-size: 16px; line-height: 1.8; margin-bottom: 20px;">
                Through our carefully curated collection of recipes, we aim to blend traditional flavors with modern cooking styles, helping you prepare healthy, delicious, and nutritious mushroom meals right in your own kitchen.
            </p>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-top: 35px;">
                <div style="background: #f9f9f9; padding: 20px; border-radius: 6px; border-left: 4px solid #2e8b57;">
                    <h3 style="color: #1b4d3e; margin-bottom: 10px; font-size: 18px;"><i class="fa-solid fa-seedling"></i> Fresh Ingredients</h3>
                    <p style="color: #666; font-size: 14px; line-height: 1.5;">We focus on using farm-fresh mushrooms and natural ingredients for a healthy lifestyle.</p>
                </div>
                <div style="background: #f9f9f9; padding: 20px; border-radius: 6px; border-left: 4px solid #2e8b57;">
                    <h3 style="color: #1b4d3e; margin-bottom: 10px; font-size: 18px;"><i class="fa-solid fa-utensils"></i> Easy Recipes</h3>
                    <p style="color: #666; font-size: 14px; line-height: 1.5;">Step-by-step instructions designed to make cooking easy and enjoyable for everyone.</p>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>

</body>
</html>