<?php
session_start();
include 'includes/db.php';

// Fetch all products from database
$stmt = $conn->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Tasty Mushroom with Pradeep Bimmal</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Product Card & Image Styles */
        .product-card {
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            border: 1px solid #eaeaea;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        }
        .product-img-container {
            height: 180px;
            overflow: hidden;
            background: #f0f0f0;
        }
        .product-img-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .product-card:hover .product-img-container img {
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <!-- Header & Navigation -->
    <header>
        <div class="navbar" style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 15px 20px;">
            <a href="index.php" class="logo-area" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-mushroom" style="font-size: 28px; color: #2e8b57;"></i>
                <span>Tasty Mushroom <br><small style="font-size: 12px; color: #666;">with Pradeep Bimmal</small></span>
            </a>
            <ul class="nav-links" style="list-style: none; display: flex; gap: 20px; align-items: center; margin: 0;">
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="shop.php" class="active">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><a href="logout.php" style="color: #c62828;"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <!-- Page Header -->
    <section style="background: #f4f6f4; padding: 40px 20px; text-align: center;">
        <h1 style="color: #1b4d3e; font-size: 32px; margin-bottom: 10px;">Our Mushroom Products</h1>
        <p style="color: #666; font-size: 16px;">Fresh, organic, and high-quality mushroom products delivered to your doorstep.</p>
    </section>

    <!-- Products Grid Section -->
    <main class="container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px;">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $prod): 
                    
                    $prod_image = !empty($prod['image']) ? 'images/' . $prod['image'] : 'images/curry.jpg';
                ?>
                    <div class="product-card">
                        <!-- Product Image on Top -->
                        <div class="product-img-container">
                            <img src="<?= htmlspecialchars($prod_image); ?>" alt="<?= htmlspecialchars($prod['title']); ?>">
                        </div>

                        <div style="padding: 20px;">
                            <h3 style="margin: 10px 0; color: #333; font-size: 20px;"><?= htmlspecialchars($prod['title']); ?></h3>
                            <p style="color: #666; font-size: 14px; margin-bottom: 15px; line-height: 1.5;"><?= htmlspecialchars($prod['description']); ?></p>
                            <div style="font-size: 20px; font-weight: bold; color: #2e8b57; margin-bottom: 15px;">
                                Rs. <?= number_format($prod['price'], 2); ?>
                            </div>
                        </div>
                        <div style="padding: 0 20px 20px 20px;">
                            <form action="cart-action.php" method="POST">
                                <input type="hidden" name="product_id" value="<?= $prod['id']; ?>">
                                <button type="submit" style="width: 100%; border: none; cursor: pointer; display: block; text-align: center; background: #2e8b57; color: white; padding: 10px; border-radius: 5px; font-weight: bold; font-size: 15px;">
                                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align: center; color: #666; grid-column: 1 / -1;">No products available at the moment.</p>
            <?php endif; ?>
        </div>
    </main>

    <!-- Footer -->
    <footer style="background: #1b4d3e; color: white; text-align: center; padding: 25px 0; margin-top: 60px;">
        <p style="margin: 0; font-size: 14px;">&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>

</body>
</html>