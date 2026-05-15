<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchester's - Home</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
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
<body class="about-body">

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

    <main class="about-main">
    <section class="s1">
        <img src="images/logos/Lancaster's-logos_transparent.png" alt="lancaster logo" class="about-intro-logo">
        <h1>Our Story</h1>
            <p> Lancaster's was founded by chef Ana Lancaster and Sommelier Robert Lancaster in May 2005. The essence of this combination makes up much of Fallows DNA, where conscious culinary creativity meets hospitality experience and passion for wine. What followed from their meeting were a series of sold-out residencies to establish Lancaster’s as one of the most exciting restaurant concepts on the UK restaurant scene. Lancaster’s permanent home in St James’s market was established in November 2010 and has since attracted a string of awards including both the Marie Claire and GQ ‘sustainable restaurant of the year’ and the Caterer award for ‘best new restaurant’. 
                </p>
                ..
            <p>  </p>
            <p> Keep yourself updated by following us on Instagram. For collaborations please contact marketing@lancasters.com For business opportunities please contact Robert Lancaster at office@ lancasters.com.</p>

    </section>

     <!-- Social Media Section -->
     
    <section class="social-media s2" >
        <h2>Lanchester's Media</h2>
        <div class="social-icons">

            <!-- Instagram Embed with Icon Overlay -->
        <div class="social-icon s-icon1" style="position: relative; width: 100%; max-width: 340px;">
            <!-- Instagram Post Embed Code -->
            <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-permalink="https://www.instagram.com/reel/DB0w4GYo-Fn/?utm_source=ig_embed&amp;utm_campaign=loading" data-instgrm-version="14" >
                <a href="https://www.instagram.com/reel/DB0w4GYo-Fn/?utm_source=ig_embed&amp;utm_campaign=loading" target="_blank">
                    <!-- This area automatically displays the Instagram embed content -->
                </a>
            </blockquote>
            <script async src="//www.instagram.com/embed.js"></script>

        </div>

            <!-- YouTube Embed with Icon Overlay -->
        <div class="social-icon s-icon2" style="position: relative; width: 100%; max-width: 540px; margin-top: 20px;">
            <!-- YouTube Video Embed Code -->
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/BPl_G3NRUnk" frameborder="0" allowfullscreen ></iframe>

        </div>
            
        <div class="social-icon s-icon3" style="position: relative; width: 100%; max-width: 325px;">
                <!-- TikTok Video Embed -->
                <blockquote class="tiktok-embed" cite="https://www.tiktok.com/@fallow_restaurant/video/7413742264175889696" data-video-id="7413742264175889696" style="width: 100%; max-width: 325px;">
                    <section></section>
                </blockquote>
                <script async src="https://www.tiktok.com/embed.js"></script> 
                
        </div>
                

            
       
    </section>

    <!-- Address Section -->
    <section id="map-location" class="location s3">
        <h2>Our Location</h2>
        <p>Address: 52 Haymarket, London, SW1Y 4RP</p>
        
        <!-- Embedded Google Map -->
        <div class="map-icon" style="width: 100%; max-width: 615px; margin: auto;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.214316551093!2d-0.1330166000000472!3d51.509284000000015!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604d1648bb62d%3A0x930a46e035a5941e!2s52%20Haymarket%2C%20London%20SW1Y%204RP!5e0!3m2!1sen!2suk!4v1731608184478!5m2!1sen!2suk" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </section>

    <!-- Opening Hours Section -->
    <section class="hours">
        <h2>Opening Times</h2>
        <ul>
            <li>Mon - Fri: 07:30 am - 11:00 pm</li>
            <li>Sat: 9:00 am - 11:00 pm</li>
            <li>Sun: 11:30 am - 10:00 pm</li>
        </ul>
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



