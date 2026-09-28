<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// ඩේටාබෙස් එකෙන් කාට් එකේ තියෙන අයිතම ලබා ගැනීම
$stmt = $conn->prepare("SELECT c.*, p.title as product_title, p.price as product_price, r.title as recipe_title, r.price as recipe_price 
                        FROM cart c 
                        LEFT JOIN products p ON c.product_id = p.id 
                        LEFT JOIN recipes r ON c.recipe_id = r.id 
                        WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

// කාට් එක හිස් නම් ෂොප් එකට යවන්න
if (empty($cart_items)) {
    header("Location: shop.php");
    exit();
}

$msg = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $shipping_address = trim($_POST['address']);

    if (!empty($shipping_address)) {
        try {
            $conn->beginTransaction();

            // මුළු මුදල (Grand Total) ගණනය කිරීම
            $grand_total = 0;
            foreach ($cart_items as $item) {
                $price = $item['product_price'] ?? $item['recipe_price'] ?? 0;
                $grand_total += $price * $item['quantity'];
            }

            // Order එක ඇතුළත් කිරීම
            $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, status) VALUES (?, ?, ?, 'Pending')");
            $stmt->execute([$user_id, $grand_total, $shipping_address]);
            $order_id = $conn->lastInsertId();

            // Order Items ඇතුළත් කිරීම (products සහ recipes සඳහා)
            foreach ($cart_items as $item) {
                $price = $item['product_price'] ?? $item['recipe_price'] ?? 0;
                $pid = $item['product_id'];
                $rid = $item['recipe_id'];
                $qty = $item['quantity'];

                $item_stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, recipe_id, quantity, price) VALUES (?, ?, ?, ?, ?)");
                $item_stmt->execute([$order_id, $pid, $rid, $qty, $price]);
            }

            // සාර්ථකව order කළ පසු ඩේටාබෙස් එකෙන් කාට් එක හිස් කිරීම (Clear cart)
            $clear_cart = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
            $clear_cart->execute([$user_id]);

            $conn->commit();
            $success = true;
        } catch (Exception $e) {
            $conn->rollBack();
            $msg = "Checkout failed: " . $e->getMessage();
        }
    } else {
        $msg = "Please provide your shipping address.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Tasty Mushroom</title>
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
        </div>
    </header>

    <main class="container" style="max-width: 600px; margin: 40px auto; padding: 0 20px;">
        <div style="background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <?php if (isset($success) && $success): ?>
                <div style="text-align: center;">
                    <i class="fa-solid fa-circle-check" style="font-size: 50px; color: #2e8b57; margin-bottom: 15px;"></i>
                    <h2 style="color: #1b4d3e; margin-bottom: 10px;">Order Placed Successfully!</h2>
                    <p style="color: #666; margin-bottom: 20px;">Thank you for your order. We will deliver your fresh mushrooms soon.</p>
                    <a href="shop.php" style="background: #2e8b57; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold;">Continue Shopping</a>
                </div>
            <?php else: ?>
                <h2 style="color: #1b4d3e; margin-bottom: 20px;"><i class="fa-solid fa-truck-fast"></i> Shipping Details</h2>
                <?php if (!empty($msg)): ?>
                    <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 5px; margin-bottom: 15px;"><?= $msg; ?></div>
                <?php endif; ?>
                <form action="checkout.php" method="POST">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: bold; margin-bottom: 8px;">Delivery Address</label>
                        <textarea name="address" rows="4" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;" placeholder="Enter your full delivery address..."></textarea>
                    </div>
                    <button type="submit" style="width: 100%; background: #2e8b57; color: white; border: none; padding: 12px; font-size: 16px; font-weight: bold; border-radius: 5px; cursor: pointer;">Place Order</button>
                </form>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>