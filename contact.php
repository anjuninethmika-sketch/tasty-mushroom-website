<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tasty_mushroom"; // ඔයාගේ database නම මෙතැනට දාන්න

$conn = new mysqli($servername, $username, $password, $dbname);

$error_msg = "";

// Form එක submit වුණාම ක්‍රියාත්මක වේ
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        
        if ($stmt->execute()) {
            $stmt->close();
            $conn->close();
            // Session එකක් හරහා සාර්ථක පණිවිඩය සේව් කරගැනීම
            $_SESSION['success_msg'] = "Your message has been sent successfully!";
            header("Location: contact.php");
            exit();
        } else {
            $error_msg = "Something went wrong. Please try again!";
        }
        $stmt->close();
    } else {
        $error_msg = "Please fill in all fields.";
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Tasty Mushroom</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .contact-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }
        @media (max-width: 768px) {
            .contact-container {
                grid-template-columns: 1fr;
            }
        }
        .contact-info-card, .contact-form-card {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border: 1px solid #eaeaea;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: bold;
            font-size: 14px;
        }
        .form-group input, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
        }
        .form-group input:focus, .form-group textarea:focus {
            border-color: #2e8b57;
            outline: none;
        }
        .submit-btn {
            background: #2e8b57;
            color: white;
            border: none;
            padding: 12px 20px;
            width: 100%;
            border-radius: 5px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .submit-btn:hover {
            background: #246d44;
        }
        .social-icons {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: #e8f5e9;
            color: #2e8b57;
            border-radius: 50%;
            text-decoration: none;
            font-size: 18px;
            transition: 0.3s;
        }
        .social-icons a:hover {
            background: #2e8b57;
            color: white;
        }
        .alert-success {
            background: #e8f5e9;
            color: #2e8b57;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
        }
        .alert-error {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
            font-weight: bold;
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
                <li><a href="shop.php">Shop</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="contact.php" class="active" style="color: #2e8b57; font-weight: bold;">Contact</a></li>
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
        <h1 style="color: #1b4d3e; font-size: 32px; margin-bottom: 10px;">Contact Us</h1>
        <p style="color: #666; font-size: 16px;">We would love to hear from you! Send us your questions or feedback.</p>
    </section>

    <!-- Contact Section -->
    <div class="contact-container">
        
        <!-- Left Side: Information & Map -->
        <div class="contact-info-card">
            <h3 style="color: #1b4d3e; margin-bottom: 20px; font-size: 22px;">Get in Touch</h3>
            
            <p style="color: #666; margin-bottom: 15px; display: flex; align-items: flex-start; gap: 12px;">
                <i class="fa-solid fa-location-dot" style="color: #2e8b57; font-size: 18px; margin-top: 3px;"></i> 
                <span>Main Street, Mushroom Farm, Koswatta, Kalawana, Ratnapura, Sri Lanka</span>
            </p>
            <p style="color: #666; margin-bottom: 15px; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-phone" style="color: #2e8b57; font-size: 18px;"></i> 
                <span>+94 77 123 4567</span>
            </p>
            <p style="color: #666; margin-bottom: 20px; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-envelope" style="color: #2e8b57; font-size: 18px;"></i> 
                <span>Info@pradeppmushroom@gmail.com</span>
            </p>

            <h4 style="color: #333; margin-bottom: 10px; font-size: 16px;">Connect with us:</h4>
            <div class="social-icons">
                <a href="#" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                <a href="#" target="_blank"><i class="fa-brands fa-instagram"></i></a>
                <a href="#" target="_blank"><i class="fa-brands fa-whatsapp"></i></a>
                <a href="#" target="_blank"><i class="fa-brands fa-youtube"></i></a>
            </div>

            <!-- Google Map Embed for Koswatta, Kalawana, Ratnapura -->
            <div style="margin-top: 25px; border-radius: 8px; overflow: hidden; border: 1px solid #ddd;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63385.04561081191!2d80.375!3d6.433!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae3e35182962bfb%3A0x6b306e001c37b750!2sKalawana!5e0!3m2!1sen!2slk!4v1700000000000!5m2!1sen!2slk" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>

        <!-- Right Side: Contact Form -->
        <div class="contact-form-card">
            <h3 style="color: #1b4d3e; margin-bottom: 20px; font-size: 22px;">Send Us a Message</h3>
            
            <!-- මැසේජ් එක සාර්ථකව යැවුණු පසු session එක මඟින් පෙන්වා එය වහාම මකා දැමේ -->
            <?php if (isset($_SESSION['success_msg'])): ?>
                <div class="alert-success">
                    <?php 
                        echo $_SESSION['success_msg']; 
                        unset($_SESSION['success_msg']); // පෙන්වූ පසු නැවත නොපෙන්වීම සඳහා unset කිරීම
                    ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_msg)): ?>
                <div class="alert-error"><?php echo $error_msg; ?></div>
            <?php endif; ?>

            <form action="contact.php" method="POST">
                <div class="form-group">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>
                <div class="form-group">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="message">Your Message</label>
                    <textarea id="message" name="message" rows="5" placeholder="Type your message here..." required></textarea>
                </div>
                <button type="submit" class="submit-btn">
                    <i class="fa-solid fa-paper-plane"></i> Send Message
                </button>
            </form>
        </div>

    </div>

    <!-- Footer -->
    <footer style="background: #1b4d3e; color: white; text-align: center; padding: 25px 0; margin-top: 60px;">
        <p style="margin: 0; font-size: 14px;">&copy; 2026 Tasty Mushroom with Pradeep Bimmal. All rights reserved.</p>
    </footer>

</body>
</html>