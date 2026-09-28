<?php
include 'includes/db.php';

// Get recipe ID from URL
$recipe_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch recipe details with category name
$stmt = $conn->prepare("SELECT r.*, c.name as category_name FROM recipes r LEFT JOIN categories c ON r.category_id = c.id WHERE r.id = ?");
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch(PDO::FETCH_ASSOC);

// If recipe not found, redirect to home
if (!$recipe) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><= htmlspecialchars($recipe['title']); ?> - Tasty Mushroom</title>
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
                <li><a href="about.php">About</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </header>

    <!-- Recipe Details Content -->
    <main class="container" style="max-width: 900px; margin: 40px auto; padding: 0 20px;">
        <a href="index.php" style="color: #2e8b57; text-decoration: none; font-weight: bold; display: inline-block; margin-bottom: 20px;">&larr; Back to Home</a>
        
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <span style="background: #e8f5e9; color: #2e8b57; padding: 5px 12px; font-size: 13px; border-radius: 4px; font-weight: bold;"><?= htmlspecialchars($recipe['category_name']); ?></span>
            
            <h1 style="margin: 20px 0 10px; color: #1b4d3e; font-size: 32px;"><?= htmlspecialchars($recipe['title']); ?></h1>
            <p style="color: #666; font-size: 16px; margin-bottom: 25px; line-height: 1.6;"><?= htmlspecialchars($recipe['description']); ?></p>
            
            <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">

            <div style="margin-bottom: 30px;">
                <h3 style="color: #2e8b57; margin-bottom: 12px; font-size: 20px;"><i class="fa-solid fa-basket-shopping"></i> Ingredients</h3>
                <p style="background: #f9f9f9; padding: 15px; border-radius: 6px; color: #444; line-height: 1.6; white-space: pre-line;"><?= htmlspecialchars($recipe['ingredients']); ?></p>
            </div>

            <div>
                <h3 style="color: #2e8b57; margin-bottom: 12px; font-size: 20px;"><i class="fa-solid fa-list-check"></i> Instructions</h3>
                <p style="background: #f9f9f9; padding: 15px; border-radius: 6px; color: #444; line-height: 1.6; white-space: pre-line;"><?= htmlspecialchars($recipe['instructions']); ?></p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <p>&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>

</body>
</html>