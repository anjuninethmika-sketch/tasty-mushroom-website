<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

// Handle Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_product'])) {
    $title = trim($_POST['title']);
    $desc = trim($_POST['description']);
    $price = trim($_POST['price']);

    if (!empty($title) && !empty($price)) {
        $stmt = $conn->prepare("INSERT INTO products (title, description, price) VALUES (?, ?, ?)");
        $stmt->execute([$title, $desc, $price]);
        header("Location: dashboard.php");
        exit();
    }
}

// Handle Delete Product
if (isset($_GET['delete_product'])) {
    $pid = intval($_GET['delete_product']);
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$pid]);
    header("Location: dashboard.php");
    exit();
}

// Fetch Products and Orders
$products = $conn->query("SELECT * FROM products ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
$orders = $conn->query("SELECT o.*, u.name as customer_name FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tasty Mushroom</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body style="background: #f4f6f4;">
    <header>
        <div class="navbar">
            <a href="dashboard.php" class="logo-area">
                <i class="fa-solid fa-mushroom" style="font-size: 28px; color: #2e8b57;"></i>
                <span>Admin Dashboard <br><small style="font-size: 12px; color: #666;">Pradeep Bimmal</small></span>
            </a>
            <ul class="nav-links">
                <li><a href="../index.php" target="_blank">View Website</a></li>
                <li><a href="../logout.php" style="color: #c62828;"><i class="fa-solid fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
    </header>

    <main class="container" style="max-width: 1200px; margin: 40px auto; padding: 0 20px;">
        
        <!-- Add Product Section -->
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 40px;">
            <h2 style="color: #1b4d3e; margin-bottom: 20px;"><i class="fa-solid fa-plus-circle"></i> Add New Mushroom Product</h2>
            <form action="dashboard.php" method="POST" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; align-items: end;">
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Product Title</label>
                    <input type="text" name="title" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Price (Rs.)</label>
                    <input type="number" step="0.01" name="price" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
                <div>
                    <label style="display: block; font-weight: bold; margin-bottom: 5px;">Description</label>
                    <input type="text" name="description" required style="width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px;">
                </div>
                <div>
                    <button type="submit" name="add_product" style="width: 100%; background: #2e8b57; color: white; border: none; padding: 11px; font-weight: bold; border-radius: 5px; cursor: pointer;">Add Product</button>
                </div>
            </form>
        </div>

        <!-- Products Management -->
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); margin-bottom: 40px;">
            <h2 style="color: #1b4d3e; margin-bottom: 20px;"><i class="fa-solid fa-box"></i> Manage Products</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9f9f9; text-align: left; border-bottom: 2px solid #ddd;">
                        <th style="padding: 10px;">Title</th>
                        <th style="padding: 10px;">Price</th>
                        <th style="padding: 10px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;"><?= htmlspecialchars($p['title']); ?></td>
                        <td style="padding: 10px; color: #2e8b57; font-weight: bold;">Rs. <?= number_format($p['price'], 2); ?></td>
                        <td style="padding: 10px;"><a href="dashboard.php?delete_product=<?= $p['id']; ?>" onclick="return confirm('Are you sure?');" style="color: #c62828; text-decoration: none;"><i class="fa-solid fa-trash"></i> Delete</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Customer Orders -->
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <h2 style="color: #1b4d3e; margin-bottom: 20px;"><i class="fa-solid fa-clipboard-list"></i> Customer Orders & Deliveries</h2>
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f9f9f9; text-align: left; border-bottom: 2px solid #ddd;">
                        <th style="padding: 10px;">Order ID</th>
                        <th style="padding: 10px;">Customer</th>
                        <th style="padding: 10px;">Total Amount</th>
                        <th style="padding: 10px;">Address</th>
                        <th style="padding: 10px;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($orders as $ord): ?>
                    <tr style="border-bottom: 1px solid #eee;">
                        <td style="padding: 10px;">#<?= $ord['id']; ?></td>
                        <td style="padding: 10px; font-weight: bold;"><?= htmlspecialchars($ord['customer_name']); ?></td>
                        <td style="padding: 10px; color: #2e8b57; font-weight: bold;">Rs. <?= number_format($ord['total_amount'], 2); ?></td>
                        <td style="padding: 10px; color: #666;"><?= htmlspecialchars($ord['shipping_address']); ?></td>
                        <td style="padding: 10px;"><span style="background: #e8f5e9; color: #2e8b57; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold;"><?= $ord['status']; ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    </main>
</body>
</html>