<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch cart items joining with both products and recipes tables (රෙසිපි වල price එකත් ලබා ගැනීම සඳහා r.price එකතු කරන ලදී)
$stmt = $conn->prepare("
    SELECT c.*, 
           p.title as product_name, p.price as product_price, p.image as product_image,
           r.title as recipe_title, r.price as recipe_price, r.image as recipe_image
    FROM cart c 
    LEFT JOIN products p ON c.product_id = p.id 
    LEFT JOIN recipes r ON c.recipe_id = r.id 
    WHERE c.user_id = ?
");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_price = 0;
?>
<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart - Tasty Mushroom</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        header { background: #ffffff; box-shadow: 0 2px 10px rgba(0,0,0,0.05); position: sticky; top: 0; z-index: 1000; }
        .cart-container { max-width: 900px; margin: 40px auto; padding: 0 20px; }
        .cart-table { width: 100%; border-collapse: collapse; background: white; box-shadow: 0 4px 12px rgba(0,0,0,0.05); border-radius: 8px; overflow: hidden; }
        .cart-table th, .cart-table td { padding: 15px; text-align: left; border-bottom: 1px solid #eaeaea; }
        .cart-table th { background: #1b4d3e; color: white; }
        .btn-checkout { background: #2e8b57; color: white; padding: 12px 25px; border: none; border-radius: 6px; font-weight: bold; font-size: 16px; cursor: pointer; text-decoration: none; display: inline-block; float: right; margin-top: 20px; }
        .btn-checkout:hover { background: #246d44; }
    </style>
</head>
<body>

    <header>
        <div class="navbar" style="max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 15px 20px;">
            <a href="index.php" class="logo-area" style="text-decoration: none; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-mushroom" style="font-size: 28px; color: #2e8b57;"></i>
                <span style="font-weight: bold; color: #1b4d3e; font-size: 18px; line-height: 1.2;">Tasty Mushroom <br><small style="font-size: 11px; color: #666; font-weight: normal;">with Pradeep Bimmal</small></span>
            </a>
            <ul class="nav-links" style="list-style: none; display: flex; gap: 20px; align-items: center; margin: 0;">
                <li><a href="index.php" style="text-decoration: none; color: #333; font-weight: 500;">Home</a></li>
                <li><a href="recipes.php" style="text-decoration: none; color: #333; font-weight: 500;">Recipes</a></li>
                <li><a href="shop.php" style="text-decoration: none; color: #333; font-weight: 500;">Shop</a></li>
                <li><a href="about.php" style="text-decoration: none; color: #333; font-weight: 500;">About</a></li>
                <li><a href="blog.php" style="text-decoration: none; color: #333; font-weight: 500;">Blog</a></li>
                <li><a href="contact.php" style="text-decoration: none; color: #333; font-weight: 500;">Contact</a></li>
                <li><a href="cart.php" class="active" style="text-decoration: none; color: #2e8b57; font-weight: bold;"><i class="fa-solid fa-cart-shopping"></i> Cart</a></li>
                <li><a href="logout.php" style="text-decoration: none; color: #c62828; font-weight: 500;">Logout</a></li>
            </ul>
        </div>
    </header>

    <div class="cart-container">
        <h1 style="color: #1b4d3e; margin-bottom: 25px;"><i class="fa-solid fa-cart-shopping"></i> Your Shopping Cart</h1>
        
        <?php if (empty($cart_items)): ?>
            <div style="background: white; padding: 40px; text-align: center; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <p style="font-size: 18px; color: #666; margin-bottom: 20px;">Your cart is currently empty!</p>
                <a href="shop.php" class="btn-checkout" style="float: none;">Go to Shop</a>
            </div>
        <?php else: ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cart_items as $item): 
                        $name = $item['product_name'] ?? $item['recipe_title'] ?? 'Mushroom Item';
                        // නිෂ්පාදනයක් නම් product_price ද, රෙසිපි එකක් නම් recipe_price ද ලබා ගැනීම
                        $price = $item['product_price'] ?? $item['recipe_price'] ?? 0;
                        $subtotal = $price * $item['quantity'];
                        $total_price += $subtotal;
                    ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($name); ?></strong></td>
                            <td>Rs. <?= number_format($price, 2); ?></td>
                            <td><?= $item['quantity']; ?></td>
                            <td>Rs. <?= number_format($subtotal, 2); ?></td>
                            <td>
                                <a href="remove-cart.php?id=<?= $item['id']; ?>" style="color: #c62828; text-decoration: none; font-weight: bold;"><i class="fa-solid fa-trash"></i> Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
            <div style="background: white; padding: 20px; margin-top: 20px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                <h3 style="margin: 0; color: #1b4d3e;">Total: Rs. <?= number_format($total_price, 2); ?></h3>
                <a href="checkout.php" class="btn-checkout" style="float: none; margin: 0;">Proceed to Checkout</a>
            </div>
        <?php endif; ?>
    </div>

    <footer style="background: #1b4d3e; color: white; text-align: center; padding: 25px 0; margin-top: 60px;">
        <p style="margin: 0; font-size: 14px;">&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>

</body>
</html>