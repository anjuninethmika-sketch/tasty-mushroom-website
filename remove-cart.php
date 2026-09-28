<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $cart_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Delete the item from cart table based on cart id and user id
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
    $stmt->execute([$cart_id, $user_id]);
}

header("Location: cart.php");
exit();
?>