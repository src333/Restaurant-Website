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

    <main class="careers-main">
        <!-- Hero Section with Join Our Team Image and Text -->
        <section class="careers-hero">
            <img src="images/food/food-1.jpg" alt="Join Our Team" style="border-radius: 10px;">
            <h2 class="careersOverlay">Join Our Team</h2>
        </section>
    
        <!-- Job Vacancies Section -->
        <section id="job-vacancies" class="job-containers" style="padding: 20px;">
            <h3>Current Openings</h3>
    
            <!-- Flexbox container -->
            <div class="flex-container">
                <!-- Left: Job Boxes -->
                <div class="job-boxes">
                    <!-- Job Box Example -->
                    <div class="waiter-job-box job-box">
                        <h4>Waiter</h4>
                        <details>
                            <summary>Job Description</summary>
                            <ul>
                                <li>Provide excellent customer service to patrons.</li>
                                <li>Take orders and serve food and drinks.</li>
                                <li>Maintain cleanliness in the dining area.</li>
                            </ul>
                        </details>
                        <details>
                            <summary>Shift Timetable & Hours</summary>
                            <ul>
                                <li>Available shifts: Morning (8am-4pm), Evening (4pm-12am).</li>
                                <li>Flexible hours based on weekly schedule.</li>
                            </ul>
                        </details>
                        <button onclick="location.href='apply.php?role=Waiter'">Apply Now</button>
                    </div>
    
                    <!-- Add other job boxes like Chef, Manager, Cleaner, etc., in the same format -->
                    <!-- Chef Job Box -->
                    <div class="chef-job-box job-box">
                        <h4>Chef</h4>
                        <details>
                            <summary>Job Description</summary>
                            <ul>
                                <li>Responsible for preparing and cooking menu items to perfection.</li>
                                <li>Manage kitchen staff and ensure food quality and safety.</li>
                                <li>Maintain cleanliness and organization in the kitchen.</li>
                            </ul>
                        </details>
                        <details>
                            <summary>Shift Timetable & Hours</summary>
                            <ul>
                                <li>Available shifts: Morning (6am-2pm), Evening (2pm-10pm).</li>
                                <li>Full-time and part-time positions available.</li>
                            </ul>
                        </details>
                        <button onclick="location.href='apply.php?role=Chef'">Apply Now</button>
                    </div>
    
                    <!-- Additional job boxes... -->
                </div>
    
                <!-- Right: Why Join Us Section -->
                <div class="why-join-us-section">
                    <div class="why-join-us">
                        <h3>Why Join Us</h3>
                        <div class="why-join-us-content">
                            <img src="images/chefs/chef3.jpg" alt="Happy Team Member" class="circle-img">
                            <p>"Our team members consistently recommend us as a great place to work, with a collaborative and vibrant environment that supports growth."</p>
                        </div>
                    </div>
    
                    <div class="why-join-us">
                        <h3>Why Join Us</h3>
                        <div class="why-join-us-content">
                            <img src="images/chefs/chef2.jpg" alt="Engaged Staff" class="circle-img">
                            <p>"We provide excellent training, flexible hours, and opportunities for advancement within the restaurant industry."</p>
                        </div>
                    </div>
    
                    <div class="why-join-us">
                        <h3>Why Join Us</h3>
                        <div class="why-join-us-content">
                            <img src="images/chefs/chef1.jpg" alt="Celebrating Success" class="circle-img">
                            <p>"We celebrate the success of our staff, offering recognition programs and a supportive workplace culture."</p>
                        </div>
                    </div>
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