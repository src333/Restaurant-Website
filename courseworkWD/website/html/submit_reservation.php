<?php
session_start(); // Start the session for user authentication

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';


header('Content-Type: application/json'); // Ensure output is JSON



$response = []; // Array to store the response

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        // Capture user ID if logged in, otherwise set to NULL for guest
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

        // Sanitize and validate user inputs
        $reservation_date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_STRING);
        $reservation_time = filter_input(INPUT_POST, 'time', FILTER_SANITIZE_STRING);
        $guest_count = filter_input(INPUT_POST, 'guests', FILTER_VALIDATE_INT);
        $lead_name = filter_input(INPUT_POST, 'lead_name', FILTER_SANITIZE_STRING);
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
        $meal = filter_input(INPUT_POST, 'meal', FILTER_SANITIZE_STRING);
        $requirements = isset($_POST['requirements']) ? htmlspecialchars($_POST['requirements']) : null;

        // Input validation
        if (!$reservation_date || !$reservation_time || !$guest_count || !$lead_name || !$email || !$phone || !$meal) {
            throw new Exception("All fields are required.");
        }
        if ($guest_count < 1 || $guest_count > 6) {
            throw new Exception("Guest count must be between 1 and 6.");
        }

    
        $conn = db_connect();
        //include 'db_connect.php'; 

        // Validate `service_id` from the `services` table
        $day_of_week = date('l', strtotime($reservation_date)); // Convert date to day of the week
        $service_query = $conn->prepare("
            SELECT id, total_tables 
            FROM services 
            WHERE service_name = ? AND day_of_week = ?
        ");
        $service_query->bind_param("ss", $meal, $day_of_week);
        $service_query->execute();
        $result = $service_query->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("No available service found for the selected meal and day.");
        }

        $service = $result->fetch_assoc();
        $service_id = $service['id'];
        $total_tables = $service['total_tables'];
        $service_query->close();

        // Check table availability
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
        $reserved_query->close();

        // Check if the selected time has enough available tables
        $tables_needed = ceil($guest_count / 2);
        if (isset($reserved[$reservation_time]) && $reserved[$reservation_time] + $tables_needed > $total_tables) {
            throw new Exception("Not enough tables available for the selected time slot.");
        }

        // Insert reservation into the `reservations` table
        $stmt = $conn->prepare("
            INSERT INTO reservations (user_id, service_id, reservation_date, reservation_time, guest_count, lead_name, email, phone, requirements)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $stmt->bind_param(
            "iississss",
            $user_id,
            $service_id,
            $reservation_date,
            $reservation_time,
            $guest_count,
            $lead_name,
            $email,
            $phone,
            $requirements
        );

        if ($stmt->execute()) {
            $response = ['success' => true, 'message' => 'Reservation successfully made!'];
        } else {
            throw new Exception("Failed to create reservation: " . $stmt->error);
        }

        $stmt->close();
        $conn->close();
    } else {
        throw new Exception("Invalid request method.");
    }
} catch (Exception $e) {
    // Return error response as JSON
    $response = ['success' => false, 'error' => $e->getMessage()];
}

// Output the JSON response
echo json_encode($response);
