<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchester's - Reviews</title>
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

    <main class="rev-main">
        <!-- the main reviews section with customer and staff reviews in -->
        <section class="reviews">
            <h2>What Our Customers Say</h2>
            <p style="text-align: center;">“Style and substance in equal - and environmentally conscious - measure” CONDÉ NAST TRAVELLER</p>
            <div class="reviews-container">
                <!-- review boxes ofclients all with same class for consistent styling -->
                <article class="review">
                    <h3>Handyspanner</h3>
                    <p class="review-text">"Nice food but cramped and erratic dining experience. The corn ribs and mushroom parfait were excellent, but the service was rushed. A hectic atmosphere, with some concerns about pets in the restaurant."</p>
                    <details>
                        <summary>Full Review</summary>
                        <ul>
                            <p> "Came for lunch, enjoyed the corn ribs and mushroom parfait to start, then we had pork roast. The vegetables, roasties and meat could not be faulted.
                                The negative bit was the service, we had to chase our drinks(3 times) and our server was a little erratic and rushed.
                                A very busy place, luckily we were three and were given a table for four. It was a little tight for couples who appeared “crammed “ on small tables for two that were close together.
                                Nice food but a hectic and confined eating experience. Also question people being allowed to bring dogs into the restaurant, also allowing it to feed there."
                                </p>
                        </ul>
                    </details>
                    <p class="rating">Rating: ★★★☆☆</p>
                </article>

                <article class="review">
                    <h3>Elizabeth S.</h3>
                    <p class="review-text">"Yum! The mushroom parfait, ribs, and strawberry custard cream were delightful. The server was attentive and knowledgeable. Highly recommend."</p>
                    <details>
                        <summary>Full Review</summary>
                        <ul>
                            <p> "Yum, Had a great dinner here during our trip to London from the states. Highly recommend the mushroom parfait, ribs, and strawberry custard cream. The mussels and burger were also very good. Server was attentive and had great knowledge of the menu."
                                </p>
                        </ul>
                    </details>
                    <p class="rating">Rating: ★★★★★</p>
                </article>

                <article class="review">
                    <h3>BJM</h3>
                    <p class="review-text">"Stunning food! The corn ribs and croquettes were to die for, and the main courses exceeded expectations. The Chelsea tart was a perfect ending to a fantastic meal."</p>
                    <details>
                        <summary>Full Review</summary>
                        <ul>
                            <p> "Booked to dine here on a Friday night having been a fan of the owners YouTube account for a while now. The restaurant was busy but we got seated straight away and were given water by the waiter. We were left with the menu for 10 mins or so and then ordered our drinks and food.
                                Between the two of us we had the corn ribs and croquettes to start and for main sirloin steak and the halibut tikka with muscles. We both went for the Chelsea tart for dessert.
                                I was slightly worried that it wouldn't live up to expectations given how much I'd hyped it up in the build up but it was genuinely one of the best meals I've had all year. Some of the most flavoursome, lip smacking, finger licking food I've ever eaten. I could eat those corn ribs every day for the rest of my life and never get bored. Absolutely adored this place and will definitely return when I'm next in London
                                "
                                </p>
                        </ul>
                    </details>
                    <p class="rating">Rating: ★★★★★</p>
                </article>

                <article class="review">
                    <h3>Christopher A.</h3>
                    <p class="review-text">"Exceptional food and great atmosphere. The mushroom parfait and beef ribs were sensational. Can't wait to return!"</p>
                    <details>
                        <summary>Full Review</summary>
                        <ul>
                            <p> "Excellent food and great atmosphere,Exceptional food combined with wonderful service - the mushroom parfait and the beef ribs were sensational.
                                Can't wait to return!
                                "
                                </p>
                        </ul>
                    </details>
                    <p class="rating">Rating: ★★★★★</p>
                </article>

                <article class="review">
                    <h3>Mandy A.</h3>
                    <p class="review-text">"Fantastic vibe, service, staff, and food. Friendly staff, knowledgeable servers, and incredible food. A must-visit spot!"</p>
                    <details>
                        <summary>Full Review</summary>
                        <ul>
                            <p> "Fantastic vibe, service, staff and food.,My brother and I have been following Fallow on social media for some time and finally decided to take a visit with our partners.
                                On arrival, staff were friendly and helpful and we were taken to our table.
                                The restaurant has a great vibe and watching the chefs (or should i say artists) at work is just something else.
                                We ordered a few things off the menu to start as there was so much choice and we wanted it all!
                                Our server was knowledgeable and explained what was not available and what he would recommend too.
                                What makes for amazing service. Offering drinks when they can see our drinks were running low. All without being asked.
                                Table wiped between courses.
                                Friendly, happy staff. Just great.
                                The food was 10/10 and my husband says its the best burger he's ever had!
                                We unfortunately didn't order dessert as we were too full but will do next time we visit.
                                All in all a fantastic visit. We really couldn't fault any of it. Staff, vibe, service and food all just fantastic. Well done Fallow we are already planning our next visit.
                                "
                                </p>
                        </ul>
                    </details>
                    <p class="rating">Rating: ★★★★★</p>
                </article>

                <article class="review">
                    <h3>Tom C.</h3>
                    <p class="review-text">"Great brunch! Delicious food and 5-star service. This restaurant is performing at every level."</p>
                    <details>
                        <summary>Full Review</summary>
                        <ul>
                            <p> "Great brunch, Just had brunch food delicious service 5star this restaurant is performing at every level we just love coming back. If you’re anywhere near it’s a must book as very busy.
                                "
                                </p>
                        </ul>
                    </details>
                    <p class="rating">Rating: ★★★★★</p>
                </article>
            </div>
        </section>

        <!-- staff review section -->
        <section class="staff-testimonials">
            <h2>What Our Team Members Say</h2>
            <div class="testimonials-container">
                <article class="testimonial">
                    <h3>Samantha P. - Sous Chef</h3>
                    <p class="testimonial-text">"Working at Lanchester's has been an incredible journey. The team is like family, and I love the creative freedom I get in the kitchen."</p>
                </article>
                <article class="testimonial">
                    <h3>David L. - Waiter</h3>
                    <p class="testimonial-text">"The positive energy here is infectious. It's a joy to come to work and see customers leave with a smile on their faces."</p>
                </article>
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
