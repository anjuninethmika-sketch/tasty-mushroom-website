<?php
session_start();

$id = isset($_GET['id']) ? $_GET['id'] : 1;


$blogs = [
    1 => [
        "title" => "Top 5 Health Benefits of Eating Mushrooms",
        "category" => "Health",
        "content" => "Mushrooms are a nutrient-dense food source. They are low in calories, packed with fiber, and provide important vitamins like Vitamin D and B vitamins. Discovering how incorporating fresh mushrooms into your daily diet can boost your immunity, support heart health, and improve overall wellness makes them a wonderful addition to every meal prepared by Pradeep Bimmal's guidelines.",
        "image" => "images/blog1.jpg"
    ],
    2 => [
        "title" => "How to Grow Mushrooms at Home Easily",
        "category" => "Cultivation",
        "content" => "Growing mushrooms at home is a rewarding hobby. With a simple mushroom growing kit, proper moisture, and indirect sunlight, you can harvest fresh oyster or button mushrooms right in your kitchen. This beginner-friendly guide helps you start your small mushroom garden step by step.",
        "image" => "images/blog2.jpg"
    ],
    3 => [
        "title" => "The Secret to Perfectly Sautéed Mushrooms",
        "category" => "Cooking Tips",
        "content" => "To get golden, juicy, and flavorful mushrooms every single time, the secret is not overcrowding the pan and using the right amount of butter and olive oil. Learn the professional techniques to elevate your cooking instantly.",
        "image" => "images/blog3.jpg"
    ]
];

$post = isset($blogs[$id]) ? $blogs[$id] : $blogs[1];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $post['title']; ?> - Tasty Mushroom</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Back to Blog Button Style */
        .back-btn {
            display: inline-block;
            background-color: #1b4d3e;
            color: white !important;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s ease;
        }
        .back-btn:hover {
            background-color: #123329;
        }
    </style>
</head>
<body>
    <header>
        <div class="navbar">
            <a href="index.php" class="logo-area">
                <i class="fa-solid fa-mushroom" style="font-size: 28px; color: #2e8b57;"></i>
                <span>Tasty Mushroom <br><small style="font-size: 12px; color: #666;">with Pradeep Bimmal</small></span>
            </a>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="recipes.php">Recipes</a></li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="blog.php" class="active">Blog</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
    </header>

    <main class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.06);">
            <span style="background: #e8f5e9; color: #2e8b57; padding: 5px 12px; font-size: 12px; border-radius: 4px; font-weight: bold;"><?= $post['category']; ?></span>
            <h1 style="color: #1b4d3e; margin: 15px 0; font-size: 28px;"><?= $post['title']; ?></h1>
            <hr style="border: 0; border-top: 1px solid #eee; margin-bottom: 20px;">
            
            <p style="color: #444; font-size: 16px; line-height: 1.8;"><?= $post['content']; ?></p>
            
            <div style="margin-top: 30px;">
                <a href="blog.php" class="back-btn"><i class="fa-solid fa-arrow-left"></i> Back to Blog</a>
            </div>
        </div>
    </main>
</body>
</html>