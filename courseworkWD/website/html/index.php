<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchester's - Home</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <style>
        /* Styling for the header */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 50px;
            background-color: #2c3e50;
            color: #fff;
        }

       

        /* Right-side buttons */
        .nav-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .nav-right .btn {
            text-decoration: none;
            padding: 8px 16px;
            border: 1px solid #fff;
            border-radius: 4px;
            font-size: 14px;
            color: #fff;
            background-color: transparent;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .nav-right .btn:hover {
            background-color: #fff;
            color: #333;
        }

        

        .nav-right .btn-signup:hover {
            background-color: #fff;
            color: #333;
        }
    </style>
</head>
<body>

<?php
require_once ('/var/www/html/courseworkWD/courseworkWD/website/html/twig.php'); // Load the Twig environment

// Start the session and set user/session variables for Twig
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Dynamically get the current page name
$current_page = basename($_SERVER['PHP_SELF']); // e.g., 'index.php', 'menu.php'

// Define dynamic variables to pass into Twig
$variables = [
    'current_page' => $current_page,                  // Dynamically set the current page
    'user_is_logged_in' => isset($_SESSION['user_id']), // Check if user is logged in
    'user_role' => $_SESSION['role'] ?? null,          // User role (if logged in)
];

// Render the Twig template
echo $twig->render('header.twig', $variables);
?>

    <!-- Full-width image with overlay text and button -->
    <section class="home-image">
        <section class="homeImage">
            <img src="images/food/food-1.jpg" alt="Home Page Image">
            <div class="homeOverlay">
                <h2 style="letter-spacing: 1px; font-size: 50px;">What's New</h2>
                <a href="about.php" class="btn">Learn More</a>
            </div>
        </section>
    </section>

    <main class="home-main">
        <!-- Row with 3 Columns for Different Actions -->
        <section class="guide-container">
            <!-- Left Column: Decide What to Eat -->
            <div class="guide-section" style="text-align: center;">
                <img src="images/food/food-2.jpg" alt="Home Page Image">
                <div class="guideOverlay">
                    <h3>Decide What to Eat</h3>
                    <p style="font-size: smaller;">"Discover the perfect meal for any mood."</p>
                    <a href="menu.php" class="btn">Menu</a>
                </div>
            </div>
            <!-- Middle Column: Book Reservation -->
            <div class="guide-section" style="text-align: center;">
                <img src="images/rerestaurant/restaurant-3.jpg" alt="Home Page Image">
                <div class="guideOverlay">
                    <h3>Book a Reservation</h3>
                    <p style="font-size: smaller;">"Reserve your spot for an unforgettable experience."</p>
                    <a href="res.php" class="btn">Book Now</a>
                </div>
            </div>
            <!-- Right Column: Eat In With Us -->
            <div class="guide-section" style="text-align: center;">
                 <img src="images/rerestaurant/restaurant-4.jpg" alt="Home Page Image">
                 <div class="guideOverlay">
                    <h3>Eat In With Us</h3>
                    <p style="font-size: smaller;">"Join us and make every meal a memory."</p>
                    <a href="about.php#map-location" class="btn">Find Us</a>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <?php
// Include Twig
require_once ('/var/www/html/courseworkWD/courseworkWD/website/html/twig.php');

// Define dynamic variables to pass into Twig
$variables = [
    'current_page' => basename($_SERVER['PHP_SELF']), // Dynamically set current page
];

// Render the footer Twig template
echo $twig->render('footer.twig', $variables);
?>


</body>
</html>
