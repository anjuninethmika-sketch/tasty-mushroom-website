<?php
include 'includes/db.php';

// Fetch Categories
$cat_stmt = $conn->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch Featured Recipes
$rec_stmt = $conn->query("SELECT r.*, c.name as category_name FROM recipes r LEFT JOIN categories c ON r.category_id = c.id LIMIT 3");
$recipes = $rec_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasty Mushroom with Pradeep Bimmal</title>
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
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero-section">
        <h1>Tasty Mushroom with Pradeep Bimmal</h1>
        <p>Simple recipes • Fresh ingredients • Great taste</p>
        <a href="recipes.php" class="btn-primary">Explore Recipes <i class="fa-solid fa-arrow-right"></i></a>
    </section>

    <!-- Categories Section -->
    <section class="container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
        <h2 style="text-align: center; margin-bottom: 25px; color: #1b4d3e;">Recipe Categories</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 20px;">
            <?php foreach ($categories as $cat): ?>
                <div style="background: white; padding: 20px; text-align: center; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.05); font-weight: bold; color: #2e8b57;">
                    <i class="fa-solid fa-utensils" style="font-size: 24px; margin-bottom: 10px; display: block;"></i>
                    <?= htmlspecialchars($cat['name']); ?>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Featured Recipes Section -->
    <section class="container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
        <h2 style="text-align: center; margin-bottom: 25px; color: #1b4d3e;">Featured Recipes</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
            <?php foreach ($recipes as $rec): ?>
                <div style="background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <div style="padding: 20px;">
                        <span style="background: #e8f5e9; color: #2e8b57; padding: 4px 10px; font-size: 12px; border-radius: 4px; font-weight: bold;"><?= htmlspecialchars($rec['category_name']); ?></span>
                        <h3 style="margin: 15px 0 10px; color: #333;"><?= htmlspecialchars($rec['title']); ?></h3>
                        <p style="color: #666; font-size: 14px; margin-bottom: 15px;"><?= htmlspecialchars($rec['description']); ?></p>
                        <a href="recipe-details.php?id=<?= $rec['id']; ?>" style="color: #2e8b57; text-decoration: none; font-weight: bold;">View Recipe &rarr;</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>

</body>
</html>