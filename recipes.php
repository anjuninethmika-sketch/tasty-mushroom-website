<?php
session_start();
include 'includes/db.php';

// Fetch Categories for filter
$cat_stmt = $conn->query("SELECT * FROM categories");
$categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

// Check if category filter is applied
$cat_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
if ($cat_id) {
    $rec_stmt = $conn->prepare("SELECT r.*, c.name as category_name FROM recipes r LEFT JOIN categories c ON r.category_id = c.id WHERE r.category_id = ?");
    $rec_stmt->execute([$cat_id]);
} else {
    $rec_stmt = $conn->query("SELECT r.*, c.name as category_name FROM recipes r LEFT JOIN categories c ON r.category_id = c.id");
}
$recipes = $rec_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Mushroom Recipes - Tasty Mushroom</title>
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

        .recipes-hero {
            background: #1b4d3e;
            color: white;
            padding: 60px 20px;
            text-align: center;
        }

        /* Category Filter Buttons Style */
        .category-filters {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin: 40px 20px 20px;
        }

        .filter-btn {
            background: #f1f5f9;
            color: #333;
            padding: 10px 20px;
            border-radius: 30px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: 1px solid #e2e8f0;
        }

        .filter-btn:hover, .filter-btn.active {
            background: #2e8b57;
            color: white;
            border-color: #2e8b57;
            box-shadow: 0 4px 10px rgba(46, 139, 87, 0.2);
        }

        /* Recipe Card with Hover & Image */
        .recipe-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            border: 1px solid #eaeaea;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .recipe-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.15);
        }

        .recipe-card:hover img {
            transform: scale(1.05);
        }

        .recipe-img-container {
            height: 180px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .recipe-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        /* Buttons Style */
        .btn-view {
            background: #f0fdf4;
            color: #2e8b57;
            border: 1px solid #2e8b57;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            display: inline-block;
            transition: background 0.2s;
        }

        .btn-view:hover {
            background: #2e8b57;
            color: white;
        }

        .btn-cart {
            background: #2e8b57;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 13px;
            display: inline-block;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-cart:hover {
            background: #246d44;
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
                <li><a href="index.php" style="text-decoration: none; color: #333; font-weight: 500;">Home</a></li>
                <li><a href="recipes.php" class="active" style="text-decoration: none; color: #2e8b57; font-weight: bold;">Recipes</a></li>
                <li><a href="shop.php" style="text-decoration: none; color: #333; font-weight: 500;">Shop</a></li>
                <li><a href="about.php" style="text-decoration: none; color: #333; font-weight: 500;">About</a></li>
                <li><a href="blog.php" style="text-decoration: none; color: #333; font-weight: 500;">Blog</a></li>
                <li><a href="contact.php" style="text-decoration: none; color: #333; font-weight: 500;">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="cart.php" style="text-decoration: none; color: #333; font-weight: 500;"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
                    <li><a href="logout.php" style="text-decoration: none; color: #c62828; font-weight: 500;">Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php" style="text-decoration: none; background: #2e8b57; color: white; padding: 8px 15px; border-radius: 4px;">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <!-- Recipes Hero Section -->
    <section class="recipes-hero">
        <h1 style="font-size: 38px; margin-bottom: 10px; font-weight: 800;">All Mushroom Recipes</h1>
        <p style="font-size: 16px; opacity: 0.9;">Explore our delicious recipes and order fresh ingredients directly!</p>
    </section>

    <!-- Category Filter Buttons Section -->
    <div class="category-filters" style="max-width: 1200px; margin: 30px auto 10px; padding: 0 20px;">
        <a href="recipes.php" class="filter-btn <?= empty($cat_id) ? 'active' : ''; ?>">All Recipes</a>
        <?php foreach ($categories as $cat): ?>
            <a href="recipes.php?category_id=<?= $cat['id']; ?>" class="filter-btn <?= ($cat_id == $cat['id']) ? 'active' : ''; ?>">
                <?= htmlspecialchars($cat['name']); ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Recipes Grid Section -->
    <section class="container" style="max-width: 1200px; margin: 30px auto 60px; padding: 0 20px;">
        <?php if (count($recipes) > 0): ?>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 25px;">
                <?php 
                $default_images = [
                    'Spicy Mushroom Cutlets' => 'images/snacks.jpg',
                    'Garlic Herb Roasted Mushrooms' => 'images/stirfry.jpg',
                    'Coconut Milk Mushroom Curry' => 'images/curry.jpg',
                    'Mushroom Kottu Roti Style' => 'images/stirfry.jpg',
                    'Mushroom and Spinach Stir Fry' => 'images/stirfry.jpg',
                    'Cheesy Stuffed Button Mushrooms' => 'images/snacks.jpg'
                ];

                foreach ($recipes as $rec): 
                    $rec_title = $rec['title'];
                    $rec_img = isset($rec['image']) && !empty($rec['image']) ? 'images/' . $rec['image'] : (isset($default_images[$rec_title]) ? $default_images[$rec_title] : 'images/curry.jpg');
                ?>
                    <div class="recipe-card">
                        <!-- Recipe Image on Top -->
                        <div class="recipe-img-container">
                            <img src="<?= $rec_img; ?>" alt="<?= htmlspecialchars($rec_title); ?>">
                        </div>
                        <div style="padding: 20px; display: flex; flex-direction: column; flex-grow: 1;">
                            <span style="background: #e8f5e9; color: #2e8b57; padding: 4px 10px; font-size: 11px; border-radius: 4px; font-weight: bold; width: fit-content;"><?= htmlspecialchars($rec['category_name']); ?></span>
                            <h3 style="margin: 12px 0 8px; color: #222; font-size: 18px;"><?= htmlspecialchars($rec_title); ?></h3>
                            <p style="color: #666; font-size: 13px; margin-bottom: 15px; line-height: 1.4; flex-grow: 1;"><?= htmlspecialchars($rec['description']); ?></p>
                            
                            <!-- Recipe Price Display -->
                            <div style="font-size: 17px; font-weight: bold; color: #2e8b57; margin-bottom: 15px;">
                                Price: Rs. <?= number_format($rec['price'], 2); ?>
                            </div>

                            <!-- Action Buttons: View Recipe & Add to Cart -->
                            <div style="display: flex; gap: 10px; align-items: center; justify-content: space-between; border-top: 1px solid #f0f0f0; padding-top: 15px;">
                                <a href="recipe-details.php?id=<?= $rec['id']; ?>" class="btn-view"><i class="fa-solid fa-eye"></i> View Recipe</a>
                                
                                <!-- Add to Cart Form -->
                                <form action="cart-action.php" method="POST" style="margin: 0;">
                                    <input type="hidden" name="recipe_id" value="<?= $rec['id']; ?>">
                                    <button type="submit" name="add_to_cart" class="btn-cart"><i class="fa-solid fa-cart-plus"></i> Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; background: #f9f9f9; border-radius: 8px;">
                <p style="color: #666; font-size: 16px;">මෙම අංශයට (Category) අදාළව තවමත් රෙසිපි එකතු කර නොමැත.</p>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer style="background: #1b4d3e; color: white; text-align: center; padding: 25px 0; margin-top: 60px;">
        <p style="margin: 0; font-size: 14px;">&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>

</body>
</html>