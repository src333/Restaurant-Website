<!DOCTYPE html>

<?php
session_start();
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchester's - Reservations</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

    <style>
        /* Popup Styling */
        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .popup {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            text-align: center;
            max-width: 400px;
        }
        .popup h2 {
            margin-bottom: 10px;
            letter-spacing: 1px;
            
        }

        .popup p {
            letter-spacing: 1px;
            
        }
        .popup button {
            margin: 10px;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .popup button.login {
            background-color: #2c3e50;
            color: white;
        }
        .popup button.signup {
            background-color: #2c3e50;
            color: white;
        }
        .popup button.guest {
            background-color: #2c3e50;
            color: white;
        }
        .popup button:hover {
            opacity: 0.9;
        }

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

        .guest{
            background-color: #2c3e50;
        }

    </style>

</head>
<body>

    <?php if (!isset($_SESSION['user_id'])): ?>
        <div id="popup-overlay" class="popup-overlay">
            <div class="popup">
                <h2>Welcome to Lancaster's Reservations</h2>
                <p>Sign up or log in to view and manage your reservations. Or, continue as a guest to make a reservation.</p>
                <button class="login" onclick="location.href='login.php'">Log In</button>
                <button class="signup" onclick="location.href='signup.php'">Sign Up</button>
                <button class="guest" onclick="closePopup()">Continue as Guest</button>
            </div>
        </div>
    <?php endif; ?>

    
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


    <!-- Reservation Form -->
    <main class="reservation-main">
        <section class="reservation-section">
            <img src="images/logos/Lancaster's-logos_transparent.png" alt="Lancaster logo" class="about-intro-logo">
            <h1>Make a Reservation</h1>
            <p>
                We are happy to accommodate dietary requirements. Please just make a note in your reservation 
                or let us know upon arrival. Lancaster’s is on ground level, with an accessible bathroom 
                situated on the same floor.
            </p>
            <form class="reservation-form" action="submit_reservation.php" method="POST">
                <div class="form-group">
                    <label for="leadname">Lead Name:</label>
                    <input type="text" id="leadname" name="lead_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" pattern="[0-9]{10,15}" required>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" onchange="fetchAvailableTimes()" required>
                </div>
                <div class="form-group">
                    <label for="meal">Meal:</label>
                    <select class ="meal" id="meal" name="meal" onchange="fetchAvailableTimes()" required>
                        <option value="">Select Meal</option>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="guests">Number of Guests:</label>
                    <input type="number" id="guests" name="guests" min="1" max="6" onchange="fetchAvailableTimes()" required>
                </div>
                <div class="form-group">
                    <label for="time">Available Times:</label>
                    <select class= "time" id="time" name="time" required>
                        <option value="">Select a Time</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="requirements">Special Requirements:</label>
                    <textarea id="requirements" name="requirements" rows="4" placeholder="e.g., Dietary restrictions, wheelchair access"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="submit-button">Submit Reservation</button>
                </div>
            </form>

            <?php
            $submitted_data = $_POST;

            if (!empty($submitted_data)) {
                echo "<h1>Reservation Summary</h1>";
                echo "<dl>
                 <dt>Lead Name:</dt>
                 <dd>{$submitted_data['leadname']}</dd>
                 <dt>Email:</dt>
                 <dd><a href=\"mailto:{$submitted_data['email']}\">{$submitted_data['email']}</a></dd>
                 <dt>Phone:</dt>
                 <dd>{$submitted_data['phone']}</dd>
                 <dt>Date:</dt>
                 <dd>{$submitted_data['date']}</dd>
                 <dt>Meal:</dt>
                 <dd>{$submitted_data['meal']}</dd>
                 <dt>Number of Guests:</dt>
                 <dd>{$submitted_data['guests']}</dd>
                 <dt>Time:</dt><dd>{$submitted_data['time']}</dd>
                 <dt>Special Requirements:</dt>
                 <dd>{$submitted_data['requirements']}</dd>
                 </dl>";
            } else {
                echo "<p></p>";
            }
            ?>

        </section>

        <section id="restaurant-layout">
            <h2 style="color: white; letter-spacing: 2px; text-transform: uppercase;">Restaurant Layout</h2>
            <p style="color: white; letter-spacing: 2px; text-transform: uppercase;">Hover over tables to see their status.</p>
            <div id="floor-plan" class="floor-plan"></div>
        </section>


        <section id="user-reservations">
            <h2 style="color: white; letter-spacing: 2px; text-transform: uppercase;">Your Reservations</h2>
            <div id="reservations-list">
                <p>Loading your reservations...</p>
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


    <script>

    // Close the popup
    function closePopup() {
        const popup = document.getElementById('popup-overlay');
        if (popup) {
            popup.style.display = 'none';
        }
    }

    console.log("Script Loaded");

    // Function to handle reservation submission
    document.querySelector('.reservation-form').addEventListener('submit', async function (event) {
        event.preventDefault(); // Prevent default form submission

        const formData = new FormData(this);

        try {
            const response = await fetch('submit_reservation.php', {
                method: 'POST',
                body: formData,
            });

            const result = await response.json();

            if (response.ok && result.success) {
                showPopup('Reservation Confirmed!', 'Your reservation has been successfully submitted.', 'success');
                this.reset(); // Reset the form
            } else {
                throw new Error(result.error || 'An unknown error occurred.');
            }
        } catch (error) {
            console.error('Error submitting reservation:', error);
            showPopup('Reservation Failed', 'There was an issue with your reservation. Please try again.', 'error');
        }
    });

    // Function to display a pop-up message
    function showPopup(title, message, type) {
        const popupOverlay = document.createElement('div');
        popupOverlay.className = 'popup-overlay';

        const popup = document.createElement('div');
        popup.className = 'popup';

        const heading = document.createElement('h2');
        heading.textContent = title;
        popup.appendChild(heading);

        const paragraph = document.createElement('p');
        paragraph.textContent = message;
        popup.appendChild(paragraph);

        const closeButton = document.createElement('button');
        closeButton.textContent = 'Close';
        closeButton.onclick = () => document.body.removeChild(popupOverlay);
        closeButton.style.marginTop = '10px';
        popup.appendChild(closeButton);

        // Apply success or error styles
        if (type === 'success') {
            popup.style.border = '2px solid green';
        } else if (type === 'error') {
            popup.style.border = '2px solid red';
        }

        popupOverlay.appendChild(popup);
        document.body.appendChild(popupOverlay);
    }

    // Fetch available dates
    async function fetchAvailableDates() {
        try {
            const response = await fetch('fetch_available_dates.php');
            const availableDates = await response.json();

            if (availableDates.error) {
                console.error("Error fetching dates:", availableDates.error);
                return;
            }

            const datePicker = document.getElementById("date");
            if (availableDates.length > 0) {
                datePicker.setAttribute('min', availableDates[0]);
                datePicker.setAttribute('max', availableDates[availableDates.length - 1]);
            }
        } catch (error) {
            console.error("Error fetching available dates:", error);
        }
    }

    //console.log("Script Loaded");
            // Function to fetch available dates and update the date picker
    async function fetchAvailableDates() {
        try {
            const response = await fetch('fetch_available_dates.php');
            const availableDates = await response.json();

            if (availableDates.error) {
                console.error("Error fetching dates:", availableDates.error);
                return;
            }

            const datePicker = document.getElementById("date");

            // Assuming `availableDates` is an array of strings in the format 'YYYY-MM-DD'
            if (availableDates.length > 0) {
                const minDate = availableDates[0];
                const maxDate = availableDates[availableDates.length - 1];

                // Set `min` and `max` attributes on the date picker
                datePicker.setAttribute('min', minDate);
                datePicker.setAttribute('max', maxDate);
            }
        } catch (error) {
            console.error("Error fetching available dates:", error);
        }
    }

    // Function to fetch available times based on date, meal, and guests
    async function fetchAvailableTimes() {
        const date = document.getElementById("date").value;
        const meal = document.getElementById("meal").value;
        const guests = document.getElementById("guests").value;

        if (date && meal && guests) {
            try {
                const response = await fetch(`fetch_times.php?date=${date}&meal=${meal}&guests=${guests}`);
                const times = await response.json();

                const timeSelect = document.getElementById("time");
                timeSelect.innerHTML = ""; // Clear previous options

                if (times.error) {
                    console.error("Error fetching available times:", times.error);
                    return;
                }

                times.forEach(time => {
                    const option = document.createElement("option");
                    option.value = time;
                    option.textContent = time;
                    timeSelect.appendChild(option);
                });
            } catch (error) {
                console.error("Error fetching available times:", error);
            }
        }
    }

    async function fetchUserReservations() {
        try {
            const response = await fetch('fetch_user_reservations.php');
            const reservations = await response.json();

            const reservationsList = document.getElementById('reservations-list');
            reservationsList.innerHTML = ''; // Clear previous content

            if (reservations.error) {
                reservationsList.innerHTML = `<p>${reservations.error}</p>`;
                return;
            }

            if (reservations.length === 0) {
                reservationsList.innerHTML = '<p>You have no reservations yet.</p>';
                return;
            }

            // Create a styled table
            const table = document.createElement('table');
            table.className = 'reservations-table';
            table.innerHTML = `
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Guests</th>
                        <th>Lead Name</th>
                        <th>Requirements</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            `;

            const tbody = table.querySelector('tbody');
            reservations.forEach(reservation => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${reservation.reservation_date}</td>
                    <td>${reservation.reservation_time}</td>
                    <td>${reservation.guest_count}</td>
                    <td>${reservation.lead_name}</td>
                    <td>${reservation.requirements || 'N/A'}</td>
                `;
                tbody.appendChild(row);
            });

            reservationsList.appendChild(table);
        } catch (error) {
            console.error('Error fetching reservations:', error);
            document.getElementById('reservations-list').innerHTML = '<p>Error loading reservations.</p>';
        }
    }


    async function fetchTableLayout() {
        const date = document.getElementById("date").value;
        const meal = document.getElementById("meal").value;
        const time = document.getElementById("time").value; // Add selected time

        if (date && meal && time) { // Ensure all fields are filled
            try {
                const response = await fetch(`fetch_table_layout.php?date=${date}&meal=${meal}&time=${time}`);
                const data = await response.json();

                if (data.error) {
                    console.error(data.error);
                    return;
                }

                const floorPlan = document.getElementById("floor-plan");
                floorPlan.innerHTML = ""; // Clear previous layout

                data.tables.forEach(table => {
                    const tableDiv = document.createElement("div");
                    tableDiv.className = `table ${table.is_reserved ? 'reserved' : 'available'} ${table.orientation}`;
                    tableDiv.textContent = `Table ${table.table_number}`;
                    tableDiv.setAttribute('title', table.is_reserved ? 'Reserved' : 'Available');
                    floorPlan.appendChild(tableDiv);
                });
            } catch (error) {
                console.error("Error fetching table layout:", error);
            }
        }
    }


    document.getElementById("date").addEventListener("change", fetchTableLayout);
    document.getElementById("meal").addEventListener("change", fetchTableLayout);
    document.getElementById("time").addEventListener("change", fetchTableLayout);




 

    // Call the function when the page loads
    fetchUserReservations();

    

    // Fetch available dates on page load
    fetchAvailableDates();

    // Attach event listeners to fetch times dynamically
    document.getElementById("date").addEventListener("change", fetchAvailableTimes);
    document.getElementById("meal").addEventListener("change", fetchAvailableTimes);
    document.getElementById("guests").addEventListener("input", fetchAvailableTimes);

    </script>
</body>
</html>
