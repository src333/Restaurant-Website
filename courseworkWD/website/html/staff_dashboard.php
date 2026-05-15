<?php
session_start();

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

// Redirect if not logged in or not staff
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    header("Location: login.php");
    exit();
}

// Connect to the database using the db_connect function
$conn = db_connect();
if ($conn === false) {
    throw new Exception("Database connection failed.");
}

// Fetch today's bookings
$today_date = date('Y-m-d');
$bookings_query = $conn->prepare("
    SELECT reservation_date, reservation_time, guest_count, lead_name, email, phone, requirements 
    FROM reservations 
    WHERE reservation_date = ?
    ORDER BY reservation_time
");
$bookings_query->bind_param("s", $today_date);
$bookings_query->execute();
$today_bookings = $bookings_query->get_result()->fetch_all(MYSQLI_ASSOC);

// Fetch services with available tables for the week
$empty_services_query = $conn->query("
    SELECT 
        s.id, 
        s.service_name, 
        s.day_of_week, 
        DATE_ADD(CURDATE(), INTERVAL (7 + (FIND_IN_SET(s.day_of_week, 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday') - FIND_IN_SET(DAYNAME(CURDATE()), 'Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday'))) % 7 DAY) AS service_date,
        s.start_time, 
        s.end_time, 
        s.total_tables,
        COALESCE(SUM(CEIL(r.guest_count / 2)), 0) AS reserved_tables,
        s.total_tables - COALESCE(SUM(CEIL(r.guest_count / 2)), 0) AS available_tables
    FROM services s
    LEFT JOIN reservations r 
        ON s.id = r.service_id 
        AND r.reservation_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
    GROUP BY s.id, s.service_name, s.day_of_week, s.start_time, s.end_time, s.total_tables
    ORDER BY FIELD(s.day_of_week, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'), s.start_time
");

$empty_services = $empty_services_query->fetch_all(MYSQLI_ASSOC);

// Fetch all reservations for the week
$weekly_bookings_query = $conn->query("
    SELECT 
        r.reservation_date, 
        r.reservation_time, 
        r.guest_count, 
        r.lead_name, 
        r.email, 
        r.phone, 
        r.requirements 
    FROM reservations r
    WHERE r.reservation_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 6 DAY)
    ORDER BY r.reservation_date, r.reservation_time
");
$weekly_bookings = $weekly_bookings_query->fetch_all(MYSQLI_ASSOC);

// Fetch job applications
$job_applications_query = $conn->query("
    SELECT id, name, email, phone, role, cv_file, applied_at
    FROM job_applications
    ORDER BY applied_at DESC
");

$job_applications = $job_applications_query->fetch_all(MYSQLI_ASSOC);


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        // AJAX to dynamically update service times and tables
        async function updateService(serviceId) {
            const formData = new FormData(document.getElementById(`service-form-${serviceId}`));
            try {
                const response = await fetch('update_service.php', {
                    method: 'POST',
                    body: formData
                });
                const result = await response.json();
                if (result.success) {
                    alert('Service updated successfully.');
                    location.reload();
                } else {
                    alert('Error updating service: ' + result.error);
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Failed to update service.');
            }
        }

        // Print reservations
        function printReservations() {
            const printContents = document.getElementById('printable-bookings').innerHTML;
            const newWindow = window.open('', '_blank');
            newWindow.document.write('<html><head><title>Print Reservations</title></head><body>');
            newWindow.document.write(printContents);
            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.print();
        }

        // Print all reservations for the week
        function printAllReservations() {
            const printContents = document.getElementById('weekly-bookings').innerHTML;
            const newWindow = window.open('', '_blank');
            newWindow.document.write('<html><head><title>Print All Reservations</title></head><body>');
            newWindow.document.write(printContents);
            newWindow.document.write('</body></html>');
            newWindow.document.close();
            newWindow.print();
        }

    </script>
    <style>
            /* General Styles */
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f4f4;
        color: #2c3e50;
        margin: 0;
        padding: 0;
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

    main {
        padding: 20px;
    }

    h2 {
        color: #2c3e50;
        font-size: 1.5rem;
        margin-bottom: 15px;
        border-bottom: 2px solid #2c3e50;
        padding-bottom: 5px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
        background-color: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    table th, table td {
        border: 1px solid #ddd;
        padding: 15px;
        text-align: center;
        font-size: 0.9rem;
    }

    table th {
        background-color: #2c3e50;
        color: white;
        font-weight: bold;
        text-transform: uppercase;
    }

    table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    table tr:hover {
        background-color: #ecf0f1;
    }

    button {
        padding: 10px 15px;
        background-color: #2c3e50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.2s ease-in-out, transform 0.2s ease-in-out;
    }

    button:hover {
        background-color: #34495e;
        transform: translateY(-2px);
    }

    button:active {
        transform: translateY(0);
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 15px;
        padding: 20px;
        background-color: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }

    form label {
        font-weight: bold;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    form input[type="time"],
    form input[type="number"] {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        width: 100%;
        font-size: 0.9rem;
    }

    form button {
        align-self: flex-end;
        font-size: 0.9rem;
    }

    /* Section Spacing */
    section {
        margin-bottom: 40px;
        padding: 20px;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    footer section{
        background-color: #2c3e50;
    }

    

    /* Hover Effects */
    a {
        color: #3498db;
        text-decoration: none;
        transition: color 0.2s ease-in-out;
    }

    a:hover {
        color: #1abc9c;
    }

    /* Table and Layout Highlights */
    table .available {
        background-color: #ecf0f1;
        color: #2c3e50;
    }

    table .reserved {
        background-color: #2c3e50;
        color: white;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        header nav ul {
            flex-direction: column;
            gap: 10px;
        }

        table th, table td {
            font-size: 0.8rem;
        }

        button {
            font-size: 0.9rem;
        }
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
<main>
    <section>
        <h2>Today's Bookings</h2>
        <div id="printable-bookings">
            <?php if (count($today_bookings) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Time</th>
                            <th>Party Size</th>
                            <th>Lead Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Special Requirements</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($today_bookings as $booking): ?>
                            <tr>
                                <td><?= htmlspecialchars($booking['reservation_time']) ?></td>
                                <td><?= htmlspecialchars($booking['guest_count']) ?></td>
                                <td><?= htmlspecialchars($booking['lead_name']) ?></td>
                                <td><?= htmlspecialchars($booking['email']) ?></td>
                                <td><?= htmlspecialchars($booking['phone']) ?></td>
                                <td><?= htmlspecialchars($booking['requirements'] ?: 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No bookings for today.</p>
            <?php endif; ?>
        </div>
        <button onclick="printReservations()">Print Reservations</button>
    </section>

    <section>
        <h2>Available Services for the Week</h2>
        <?php if (count($empty_services) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Date</th>
                        <th>Service</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Total Tables</th>
                        <th>Available Tables</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empty_services as $service): ?>
                        <tr>
                            <td><?= htmlspecialchars($service['day_of_week']) ?></td>
                            <td><?= htmlspecialchars($service['service_date']) ?></td>
                            <td><?= htmlspecialchars($service['service_name']) ?></td>
                            <td><?= htmlspecialchars($service['start_time']) ?></td>
                            <td><?= htmlspecialchars($service['end_time']) ?></td>
                            <td><?= htmlspecialchars($service['total_tables']) ?></td>
                            <td><?= htmlspecialchars($service['available_tables']) ?></td>
                            <td>
                                <form id="service-form-<?= $service['id'] ?>">
                                    <input type="hidden" name="service_id" value="<?= $service['id'] ?>">
                                    <label>Start Time: <input type="time" name="start_time" value="<?= htmlspecialchars($service['start_time']) ?>"></label>
                                    <label>End Time: <input type="time" name="end_time" value="<?= htmlspecialchars($service['end_time']) ?>"></label>
                                    <label>Total Tables: <input type="number" name="total_tables" value="<?= htmlspecialchars($service['total_tables']) ?>"></label>
                                    <button type="button" onclick="updateService(<?= $service['id'] ?>)">Update</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No services with available tables for the week.</p>
        <?php endif; ?>
    </section>

    <section>
        <h2>All Reservations for the Week</h2>
        <div id="weekly-bookings">
        <?php if (count($weekly_bookings) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Party Size</th>
                        <th>Lead Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Special Requirements</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($weekly_bookings as $booking): ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['reservation_date']) ?></td>
                            <td><?= htmlspecialchars($booking['reservation_time']) ?></td>
                            <td><?= htmlspecialchars($booking['guest_count']) ?></td>
                            <td><?= htmlspecialchars($booking['lead_name']) ?></td>
                            <td><?= htmlspecialchars($booking['email']) ?></td>
                            <td><?= htmlspecialchars($booking['phone']) ?></td>
                            <td><?= htmlspecialchars($booking['requirements'] ?: 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No reservations for the week.</p>
        <?php endif; ?>
        </div>

        <button onclick="printAllReservations()">Print All Reservations</button>

    </section>

    <section>
    <h2>Job Applications</h2>
    <?php if (count($job_applications) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>CV</th>
                    <th>Applied At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($job_applications as $application): ?>
                    <tr>
                        <td><?= htmlspecialchars($application['name']) ?></td>
                        <td><?= htmlspecialchars($application['email']) ?></td>
                        <td><?= htmlspecialchars($application['phone']) ?></td>
                        <td><?= htmlspecialchars($application['role']) ?></td>
                        <td>
                            <a href="<?= htmlspecialchars($application['cv_file']) ?>" target="_blank" download>
                                View CV
                            </a>
                        </td>
                        <td><?= htmlspecialchars($application['applied_at']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No job applications at the moment.</p>
    <?php endif; ?>
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
