<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchester's - Home</title>
    <link rel="stylesheet" href="styles.css">
    <script src="web.js" defer></script>
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

    <!-- Header -->
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

    <!-- Main Content -->
    <main class="gallery-main">
        <h2 style="padding: 20px">Photo Gallery</h2>

        <section class="gallery-border">

        <!-- Food Gallery -->
        <section id="food-gallery">
            <h3>Food</h3>
            <div class="gallery-row">
                <img src="images/food/food-1.jpg" alt="Delicious Food 1">
                <img src="images/food/food-6.jpeg" alt="Delicious Food 6">
                <img src="images/food/food-2.jpg" alt="Delicious Food 2">
                <img src="images/food/food-3.jpg" alt="Delicious Food 3">
                <img src="images/food/food-4.jpg" alt="Delicious Food 4">
                <img src="images/food/food-5.jpg" alt="Delicious Food 5">
                <img src="images/food/food-7.jpg" alt="Delicious Food 7">
            </div>
        </section>

        <!-- Logos Gallery -->
        <section id="logo-gallery">
            <h3>Logos</h3>
            <div class="gallery-row">
                <img src="images/logos/Lancaster's-logos_black.png" alt="Lanchester's Logo 1">
                <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lanchester's Logo 2">
                <img src="images/logos/Lancaster's-logos_white.png" alt="Lanchester's Logo 3">
                <img src="images/logos/Lancaster's-logos.jpeg" alt="Lanchester's Logo 4">
            </div>
        </section>

        <!-- Gallery Section for People -->
        <section id="people-gallery">
            <h3>People</h3>
            <div class="gallery-row">
                <img src="images/people/ana-cooking.jpg" alt="ana-cooking" style="width: 65px; height: 65px;">
                <img src="images/people/ana-plating.jpg" alt="ana-plating" style="width: 65px; height: 65px;">
                <img src="images/people/ana-prep.jpg" alt="ana-prep"  style="width: 65px; height: 65px;">
                <img src="images/people/robert-bottle.jpg" alt="robert-bottle" style="width: 65px; height: 65px;">
                <img src="images/people/robert-check.jpg" alt="robert-check" style="width: 65px; height: 65px;">
                <img src="images/people/robert-glasses.jpg" alt="robert-glasses" style="width: 65px; height: 65px;">
                <img src="images/people/robert-pour.jpg" alt="robert-pour" style="width: 65px; height: 65px;">
                <img src="images/people/robert-smell.jpg" alt="robert-smell" style="width: 65px; height: 65px;">
            </div>
        </section>

        <!-- Gallery Section for Restaurant -->
        <section id="restaurant-gallery">
            <h3>Restaurant</h3>
            <div class="gallery-row">
                <img src="images/rerestaurant/restaurant-1.jpg" alt="Restaurant Interior 1" style="width: 65px; height: 65px;">
                <img src="images/rerestaurant/restaurant-2.jpg" alt="Restaurant Interior 2" style="width: 65px; height: 65px;">
                <img src="images/rerestaurant/restaurant-3.jpg" alt="Restaurant Interior 3" style="width: 65px; height: 65px;">
                <img src="images/rerestaurant/restaurant-4.jpg" alt="Restaurant Interior 4" style="width: 65px; height: 65px;">
            </div>
        </section>

        <!-- Gallery Section for Awards -->
        <section id="awards-gallery">
            <h3>Awards</h3>
            <div class="gallery-row" >
                <img src="images/awards/B-Corp-Logo-White-RGB.png" alt="B Corp Logo">
                <img src="images/awards/code-1.svg" alt="Code Award">
                <img src="images/awards/hotdinners.svg" alt="Hot Dinners">
                <img src="images/awards/National-Restaurant-Awards.svg" alt="National Restaurant Awards">
                <img src="images/awards/Squaremeal.svg" alt="Squaremeal">
            </div>
        </section>

        <!-- Modal Structure -->
    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal()">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <p style="text-align: center; letter-spacing: 1px; padding: 30px;">click on photo's to see them in full screen.</p>    
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
