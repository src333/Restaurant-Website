<!DOCTYPE html>

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanchester's - Reservations</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="icon" href="favicon.ico" type="image/x-icon">

</head>
<body>
    <!-- Header -->
    <header>
        <img src="images/logos/Lancaster's-logos_white.png" alt="Lancaster's Logo">
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="gallery.html">Gallery</a></li>
                <li><a href="careers.html">Careers</a></li>
                <li><a href="menu.html">Menu</a></li>
                <li><a href="reviews.html">Reviews</a></li>
            </ul>
        </nav>
    </header>

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
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" onchange="fetchAvailableTimes()" required>
                </div>
                <div class="form-group">
                    <label for="meal">Meal:</label>
                    <select id="meal" name="meal" onchange="fetchAvailableTimes()" required>
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
                    <select id="time" name="time" required>
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
                echo "<p>No form data available.</p>";
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
    <footer>
        <div class="footer-container">
            <!-- Time Table -->
            <div class="footer-section">
                <h3>Opening Times</h3>
                <ul>
                    <li>Mon - Fri: 07:30 am - 11 pm</li>
                    <li>Sat: 9:00 am - 11:00 pm</li>
                    <li>Sun: 11:30 am - 10:00 pm</li>
                </ul>
            </div>

            <!-- Address -->
            <div class="footer-section">
                <h3>Address</h3>
                <p>
                    52 Haymarket<br>
                    London<br>
                    SW1Y 4RP
                </p>
            </div>

            <!-- Links -->
            <div class="footer-section">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="menu.html">Menu</a></li>
                    <li><a href="gallery.html">Gallery</a></li>
                    <li><a href="careers.html">Careers</a></li>
                    <li><a href="reviews.html">Reviews</a></li>
                </ul>
            </div>

            <!-- Social Media -->
            <div class="footer-section" style="text-align: center;"> 
                <h3>Follow Us</h3>
                <div class="footer-icons" style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="https://www.instagram.com/fallowrestaurant" target="_blank">
                        <img src="instaIcon.png" alt="Instagram" style="width: 24px; height: 24px;">
                        Instagram
                    </a>
                    <a href="https://www.tiktok.com/@fallow_restaurant?lang=en" target="_blank">
                        <img src="tiktokIcon.png" alt="TikTok" style="width: 24px; height: 24px;">
                        TikTok
                    </a>
                    <a href="https://www.youtube.com/channel/UCJ901NqoRaXMnIm7aOjLyuA" target="_blank">
                        <img src="youtubeIcon.png" alt="YouTube" style="width: 24px; height: 24px;">
                        YouTube
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2023 Lanchester's. All rights reserved.</p>
        </div>
    </footer>

    <script>
    console.log("Script Loaded");
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
