<?php
header('Content-Type: application/json');
session_start();

require_once '/var/www/html/courseworkWD/courseworkWD/website/html/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'staff') {
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

// Connect to the database
$conn = db_connect();
if ($conn === false) {
    die('Database connection error: ' . mysqli_connect_error());
}

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service_id = $_POST['service_id'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $total_tables = $_POST['total_tables'];

    $stmt = $conn->prepare("UPDATE services SET start_time = ?, end_time = ?, total_tables = ? WHERE id = ?");
    $stmt->bind_param("ssii", $start_time, $end_time, $total_tables, $service_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['error' => 'Invalid request method']);
}

$conn->close();
?>
