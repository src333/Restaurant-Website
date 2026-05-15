<?php
header('Content-Type: application/json'); // Set content type to JSON

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

try {
    // Database connection
    // Connect to the database using the db_connect function
    $conn = db_connect();
    if ($conn === false) {
        throw new Exception("Database connection failed.");
    }

    // Fetch distinct `day_of_week` from the services table
    $service_query = $conn->query("SELECT DISTINCT day_of_week FROM services");
    if (!$service_query) {
        throw new Exception("Error fetching services: " . $conn->error);
    }

    $days_of_week = [];
    while ($row = $service_query->fetch_assoc()) {
        $days_of_week[] = $row['day_of_week'];
    }

    // Map PHP's `date()` day format to `day_of_week` in the `services` table
    $day_map = [
        'Monday' => 'Monday',
        'Tuesday' => 'Tuesday',
        'Wednesday' => 'Wednesday',
        'Thursday' => 'Thursday',
        'Friday' => 'Friday',
        'Saturday' => 'Saturday',
        'Sunday' => 'Sunday',
    ];

    // Generate dates for the next 7 days
    $available_dates = [];
    for ($i = 0; $i < 7; $i++) {
        $current_date = date('Y-m-d', strtotime("+$i days"));
        $current_day = date('l', strtotime($current_date));

        if (in_array($day_map[$current_day], $days_of_week)) {
            $available_dates[] = $current_date;
        }
    }

    echo json_encode($available_dates);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($conn) && $conn->connect_error === null) {
        $conn->close();
    }
}
?>
