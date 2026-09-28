<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $recipe_id = isset($_POST['recipe_id']) ? $_POST['recipe_id'] : null;

    if ($product_id) {
        // Fetch product price from products table
        $prod_stmt = $conn->prepare("SELECT price FROM products WHERE id = ?");
        $prod_stmt->execute([$product_id]);
        $product = $prod_stmt->fetch(PDO::FETCH_ASSOC);
        $price = $product ? $product['price'] : 0;

        // Check if product is already in cart
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?")->execute([$user_id, $product_id]);
        } else {
            $conn->prepare("INSERT INTO cart (user_id, product_id, price, quantity) VALUES (?, ?, ?, 1)")->execute([$user_id, $product_id, $price]);
        }
        header("Location: cart.php");
        exit();
    } 
    
    if ($recipe_id) {
        // Fetch recipe price from recipes table
        $rec_stmt = $conn->prepare("SELECT price FROM recipes WHERE id = ?");
        $rec_stmt->execute([$recipe_id]);
        $recipe = $rec_stmt->fetch(PDO::FETCH_ASSOC);
        $price = $recipe ? $recipe['price'] : 0;

        // Check if recipe is already in cart
        $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND recipe_id = ?");
        $stmt->execute([$user_id, $recipe_id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            $conn->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND recipe_id = ?")->execute([$user_id, $recipe_id]);
        } else {
            $conn->prepare("INSERT INTO cart (user_id, recipe_id, price, quantity) VALUES (?, ?, ?, 1)")->execute([$user_id, $recipe_id, $price]);
        }
        header("Location: cart.php");
        exit();
    }
}

header("Location: cart.php");
exit();
?>