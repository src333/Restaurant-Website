<?php
header('Content-Type: application/json'); // Set content type to JSON
session_start(); // Start session to check user authentication

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';
try {
    // Debugging: Log the start of the script
    file_put_contents('debug_fetch_reservations.log', "Fetch User Reservations Script Started\n", FILE_APPEND);

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        file_put_contents('debug_fetch_reservations.log', "Error: Unauthorized access - User not logged in\n", FILE_APPEND);
        echo json_encode(['error' => 'Unauthorized access. Please log in to view your reservations.']);
        exit;
    }

    $user_id = $_SESSION['user_id'];
    file_put_contents('debug_fetch_reservations.log', "User ID: $user_id\n", FILE_APPEND);

    // Connect to the database using the db_connect function
    $conn = db_connect();
    if ($conn === false) {
        file_put_contents('debug_fetch_reservations.log', "Database Connection Failed: " . $conn->connect_error . "\n", FILE_APPEND);
        throw new Exception("Database connection failed.");
    }
    file_put_contents('debug_fetch_reservations.log', "Database Connected Successfully\n", FILE_APPEND);

    // Fetch reservations for the logged-in user
    $stmt = $conn->prepare("
        SELECT reservation_date, reservation_time, guest_count, lead_name, requirements 
        FROM reservations 
        WHERE user_id = ?
        ORDER BY reservation_date, reservation_time
    ");
    $stmt->bind_param("i", $user_id);

    // Debugging: Log the prepared statement
    file_put_contents('debug_fetch_reservations.log', "Prepared SQL Query: SELECT reservation_date, reservation_time, guest_count, lead_name, requirements FROM reservations WHERE user_id = $user_id ORDER BY reservation_date, reservation_time\n", FILE_APPEND);

    $stmt->execute();
    $result = $stmt->get_result();

    if (!$result) {
        file_put_contents('debug_fetch_reservations.log', "Error Executing Query: " . $stmt->error . "\n", FILE_APPEND);
        throw new Exception("Error fetching reservations.");
    }

    // Process the results
    $reservations = [];
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }

    file_put_contents('debug_fetch_reservations.log', "Fetched Reservations:\n" . print_r($reservations, true), FILE_APPEND);

    // Send response
    echo json_encode($reservations);

    $stmt->close();
    $conn->close();
    file_put_contents('debug_fetch_reservations.log', "Database Connection Closed\n", FILE_APPEND);

} catch (Exception $e) {
    // Handle any errors and log them
    file_put_contents('debug_fetch_reservations.log', "Error: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
