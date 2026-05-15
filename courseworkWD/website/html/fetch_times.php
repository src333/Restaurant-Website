<?php
header('Content-Type: application/json');

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

try {
    // Validate required parameters
    if (!isset($_GET['date'], $_GET['meal'], $_GET['guests'])) {
        echo json_encode(['error' => 'Invalid parameters']);
        exit;
    }

    $reservation_date = $_GET['date'];
    $meal = $_GET['meal'];
    $guests = (int)$_GET['guests'];

    // Connect to the database using the db_connect function
    $conn = db_connect();
    if ($conn === false) {
        throw new Exception("Database connection failed.");
    }

    // Step 1: Get service details
    $day_of_week = date('l', strtotime($reservation_date));
    $service_query = $conn->prepare("
        SELECT id, start_time, end_time, total_tables 
        FROM services 
        WHERE service_name = ? AND day_of_week = ?
    ");
    $service_query->bind_param("ss", $meal, $day_of_week);
    $service_query->execute();
    $service = $service_query->get_result()->fetch_assoc();

    if (!$service) {
        echo json_encode(['error' => 'Service not found']);
        exit;
    }

    $service_id = $service['id'];
    $start_time = strtotime($service['start_time']);
    $end_time = strtotime($service['end_time']);
    $total_tables = $service['total_tables'];
    $service_query->close();

    // Step 2: Fetch reserved slots
    $reserved_query = $conn->prepare("
        SELECT reservation_time, SUM(CEIL(guest_count / 2)) AS reserved_tables 
        FROM reservations 
        WHERE service_id = ? AND reservation_date = ? 
        GROUP BY reservation_time
    ");
    $reserved_query->bind_param("is", $service_id, $reservation_date);
    $reserved_query->execute();
    $reserved_slots = $reserved_query->get_result();

    $reserved = [];
    while ($row = $reserved_slots->fetch_assoc()) {
        $reserved[$row['reservation_time']] = $row['reserved_tables'];
    }

    // Step 3: Generate available time slots
    $available_slots = [];
    while ($start_time < $end_time) {
        $time_slot = date("H:i", $start_time);
        $tables_needed = ceil($guests / 2);

        // Check if the slot is fully reserved
        if (!isset($reserved[$time_slot]) || $reserved[$time_slot] + $tables_needed <= $total_tables) {
            $available_slots[] = $time_slot;
        }

        $start_time += 15 * 60; // Increment by 15 minutes
    }

    echo json_encode($available_slots);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} finally {
    if (isset($conn) && $conn->connect_error === null) {
        $conn->close();
    }
}
