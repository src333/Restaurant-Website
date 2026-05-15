<?php
header('Content-Type: application/json');
require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

try {
    if (!isset($_GET['date'], $_GET['meal'], $_GET['time'])) {
        echo json_encode(['error' => 'Missing parameters']);
        exit;
    }

    $reservation_date = $_GET['date'];
    $meal = $_GET['meal'];
    $selected_time = $_GET['time']; // Specific time selected by the user

    // Connect to the database using the db_connect function
    $conn = db_connect();
    if ($conn === false) {
        throw new Exception("Database connection failed.");
    }

    // Step 1: Get service_id for the meal and date
    $day_of_week = date('l', strtotime($reservation_date));
    $service_query = $conn->prepare("
        SELECT id, total_tables 
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
    $total_tables = $service['total_tables'];
    $service_query->close();

    // Step 2: Get reservations for the service at the specific time slot
    $reserved_query = $conn->prepare("
        SELECT SUM(CEIL(guest_count / 2)) AS reserved_tables 
        FROM reservations 
        WHERE service_id = ? AND reservation_date = ? AND reservation_time = ?
    ");
    $reserved_query->bind_param("iss", $service_id, $reservation_date, $selected_time);
    $reserved_query->execute();
    $reserved_count = $reserved_query->get_result()->fetch_assoc()['reserved_tables'] ?? 0;
    $reserved_query->close();

    // Step 3: Build table layout
    $tables = [];
    for ($i = 1; $i <= $total_tables; $i++) {
        $is_reserved = $i <= $reserved_count;

        $tables[] = [
            'table_number' => $i,
            'is_reserved' => $is_reserved,
            'orientation' => $i % 2 === 0 ? 'horizontal' : 'vertical'
        ];
    }

    echo json_encode(['tables' => $tables]);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
