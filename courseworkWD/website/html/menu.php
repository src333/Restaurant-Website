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
    <section class="menuImage sm1">
        <img src="images/food/food-6.jpeg" alt="Welcome Image">
        <div class="menuOverlay" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            <h1 style="font-size: 58px; letter-spacing: 1px; color:white">Our Menu</h1>
            <a href="reservation.php" class="btn">Reservation</a>
        </div>
    </section>

<main class="menu-main">
    <h1 style="text-align: center;">Courses</h1>
    <section class="menus">
        <section class="menu-containers sm2">
           
            <h2 style="text-align: center;">First Course</h2>
            <ul style="text-align: center;">
                <p>Warm Onion Tart 12 </p>
                <p>Quickes Goats Cheese, Worcestershire and Shallots</p>
                <p>Venison Pâté en Croûte 13</p> 
                <p>Hedgerow Jelly, MAustard Fruit and Pistachio</p>
                <p>Lasagne of Rabbit Shoulder 12</p>
                <p>Mushrooms, Riesling and Thyme </p>
                <p>Grilled Beef Tongue 14</p>  
                <p>Quince, Aged Vinegar and Beetroot  </p>

            </ul>
        
        </section>

        <section class="menu-containers sm3">
            <h2 style="text-align: center;">Second Course</h2>
            <ul style="text-align: center;">
                <p>Roast Cornish Monkfish 28</p>
                <p>Cheek, Butternut Squash and Sage  </p>
                <p>Our Iberian Pork 32 </p> 
                <p>Jerusalem Artichoke and Pickled Walnuts </p>
                <p>Wareham Dorset Sika Deer 35</p> 
                <p>Pale Ale, Prune and Spring Onion </p>
                <p>Short Rib of Red Ruby Beef 35 </p>
                <p>Spinach, Chanterelles and Horseradish </p>

            </ul>
        
        </section>

        <section class="menu-containers sm4">
            <h2 style="text-align: center;">Third Course</h2>
            <ul style="text-align: center;">
                <p>Apple Parfait 8 </p>
                <p>Shortbread, Hazelnuts and Sherry </p>
                <p>Plum Ripple Ice Cream 7 </p>
                <p>Caramelised Pastry, Almond Cream and Camomile </p>
                <p>Custard Flan 8 </p>
                <p>Quince and Crème Fraîche </p>
                <p>Selection of Cheese 12</p>
                <p>Tunworth, Lincolnshire Poacher, Beauvale Blue Crackers and Homemade Chutney </p>

            </ul>
        </section>
        
    </section>

    <h1 style="text-align: center;">Tasters</h1>
    <section class="tasters">
        
        <section class="tasters-containers sm5">
            <h2 style="text-align: center;">Tasting Menu A</h2>
            <ul style="text-align: center;">
                <p>Warm Onion Tart </p>
                <p> Lasagne of Rabbit Shoulder </p>
                <p>Roast Cornish Monkfish </p>
                <p>Wareham Dorset Sika Deer </p>
                <p>Apple Parfait </p> 
                <p>60 </p>
            </ul>
        </section>

        <section class="tasters-containers sm5">
            <h2 style="text-align: center;">Tasting Menu B</h2>
            <ul style="text-align: center;">
                <p>Warm Onion Tart </p>
                <p> Lasagne of Rabbit Shoulder </p>
                <p>Roast Cornish Monkfish </p>
                <p>Wareham Dorset Sika Deer </p>
                <p>Apple Parfait </p> 
                <p>85 </p>
            </ul>
        
        </section>

        
    </section>
</main>

   <!-- Footer -->
   <<?php
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